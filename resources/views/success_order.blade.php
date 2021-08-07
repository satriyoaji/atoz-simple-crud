@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header font-weight-bold">
                    <h4><b>{{ __('Success !') }}</b></h4>
                </div>

                <div class="card-body">
                  <form method="POST" action="{{ route('payment.store') }}">
                    @csrf
                      <div class="row py-2">
                          <div class="col-12 d-flex justify-content-between mx-2 font-weight-bolder">
                              <span>Order no.</span>
                              <span>{{number_format($data->order_no, 0,' ', ' ')}}</span>
                          </div>
                          <div class="mt-2 col-12 d-flex justify-content-between mx-2 font-weight-bolder">
                              <span>Total</span>
                              @if($data->kind == 'product')
                              <span>Rp. {{number_format($data->price_after, 0,',', '.')}}</span>
                              @elseif($data->kind == 'balance')
                              <span>Rp. {{number_format($data->value_after, 0,',', '.')}}</span>
                              @endif
                          </div>
                          <div class="mt-3 col-12 flex-row justify-content-center mx-2 py-1">
                              @if($data->kind == 'product')
                              <div class="mt-1">
                                 <span>
                                     {{$data->name}} that costs {{number_format($data->price, 0,',', '.')}} will be shipped to:
                                 </span>
                              </div>
                              <div class="mt-1">
                                 <span>
                                     {{$data->address}}
                                 </span>
                              </div>
                              <div class="mt-1">
                                <span>
                                    only after you pay.
                                </span>
                              </div>
                              @elseif($data->kind == 'balance')
                              <div class="mt-1">
                                 <span>
                                     Your mobile phone number {{$data->mobile_phone}} will receive Rp. {{number_format($data->value, 0,',', '.')}}
                                 </span>
                              </div>
                              <div class="mt-1">
                                <span>
                                    only after you pay.
                                </span>
                              </div>
                              @endif
                          </div>
                          <div class="mt-4 col-12 mx-2">
                              <div>
                                <button type="submit" class="mt-2 btn btn-primary btn-block">Pay Now</button>
                              </div>
                          </div>
                      </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
