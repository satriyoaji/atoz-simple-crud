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
        if ($request->kind == 'products'){
            $data = Product::find($request->id);
            $data->priceAfter = ($data->price + 10000);
        }elseif ($request->kind == 'balances'){
            $data = Balance::find($request->id);
            $data->valueAfter = ($data->value + (0.05*$data->value));
        }

        DB::beginTransaction();
        # generate order_no
        for ($randomNumber = $data->id, $i = (0+strlen($data->id)); $i < 10; $i++) {
            $randomNumber .= mt_rand(0, 9);
        }
        # update price/value after and order_no
        if ($request->kind == 'products'){
            $update = Product::where('id', $data->id)->update([
                'order_no' => $randomNumber,
                'price_after' => $data->priceAfter,
            ]);
            $data = Product::find($data->id);
            $data->kind = 'product';
        }elseif ($request->kind == 'balances'){
            $update = Balance::where('id', $data->id)->update([
                'order_no' => $randomNumber,
                'value_after' => $data->valueAfter,
            ]);
            $data = Balance::find($data->id);
            $data->kind = 'balance';
        }
        DB::commit();

        return view('success_order', compact('data'));
    }

    public function show()
    {
//        return view('payment_show');
    }

}
