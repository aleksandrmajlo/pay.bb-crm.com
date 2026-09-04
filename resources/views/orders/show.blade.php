@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')
@section('title', __('order.title'))
@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <h1>{{__('order.show')}} №{{$order->id}}</h1>
    <div class="row">
        <div class="col-md-12">
            <ul class="list-group">
                <li class="list-group-item">{{__('order.billiard')}}: <strong>{{$order->billiards}}</strong></li>
                <li class="list-group-item">{{__('order.summa')}}: <strong>{{number_format($order->summa, 0, ',', ' ')}} {{$order->valuta}}</strong></li>
                <li class="list-group-item">{{__('order.oplata')}}: <strong> @if($order->paid==1)
                            {{__('site.yes')}}
                        @else
                            {{__('site.not')}}
                        @endif</strong></li>

                <li class="list-group-item">{{__('order.date')}}:
                    <strong>
                        @if($order->updated_at)
                            {{$order->updated_at->format('Y-m-d')}}
                        @else
                            {{$order->created_at->format('Y-m-d')}}
                        @endif
                    </strong>
                </li>
                <li class="list-group-item">{{__('order.rate')}}: <strong>{{$order->rate->title}}</strong></li>
                <li class="list-group-item">{{__('site.user')}}: <strong>{{$user_name}}</strong></li>

            </ul>

        </div>
    </div>
@endsection
