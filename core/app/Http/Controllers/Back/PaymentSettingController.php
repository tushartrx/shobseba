<?php

namespace App\Http\Controllers\Back;

use App\{Models\courier_data,
    Models\PaymentSetting,
    Http\Controllers\Controller,
    Http\Requests\PaymentSettingRequest,
    Repositories\Back\PaymentSettingRepository
};

use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    /**
     * Constructor Method.
     *
     * Setting Authentication
     *
     * @param \App\Repositories\Back\PaymentSettingRepository $repository
     *
     */
    public function __construct(PaymentSettingRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->middleware('adminlocalize');
        $this->repository = $repository;
    }

    /**
     * Show the form for updating resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment()
    {
        return view('back.settings.payment', $this->repository->payment());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentSettingRequest $request)
    {
        $this->repository->update($request);
        return redirect()->back()->withSuccess(__('Payment Information Updated Successfully.'));
    }


    public function courier()
    {
        $courier = courier_data::first();
        return view('back.settings.courier', compact('courier'));
    }

    public function courier_update(Request $request)
    {
        $courier_update = courier_data::where('id', 1)->first();
        $courier_update->courier_message = $request->courier_message;
        $courier_update->save();
        return redirect()->back()->withSuccess(__('Courier Information Updated Successfully.'));
    }

}
