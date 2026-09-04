@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('title', __('rates.rates'))
@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>
@endsection
@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <h1>{{ __('rates.rates')}}</h1>

    <div class="card-datatable table-responsive">
        <div class="row me-2">
            <div class="col-md-12 p-3">
                <button class="dt-button add-new btn btn-primary" tabindex="0" aria-controls="DataTables_Table_0"
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddRate"><span>
                            <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                            <span class="d-none d-sm-inline-block">{{__('rates.add')}}</span>
                        </span>
                </button>
            </div>
        </div>

        <table class="datatables-users table border-top">
            <thead>
            <tr>
                <th>{{__('rates.title')}}</th>
                <th>{{__('rates.billiard')}}</th>
                <th>{{__('site.actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rates as $rate)
               <tr>
                   <td>
                       <span class="fw-medium">{{$rate->title}}</span>
                   </td>
                   <td>
                       @if($rate->billiard)
                           {{$rate->billiard->idd}}
                        @else
                           ---
                       @endif
                   </td>
                   <td>
                       <div class="d-flex align-items-center">
                           <a href="rates/{{$rate->id}}/edit" class="text-body">
                               <i class="ti ti-edit ti-sm me-2"></i>
                           </a>
                           <form action="{{ route('rates.destroy', $rate->id) }}" method="post">
                               @csrf
                               @method('DELETE')
                               <button style="border: none;background: inherit;" type="submit" class="text-body delete-record" onclick="return confirm('{{__('rates.are')}}')">
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddRate"
         aria-labelledby="offcanvasAddUserLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasAddUserLabel" class="offcanvas-title">{{__('rates.add')}}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
        </div>


        <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
            <form class="add-new-user pt-0" id="addNewRateForm" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label">{{__('rates.title')}}</label>
                    <input type="text" class="form-control" required
                           name="title"/>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{__('site.valuta')}}</label>
                    <select name="valuta" class="form-control">
                        @foreach($valuta as $v)
                            <option value="{{$v}}">{{$v}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md mb-3">
                    <small class="text-light fw-medium d-block">Бар</small>
                    <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" name="isBar" id="inlineRadio1" value="0"/>
                        <label class="form-check-label" for="inlineRadio1">Без</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="isBar" id="inlineRadio2" value="1" checked/>
                        <label class="form-check-label" for="inlineRadio2">З</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Місяць</label>
                    <input type="number" class="form-control" required name="month"/>
                </div>
                <div class="mb-3">
                    <label class="form-label">Рік</label>
                    <input type="number" class="form-control" required name="year"/>
                </div>
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">{{__('site.Submit')}}</button>

            </form>

        </div>

    </div>
@endsection
