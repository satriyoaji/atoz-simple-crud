@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
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

                    <div class="form-group mb-2">
                        <input type="search" class="form-control" id="searchBar" onkeyup="myFunction()" aria-describedby="searchHelp" placeholder="search by Order no.">
                    </div>

                    <table class="table" id="orderTable">
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column justify-content-start ">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="">{{number_format($item['order_no'], 0,' ', ' ')}}</h6>
                                            @isset($item['price_after'])
                                            <h6 class="">Rp. {{number_format($item['price_after'], 0,',', '.')}}</h6>
                                            @endisset
                                            @isset($item['value_after'])
                                            <h6 class="">Rp. {{number_format($item['value_after'], 0,',', '.')}}</h6>
                                            @endisset
                                        </div>
                                        <div class="font-weight-bold mt-1 text-center">
                                            @if($item['type'] == 'product')
                                            <span>
                                                {{$item['name']}} that costs {{number_format($item['price'], 0,',', '.')}}
                                            </span>
                                            @elseif($item['type'] == 'balance')
                                            <span>
                                                {{number_format($item['value'], 0,',', '.')}} for {{$item['mobile_phone']}}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($item['paid_status']['slug'] == 'process')
                                    <form method="POST" action="{{ route('payment.order') }}">
                                        @csrf
                                        <input type="hidden" name="type" value="{{ $item['type'] }}">
                                        <input type="hidden" name="order_no" value="{{ $item['order_no'] }}">
                                        <button type="submit" class="mt-2 btn btn-primary btn-block">Pay Now</button>
                                    </form>
                                    @elseif($item['paid_status']['slug'] == 'fail')
                                    <span class="font-weight-bold text-warning">Failed</span>
                                    @elseif($item['paid_status']['slug'] == 'success')
                                    <span class="font-weight-bold text-success">Success</span>
                                    @elseif($item['paid_status']['slug'] == 'cancel')
                                    <span class="font-weight-bold text-danger">Failed</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchBar");
        filter = input.value.toUpperCase();
        table = document.getElementById("orderTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
@endsection
