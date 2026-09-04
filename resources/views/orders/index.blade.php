@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')
@section('title', __('order.title').' '.$title_billiard)
@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <h1>{{__('order.title')}} {{$title_billiard}}</h1>

    <div class="card-datatable table-responsive">

        <table class="datatables-users table border-top">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{__('order.billiard')}}</th>
                <th>{{__('order.summa')}}</th>
                <th>{{__('order.oplata')}}</th>
                <th>{{__('order.date')}}</th>
                <th>{{__('order.type_pay')}}</th>
                <th>{{__('site.actions')}}</th>
            </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)

                  <tr>
                      <td>{{$order->id}}</td>
                      <td>{{$order->billiards}}</td>
                      <td>{{number_format($order->summa, 0, ',', ' ')}} {{$order->valuta}}</td>
                      <td>
                          @if($order->paid==1)
                             {{__('site.yes')}}
                          @else
                              <div class="d-flex align-items-center">
                                  <span class="me-3 d-inline-block">{{__('site.not')}}</span>
                                  <form method="post" action="{{route('order_status')}}">
                                      @csrf
                                      <input type="hidden" name="order_id" value="{{$order->id}}">
                                      <button class="btn btn-outline-primary">{{__('order.change')}}</button>
                                  </form>
                              </div>
                          @endif
                      </td>
                      <td>
                          @if($order->updated_at)
                               {{$order->updated_at->format('Y-m-d')}}
                          @else
                               {{$order->created_at->format('Y-m-d')}}
                          @endif
                      </td>
                      <td>
                          @if($order->type)
                              {{$order->type}}
                          @endif
                      </td>
                      <td>
                          <div class="d-flex align-items-center">
                              <a href="orders/{{$order->id}}" class="text-body">
                                  <i class="ti ti-edit ti-sm me-2"></i>
                              </a>
                              <form action="{{ route('orders.destroy', $order->id) }}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <button style="border: none;background: inherit;" type="submit" class="text-body delete-record" onclick="return confirm('{{__('order.are')}}')">
                                      <i class="ti ti-trash ti-sm mx-2"></i>
                                  </button>
                              </form>
                          </div>
                      </td>
                  </tr>
              @endforeach
            </tbody>
        </table>

    </div>
    <div class="row">
        <div class="col-md-12 mt-5">
            {{ $orders->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

@endsection
