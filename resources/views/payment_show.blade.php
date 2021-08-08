@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header font-weight-bold">
                    <h4><b>{{ __('Pay your order!') }}</b></h4>
                </div>

                <div class="card-body">
                  <form method="POST" action="{{ route('payment.store') }}">
                    @csrf
                      <div class="form-group">
                          <label for="order_no">Order No</label>
                          <input type="text" name="order_no" class="form-control @error('order_no') is-invalid @enderror" readonly value="{{ $data->order_no }}" placeholder="Order No" id="order_no">
                          @error('order_no')<div class="invalid-feedback-order_no text-danger font-italic">{{$message}}</div>@enderror
                      </div>
                      <button type="submit" class="mt-2 btn btn-primary btn-block">Pay Now</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
