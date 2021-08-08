@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    <h4><b>{{ __('Prepaid Balance') }}</b></h4>
                </div>

                <div class="card-body">
                    @if (\Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {!! \Session::get('error') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                  <form method="POST" action="{{ route('prepaid-balance.store') }}">
                      @csrf
                      <div class="form-group">
                          <input type="text" name="mobile_phone" class="form-control @error('mobile_phone') is-invalid @enderror" value="{{ old('mobile_phone') }}" placeholder="Mobile phone" id="mobile_phone">
                          @error('mobile_phone')<div class="invalid-feedback-mobile_phone text-danger font-italic">{{$message}}</div>@enderror
                      </div>
                    <div class="form-group">
                        <select name="value" class="form-select @error('value') is-invalid @enderror" aria-label="Default select example">
                            <option selected disabled>Choose value</option>
                            @foreach($values as $value)
                                <option value="{{$value}}">{{$value}}</option>
                            @endforeach
                        </select>
                        @error('value')<div class="invalid-feedback-value text-danger font-italic">{{$message}}</div>@enderror
                    </div>
                    <button type="submit" class="mt-2 btn btn-primary btn-block">Submit</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
