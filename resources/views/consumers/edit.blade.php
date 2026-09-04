@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('title', __('site.edit_h3').' '.$user->name)
@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <h1>{{ __('site.edit_h3')}} {{$user->name}}</h1>
    <h3>{{$billiard->idd}}</h3>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">{{__('site.home')}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="/consumers?billiard_id={{$billiard->id}}">{{__('consumers.title')}}</a>
            </li>
        </ol>
    </nav>

    <div class="row" id="app">
        <div class="col-md-6">


            <form method="post" action="{{ route('consumers.update', $user->id) }}">
                @csrf
                @method('PUT')

                <input type="hidden" name="billiard_id" value="{{$billiard->id}}">


                <div class="mb-3">
                    <label  class="form-label">{{__('site.phone')}}</label>
{{--                    <input type="tel" class="form-control" readonly required name="phone"  value="{{$user->phone}}"  >--}}
                    <phone billiard_id="{{$billiard->id}}"   val="{{$user->phone}}"></phone>
                </div>

                <div class="mb-3">
                    <label  class="form-label">{{__('consumers.name')}}</label>
                    <input type="text" class="form-control"  required  name="name"  value="{{$user->name}}"  >
                </div>


                <div class="col-md mb-3">
                    <label  class="form-label d-block">{{__('consumers.roles')}}</label>
                    @foreach($roles as $role)
                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="checkbox" @if($user->roles->contains($role->id)) checked @endif name="role_id[]" value="{{$role->id}}" id="role_{{$role->id}}"  />
                            <label class="form-check-label" for="role_{{$role->id}}">{{$role->name}}</label>
                        </div>
                    @endforeach
                </div>


                <div class="col-md mb-3">
                    <label  class="form-label d-block">{{__('site.status')}}</label>
                    <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" @if($user->status==1) checked @endif name="status" value="1"  id="status1" />
                        <label class="form-check-label" for="status1">@lang('site.status_active')</label>
                    </div>
                    <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" @if($user->status===0) checked @endif name="status" value="0"  id="status0" />
                        <label class="form-check-label" for="status0">@lang('site.status_not_active')</label>
                    </div>
                </div>

                <div class="col-md mb-3">
                    <label  class="form-label d-block">{{__('site.view')}}</label>
                    <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" @if($user->view==1) checked @endif name="view" value="1"  id="view1" />
                        <label class="form-check-label" for="view1">@lang('site.status_active')</label>
                    </div>
                    <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" @if($user->view===0) checked @endif name="view" value="0"  id="view0" />
                        <label class="form-check-label" for="view0">@lang('site.status_not_active')</label>
                    </div>
                </div>

                @if($user->roles->contains(3))
                    <div class="col-md mb-3">
                        <label  class="form-label d-block">{{__('site.barmen_view')}}</label>

                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="radio" @if($user->barmen_view==2) checked @endif name="barmen_view" value="2"  id="barmen_view2" />
                            <label class="form-check-label" for="barmen_view2">@lang('site.all')</label>
                        </div>
                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="radio" @if($user->barmen_view==1) checked @endif name="barmen_view" value="1"  id="barmen_view1" />
                            <label class="form-check-label" for="barmen_view1">@lang('site.my')</label>
                        </div>

                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="radio" @if($user->barmen_view===0) checked @endif name="barmen_view" value="0"  id="barmen_view0" />
                            <label class="form-check-label" for="barmen_view0">@lang('site.not')</label>
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label  class="form-label">@lang('site.sklad_dostup')</label>
                    <select class="form-control"  required  name="sklad">
                        <option @if($user->sklad==1) selected @endif value="1">{{__('site.all')}}</option>
                        <option @if($user->sklad==2) selected @endif  value="2">{{__('site.view_sklad')}}</option>
                        <option @if($user->sklad==3) selected @endif  value="3">{{__('site.not')}}</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label  class="form-label">@lang('site.order_history')</label>
                    <select class="form-control"  required  name="order_history">
                        <option @if($user->order_history==1) selected @endif value="1">{{__('site.my')}}</option>
                        <option @if($user->order_history==2) selected @endif value="2">{{__('site.not')}}</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label  class="form-label">@lang('site.lang')</label>
                    <select class="form-control"  required  name="lang">
                        @foreach($locales as $k=>$locale)
                            <option @if($user->lang==$k) selected @endif value="{{$k}}">{{$locale}}</option>
                        @endforeach
                    </select>
                </div>


                <button  type="submit" class="btn btn-primary  me-sm-3 me-1">{{__('site.Submit')}}</button>

            </form>
        </div>
    </div>

@endsection
