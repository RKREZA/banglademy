<?php

namespace Modules\Bkash\Http\Controllers;

use App\Http\Controllers\DepositController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BkashController extends Controller
{
    private $base_url;
    private $app_key;
    private $app_secret;
    private $username;
    private $password;

    public function __construct()
    {

        $bkash_app_key = env('BKASH_APP_KEY');
        $bkash_app_secret = env('BKASH_APP_SECRET');
        $bkash_username = env('BKASH_USERNAME');
        $bkash_password = env('BKASH_PASSWORD');
        if (env('IS_BKASH_LOCALHOST')) {
            $bkash_base_url = 'https://checkout.sandbox.bka.sh/v1.2.0-beta';
        } else {
            $bkash_base_url = 'https://checkout.pay.bka.sh/v1.2.0-beta';
        }

        $this->app_key = $bkash_app_key;
        $this->app_secret = $bkash_app_secret;
        $this->username = $bkash_username;
        $this->password = $bkash_password;
        $this->base_url = $bkash_base_url;
    }

    public function getToken()
    {
        session()->forget('bkash_token');

        $post_token = array(
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret
        );

        $url = curl_init("$this->base_url/checkout/token/grant");
        $post_token = json_encode($post_token);
        $header = array(
            'Content-Type:application/json',
            "password:$this->password",
            "username:$this->username"
        );
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $post_token);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);

        $response = json_decode($resultdata, true);

        if (array_key_exists('msg', $response)) {
            $response['errorMessage'] = $response['msg'];
            return $response;
        }

        session()->put('bkash_token', $response['id_token']);

        return response()->json(['success', true]);

    }

    public function createPayment(Request $request)
    {

        $token = session()->get('bkash_token');

        $request['intent'] = 'sale';
        $request['currency'] = 'BDT';
        $request['merchantInvoiceNumber'] = rand();

        $url = curl_init("$this->base_url/checkout/payment/create");
        $request_data_json = json_encode($request->all());
        $header = array(
            'Content-Type:application/json',
            "authorization: $token",
            "x-app-key: $this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata, true);
    }

    public function executePayment(Request $request)
    {
        $token = session()->get('bkash_token');

        $paymentID = $request->paymentID;
        $url = curl_init("$this->base_url/checkout/payment/execute/" . $paymentID);
        $header = array(
            'Content-Type:application/json',
            "authorization:$token",
            "x-app-key:$this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata, true);
    }

    public function queryPayment(Request $request)
    {
        $token = session()->get('bkash_token');
        $paymentID = $request->payment_info['payment_id'];

        $url = curl_init("$this->base_url/checkout/payment/query/" . $paymentID);
        $header = array(
            'Content-Type:application/json',
            "authorization:$token",
            "x-app-key:$this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata, true);
    }

    public function bkashSuccess(Request $request, $type)
    {
        try {
            $status = $request->payment_info['transactionStatus'];
            $amount = $request->payment_info['amount'];
            if ($status == 'Completed') {
                \Brian2694\Toastr\Facades\Toastr::success('Payment done successfully', 'Success');
                if ($type == "Deposit") {
                    $depositController = new DepositController();
                    $depositController->depositWithGateWay($amount, $request->all(), "Bkash");
                }
                if ($type == "Payment") {
                    $paymentController = new PaymentController();
                    $paymentController->payWithGateWay($request->all(), "Bkash");
                }

                return response()->json(['status' => true]);
            }
            return response()->json(['status' => false]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }
}
