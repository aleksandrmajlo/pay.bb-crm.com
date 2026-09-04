@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')
@section('title', __('billiard.billiards'))
@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <h1>{{__('billiard.billiards')}}</h1>


    <div class="row">

        @foreach($billiards as $billiard)

            <div class="col-md-3 mb-3" >
                <div class="card  ">
                    <div class="card-body text-primary">
                        <h5 class="card-title">{{$billiard->name}}</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">База даних: <strong>{{$billiard->idd}}</strong></li>
                        <li class="list-group-item text-nowrap">Дата закінчення: <strong>{{$billiard->date_end}}</strong></li>
                        <li class="list-group-item">Валюта: <strong>{{$billiard->valuta}}</strong></li>
                    </ul>
                    <a href="billiards/{{$billiard->id}}/edit " class="btn btn-primary mb-2">Редагувати</a>
                    <a href="orders?billiard_id={{$billiard->id}}" class="btn btn-primary mb-2">{{__('billiard.show_order')}}</a>
                    <a href="consumers?billiard_id={{$billiard->id}}" class="btn btn-primary">{{__('consumers.title')}}</a>
                    @if((int) $billiard->isFree === 1)
                        <form action="{{ route('billiards.destroy', $billiard) }}"
                              method="post"
                              class="mt-2"
                              onsubmit="return confirm(@js(__('billiard.delete_confirm')))">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                {{ __('billiard.delete') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>

        @endforeach

    </div>
@endsection
