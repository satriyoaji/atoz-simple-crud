<?php

namespace App\Http\Controllers;

use App\Balance;
use App\PaidStatus;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexOrder(Request $request)
    {
        $products = Product::with('paidStatus')
            ->orderBy('created_at', 'desc')
            ->get()->toArray();
        $balances = Balance::with('paidStatus')
            ->orderBy('created_at', 'desc')
            ->get()->toArray();
        $data = array_merge($products, $balances);

        // sort by created_at
        $createdAt = array_column($data, 'created_at');
        array_multisort($createdAt, SORT_DESC, $data);

//        if($request->ajax()){
//
//            return DataTables::of($data)
//                ->addColumn('action', function ($row) {
//
//                })
//                ->escapeColumns([])
//                ->make(true);
//        }

        if (isset($request->order_no))
            return view('order_history', compact('data'))->with('success', 'Payment with order no. '.$request->order_no.' successfully paid !');
        else
            return view('order_history', compact('data'));
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
        DB::beginTransaction();
        $successPaid = PaidStatus::where('slug', 'success')->first();
        if ($request->type == 'product'){
            $data = Product::where('order_no', $request->order_no)->update([
                'paid_status_id' => $successPaid->id
            ]);
        }
        elseif ($request->type == 'balance'){
            $data = Balance::where('order_no', $request->order_no)->update([
                'paid_status_id' => $successPaid->id
            ]);
        }
        DB::commit();

        return redirect()->route('order-history', ['order_no'=>$request->order_no]);
    }

}
