<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CountOfferDate;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CountOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $date = CountOfferDate::first();
//            dd($date);
            return view('backend.offercount.index',[
                'data' =>   $date,
            ]);
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
//            dd($request->all());
            if ($request->count_date){
                $countDate = date('Y-m-d', strtotime($request->count_date));
            }
            $date = CountOfferDate::first();
            if ($date){
                $date->title = $request->title;
                $date->status = $request->status;
                $date->count_data = $countDate;
                $date->message = $request->message;
                $date->save();
            }else{
                $createDate = new CountOfferDate();
                $createDate->title = $request->title;
                $createDate->status = $request->status;
                $createDate->count_data = $countDate;
                $createDate->message = $request->message;
                $createDate->save();
            }
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return back();

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
