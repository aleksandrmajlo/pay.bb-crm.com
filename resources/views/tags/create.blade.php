@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')
@section('title',__('Tag create'))
@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ __(session('success')) }}
        </div>
    @endif
    <form action="{{ route('tags.store') }}" method="post">
        @csrf
        <div class="card  mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h2 class="card-title mb-3">{{__('Tag create')}}</h2>
            </div>
            <div class="card-body">
                <div class="row mb-5 ">
                    <div class="col-md-12">

{{--                        --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach($langs as $key=>$lang)
                                <li class="nav-item">
                                    <button class="nav-link @if($key==0) active @endif" id="{{$lang->slug}}-tab" data-bs-toggle="tab" data-bs-target="#{{$lang->slug}}" type="button" role="tab"
                                            aria-controls="{{$lang->slug}}"
                                            aria-selected="true">{{__($lang->name)}}</button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content mt-3" id="myTabContent">
                            @foreach($langs as $key=>$lang)
                                @php
                                    $reg=false;
                                    if($lang->slug=='en'){
                                        $slug='name';
                                        $reg=true;
                                    }else{
                                        $slug='name_'.$lang->slug;
                                    }
                                @endphp
                                <div class="tab-pane fade  @if($key==0) show active @endif " id="{{$lang->slug}}" role="tabpanel" aria-labelledby="{{$lang->slug}}-tab">
                                    <label class="form-label">{{__('Name')}} {{__($lang->slug)}} @if($reg)
                                            <span style="color: red;">*</span>
                                        @endif</label>
                                    <input type="text" class="form-control" placeholder="{{__('Name')}}" name="{{$slug}}" @if($reg) required @endif value=""/>
                                </div>
                            @endforeach
                        </div>


                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary w-50">{{__('Send')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
