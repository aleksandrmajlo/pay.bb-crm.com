@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')
@section('title',__('Langs'))

@section('vendor-style')
@endsection

@section('vendor-script')
@endsection

@section('page-script')
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ __(session('success')) }}
        </div>
    @endif


    <div class="card  mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-3">{{__('Langs')}}</h2>
        </div>
        <div class="card-datatable table-responsive p-4">
            <div class="row me-2">
                <div class="col-md-12 p-3">
                    <button class="dt-button add-new btn btn-primary" tabindex="0" aria-controls="DataTables_Table_0"
                            type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddLang"><span>
                            <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                            <span class="d-none d-sm-inline-block">{{__('Add')}}</span>
                        </span>
                    </button>
                </div>
            </div>
            <table class="datatables-users table border-top">
                <thead>
                <tr>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Slug')}} </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($langs as $lang)
                    <tr>
                        <td>{{$lang->name}}</td>
                        <td>{{$lang->slug}}</td>
                        <td>
                            @if($lang->slug!='en'&&$lang->slug!='uk')
                                <div class="d-flex align-items-center">
                                    {{--
                                    <a href="{{ route('tags.edit', $lang->id) }}" class="text-body">
                                        <i class="ti ti-edit ti-sm me-2"></i>
                                    </a>
                                      --}}
                                    <form action="{{ route('langs.destroy', $lang->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button style="border: none;background: inherit;" type="submit" class="text-body delete-record"
                                                onclick="return confirm('{{__('Are you sure?')}}')">
                                            <i class="ti ti-trash ti-sm mx-2"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddLang" aria-labelledby="offcanvasAddFaqLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddFaqLabel" class="offcanvas-title">{{__('Add')}}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
                <form class="add-new-Faq pt-0"  action="{{route('langs.store')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{__('Name')}}</label>
                        <input type="text" class="form-control"  placeholder="{{__('Name')}}" name="name" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{__('Slug')}}</label>
                        <input type="text" class="form-control"  placeholder="{{__('Slug')}}" name="slug" required/>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">{{__('Submit')}}</button>
                </form>
            </div>
        </div>


    </div>
@endsection
