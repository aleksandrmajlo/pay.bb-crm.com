@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')
@section('title', __('billiard.edit'))

@section('content')
    <h1>{{__('billiard.edit')}}</h1>
    @if(session('success'))
        <div class="alert alert-success mt-5 mb-5" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <form method="post" action="{{ route('billiards.update', $billiard->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="idd" class="form-label">База даних</label>
                    <input type="text" class="form-control" id="idd" value="{{$billiard->idd}}" readonly
                           aria-describedby="defaultFormControlHelp"/>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Назва</label>
                    <input type="text" required class="form-control" id="name" name="name" value="{{$billiard->name}}"
                           aria-describedby="defaultFormControlHelp"/>
                </div>

                <div class="mb-3">
                    <label for="date_end" class="form-label">Дата закінчення</label>
                    <input type="date" required class="form-control" id="date_end" name="date_end"
                           value="{{$billiard->date_end}}" aria-describedby="defaultFormControlHelp"/>
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">Коментар</label>
                    <textarea name="comment" class="form-control">{{$billiard->comment}}</textarea>
                </div>

                <div class="mb-3">
                    <label for="date_end" class="form-label">Валюта</label>
                    <select name="valuta" class="form-select">
                        <option value="UAH" @if($billiard->valuta=="UAH") selected @endif >UAH</option>
                        <option value="USD" @if($billiard->valuta=="USD") selected @endif >USD</option>
                        <option value="EUR" @if($billiard->valuta=="EUR") selected @endif >EUR</option>
                    </select>
                </div>

                <div class="mb-3">
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" @if(count($rates)) checked data-rates="yes"
                               @else data-rates="not" @endif value="yes" name="billiard_rate" id="billiard_rate"/>
                        <label class="form-check-label" for="billiard_rate">
                            Додати індивідальний тариф
                        </label>
                    </div>
                </div>
                @if(count($rates))
                    <div id="delete_rates" style="display: none;" class="alert alert-danger" role="alert">
                        Після збереження тариф буде видаленний
                    </div>
                @endif
                <button type="submit" class="btn btn-primary  me-sm-3 me-1">{{__('site.Submit')}}</button>

            </form>
        </div>
    </div>

    <div class="row mt-5" id="billiard_rate_cont" @if(count($rates))  @else style="display: none;" @endif >
        <div class="col-md-6">

            <div class="card">
                <div class="card-body">

                    <form class="add-new-user pt-0" action="/billiard_rates" method="post">
                        @csrf
                        <input type="hidden" name="billiard_id" value="{{$billiard->id}}">
                        @if($rate_not_bar)
                            <input type="hidden" name="rate_not_bar_id" value="{{$rate_not_bar->id}}">
                        @endif
                        @if($rate_with_bar)
                            <input type="hidden" name="rate_with_bar_id" value="{{$rate_with_bar->id}}">
                        @endif

                        <h4>Без бару</h4>
                        <div class="mb-3">
                            <label class="form-label">{{__('rates.title')}}</label>
                            <input type="text" class="form-control" required value="{{ $rate_not_bar ? $rate_not_bar->title : '' }}" name="title"/>
                        </div>
                        <input type="hidden" name="isBar" value="0">
                        <div class="mb-3">
                            <label class="form-label">Місяць</label>
                            <input type="number" class="form-control" required name="month" value="{{ $rate_not_bar ? $rate_not_bar->month : '' }}"  />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Рік</label>
                            <input type="number" class="form-control" required name="year" value="{{ $rate_not_bar ? $rate_not_bar->year : '' }}" />
                        </div>

                        <h4>З баром</h4>
                        <div class="mb-3">
                            <label class="form-label">{{__('rates.title')}}</label>
                            <input type="text" class="form-control" required name="title_bar" value="{{ $rate_with_bar ? $rate_with_bar->title : '' }}"/>
                        </div>
                        <input type="hidden" name="isBar" value="0">
                        <div class="mb-3">
                            <label class="form-label">Місяць</label>
                            <input type="number" class="form-control" required name="month_bar" value="{{ $rate_with_bar ? $rate_with_bar->month : '' }}"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Рік</label>
                            <input type="number" class="form-control" required name="year_bar" value="{{ $rate_with_bar ? $rate_with_bar->year : '' }}"/>
                        </div>


                        <button type="submit"
                                class="btn btn-primary me-sm-3 me-1 data-submit">{{__('site.Submit')}}</button>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
