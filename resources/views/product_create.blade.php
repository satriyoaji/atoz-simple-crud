@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    <h4><b>{{ __('Product Page') }}</b></h4>
                </div>

                <div class="card-body">
                    @if (\Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {!! \Session::get('error') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                  <form method="POST" action="{{ route('product.store') }}">
                      @csrf
                    <div class="form-group">
                        <textarea name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Product" id="name">{{{ old('name') }}}</textarea>
                        @error('name')<div class="invalid-feedback-name text-danger font-italic">{{$message}}</div>@enderror
                    </div>
                    <div class="form-group">
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Shipping Address" id="address">{{{ old('address') }}}</textarea>
                        @error('address')<div class="invalid-feedback-address text-danger font-italic">{{$message}}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="Price" id="price">
                        @error('price')<div class="invalid-feedback-price text-danger font-italic">{{$message}}</div>@enderror
                    </div>
                    <button type="submit" class="mt-2 btn btn-primary btn-block">Submit</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
