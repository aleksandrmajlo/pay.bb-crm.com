@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')
@section('title',__('Tags'))
@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ __(session('success')) }}
        </div>
    @endif
    <div class="card  mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-3">{{__('Tags')}}</h2>
        </div>
        <div class="card-datatable table-responsive p-5">
            {{--
                        <div class="row me-2">
                            <div class="col-md-12 p-3">
                                <a href="{{route('tags.create')}}" class="btn btn-primary"
                                        type="button"  data-bs-target="#offcanvasAddTag"><span>
                                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                        <span class="d-none d-sm-inline-block">{{__('Add')}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                         --}}
            <table class="datatables-users table border-top">
                <thead>
                <tr>
                    <th>{{__('Name')}}</th>
                    {{--                    <th>{{__('Name')}} {{__('Ukrainian')}}</th>--}}
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <td>{{ $tag->name}}</td>
                        {{--                        <td>{{ $tag->name_uk}}</td>--}}
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('tags.edit', $tag->id) }}" class="text-body">
                                    <i class="ti ti-edit ti-sm me-2"></i>
                                </a>
                                <form action="{{ route('tags.destroy', $tag->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button style="border: none;background: inherit;" type="submit" class="text-body delete-record"
                                            onclick="return confirm('{{__('Are you sure?')}}')">
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
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddTag" aria-labelledby="offcanvasAddFaqLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddFaqLabel" class="offcanvas-title">{{__('Add')}}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
                <form class="add-new-Faq pt-0" action="{{route('tags.store')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{__('Name')}}</label>
                        <input type="text" class="form-control" placeholder="{{__('Name')}}" name="name" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{__('Name')}} {{__('Ukrainian')}}</label>
                        <input type="text" class="form-control" placeholder="{{__('Name')}} {{__('Ukrainian')}}" name="name_uk" required/>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">{{__('Submit')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
