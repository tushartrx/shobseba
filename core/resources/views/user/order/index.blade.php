@extends('master.front')
@section('title')
    {{__('Orders')}}
@endsection

@section('content')
    <!-- Page Title-->
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumbs">
                        <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                        <li class="separator"></li>
                        <li>{{__('Orders')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content-->
    <div class="container padding-bottom-3x mb-1">
        <div class="row">
            @include('includes.user_sitebar')
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="u-table-res">
                            <table class="table table-bordered mb-0">
                                <thead>
                                <tr>

                                    <th>{{__('Order')}} #</th>
                                    <th>{{__('Total')}}</th>
                                    <th>{{__('Order Status')}}</th>
                                    <th>{{__('Payment Status')}}</th>
                                    <th>{{__('Courier Payment')}}</th>
                                    <th>{{__('Date Purchased')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $order)

                                    <tr>

                                        <td><a class="navi-link" href="#" data-toggle="modal"
                                               data-target="#orderDetails">{{$order->transaction_number}}</a></td>
                                        <td>
                                            @if ($setting->currency_direction == 1)
                                                {{$order->currency_sign}}{{PriceHelper::OrderTotal($order)}}
                                            @else
                                                {{PriceHelper::OrderTotal($order)}}{{$order->currency_sign}}
                                            @endif

                                        </td>
                                        <td>
                                            @if($order->order_status == 'Pending')
                                                <span class="text-info">{{$order->order_status}}</span>
                                            @elseif($order->order_status == 'In Progress')
                                                <span class="text-warning">{{$order->order_status}}</span>
                                            @elseif($order->order_status == 'Delivered')
                                                <span class="text-success">	{{$order->order_status}}</span>
                                            @else
                                                <span class="text-danger">{{__('Canceled')}}</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($order->payment_status == 'Paid')
                                                <span class="text-success">{{$order->payment_status}}</span>
                                            @else
                                                <span class="text-danger">{{$order->payment_status}}</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($order->courier_payment == 0)
                                                <span class="text-info">Pending</span>
                                            @elseif($order->order_status == 1)
                                                <span class="text-warning">Under Review</span>
                                            @elseif($order->order_status == 2)
                                                <span class="text-warning">Success</span>
                                            @elseif($order->order_status == 3)
                                                <span class="text-warning">Rejected</span>
                                            @else
                                                <span class="text-danger">{{__('Canceled')}}</span>
                                            @endif
                                            <br>


                                        </td>

                                        <td>{{$order->created_at->format('D/M/Y')}}</td>
                                        <td>
                                            <a href="{{route('user.order.invoice',$order->id)}}"
                                               class="btn btn-info btn-sm">{{__('Details')}}</a>

                                            <a href="{{route('user.order.invoice',$order->id)}}"
                                               style="margin-top: 5px;"
                                               class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                               data-bs-target="#exampleModal">PAY NOW </a>
                                        </td>
                                    </tr>




                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{route('user.order.courier.update')}}" method="post">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Courier
                                                            Information</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Message</label>
                                                                <textarea class="form-control" cols="5"
                                                                          rows="5">{!! $courier_info->courier_message !!}</textarea>
                                                            </div>
                                                            <div class="col-md-12" style="margin-top: 10px;">
                                                                <label>TRX ID</label>
                                                                <input type="text" class="form-control" name="trx_id">
                                                                <input type="hidden" class="form-control"
                                                                       name="order_id"
                                                                       value="{{$order->id}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

