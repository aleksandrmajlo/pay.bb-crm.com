@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')
@section('title', __('billiard.edit'))
@section('content')
    <h1>{{__('rates.edit')}}</h1>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <form   method="post" action="{{ route('rates.update', $rate->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="idd" class="form-label">{{__('rates.title')}}</label>
                    <input type="text" class="form-control" name="title" required   value="{{$rate->title}}"  aria-describedby="defaultFormControlHelp" />
                </div>

                <div class="mb-3">
                    <label class="form-label">{{__('site.valuta')}}</label>
                    <select name="valuta" class="form-control">
                        @foreach($valuta as $v)
                            <option @if($v==$rate->valuta) selected @endif value="{{$v}}">{{$v}}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md mb-3">
                    <small class="text-light fw-medium d-block">Бар</small>
                    <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" name="isBar"  @if($rate->isBar==0) checked @endif id="inlineRadio1" value="0"/>
                        <label class="form-check-label" for="inlineRadio1">Без</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="isBar" @if($rate->isBar==1) checked @endif id="inlineRadio2" value="1" />
                        <label class="form-check-label" for="inlineRadio2">З</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Місяць</label>
                    <input type="number" value="{{$rate->month}}" class="form-control" required name="month"/>
                </div>
                <div class="mb-3">
                    <label class="form-label">Рік</label>
                    <input type="number"  value="{{$rate->year}}" class="form-control" required name="year"/>
                </div>

                <button  type="submit" class="btn btn-primary  me-sm-3 me-1">{{__('site.Submit')}}</button>
            </form>

        </div>
    </div>


@endsection
