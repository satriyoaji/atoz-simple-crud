@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    <h4><b>{{ __('Order History') }}</b></h4>
                </div>

                <div class="card-body">
                    @if (\Session::has('success'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {!! \Session::get('success') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
{{--                  <form method="POST" action="{{ route('payment.order') }}">--}}
{{--                    @csrf--}}
{{--                      <div class="form-group">--}}
{{--                          <label for="order_no">Order No</label>--}}
{{--                          <input type="text" name="order_no" class="form-control @error('order_no') is-invalid @enderror" readonly value="{{ $data->order_no }}" placeholder="Order No" id="order_no">--}}
{{--                          @error('order_no')<div class="invalid-feedback-order_no text-danger font-italic">{{$message}}</div>@enderror--}}
{{--                      </div>--}}
{{--                      <input type="hidden" name="type" value="{{ $data->type }}">--}}
{{--                      <button type="submit" class="mt-2 btn btn-primary btn-block">Pay Now</button>--}}
{{--                  </form>--}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
