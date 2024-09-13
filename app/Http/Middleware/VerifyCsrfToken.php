<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{

    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/order/aamarpay/success',
        '/order/aamarpay/failed',

        '/payment/sslcommerz/pay-via-ajax',
        '/payment/sslcommerz/success',
        '/payment/sslcommerz/cancel',
        '/payment/sslcommerz/fail',
        '/payment/sslcommerz/ipn',
        '/paytm/payment/status',
        '/paytm/deposit/status',
        '/paytm/subscription/status',
        '/install/*',
        'mobilpay/confirm/deposit',
        'mobilpay/confirm/payment',

    ];
}
