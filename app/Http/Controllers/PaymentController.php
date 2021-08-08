<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        return view('payment_index');
    }

    public function successView(Request $request)
    {
        if(isset($request->type) && isset($request->id)){

            if ($request->type == 'product'){
                $data = Product::find($request->id);
                $data->priceAfter = ($data->price + 10000);
            }elseif ($request->type == 'balance'){
                $data = Balance::find($request->id);
                $data->valueAfter = ($data->value + (0.05*$data->value));
            }

            DB::beginTransaction();
            # generate order_no
            for ($randomNumber = $data->id, $i = (0+strlen($data->id)); $i < 10; $i++) {
                $randomNumber .= mt_rand(0, 9);
            }
            # update price/value after and order_no
            if ($request->type == 'product'){
                $update = Product::where('id', $data->id)->update([
                    'order_no' => $randomNumber,
                    'price_after' => $data->priceAfter,
                ]);
                $data = Product::find($data->id);
                $data->type = 'product';
            }elseif ($request->type == 'balance'){
                $update = Balance::where('id', $data->id)->update([
                    'order_no' => $randomNumber,
                    'value_after' => $data->valueAfter,
                ]);
                $data = Balance::find($data->id);
                $data->type = 'balance';
            }
            DB::commit();

            return view('success_order', compact('data'));
        }

        //redirect back
        return redirect()->back()->with('error', 'invalid redirect directly to the success page');
    }

    public function order(Request $request)
    {
        if(isset($request->type) && isset($request->order_no)){
            if ($request->type == 'product'){
                $data = Product::where('order_no', $request->order_no)->first();
                $data->type = 'product';
            }
            elseif ($request->type == 'balance'){
                $data = Balance::where('order_no', $request->order_no)->first();
                $data->type = 'balance';
            }
            else
                return redirect()->back()->with('error', 'invalid redirect directly to the payment page');

            return view('payment_show', compact('data'));
        }
        return redirect()->back()->with('error', 'invalid redirect directly to the payment page');
    }

    public function store(Request $request)
    {
        dd($request->all());
        return view('success_order', compact('data'));
    }

}
