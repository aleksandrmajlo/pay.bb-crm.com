@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', __('site.home'))

@section('content')
<h1> {{__('site.home')}}</h1>


<div class="row">

    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card">
            <div class="card-body pt-0">
                <div class="badge p-2 bg-label-danger mb-2 rounded">
                    <i class="ti ti-users ti-md"></i>
                </div>
                <h5 class="card-title mb-1 pt-2">{{__('site.users_count')}}</h5>
                <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                    <h4 class="mb-0">{{$users}}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card">
            <div class="card-body pt-0">
                <div class="badge p-2 bg-label-danger mb-2 rounded">
                    <i class="ti ti-sport-billard ti-md"></i>
                </div>
                <h5 class="card-title mb-1 pt-2">{{__('billiard.billiards')}}</h5>
                <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                    <h4 class="mb-0">{{$billiards}}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card">
            <div class="card-body pt-0">
                <div class="badge p-2 bg-label-danger mb-2 rounded">
                    <i class="ti ti-currency-dollar ti-md"></i>
                </div>
                <h5 class="card-title mb-1 pt-2">{{__('rates.rates')}}</h5>
                <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                    <h4 class="mb-0">{{$rates}}</h4>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
