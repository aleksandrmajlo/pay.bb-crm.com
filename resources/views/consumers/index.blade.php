@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('title', __('consumers.title'))
@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <h1>{{ __('consumers.title')}} </h1>
    <h3>{{$title}}</h3>
    <div class="row me-2">
        <div class="col-md-12 p-3">
            <a class=" btn btn-primary" href="/consumers/create?billiard_id={{$billiard_id}}">
                <span>
                            <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                            <span class="d-none d-sm-inline-block">{{__('site.add_user')}}</span>
                 </span>
            </a>
        </div>
    </div>

    <div class="card-datatable table-responsive">
        <table class="datatables-users table border-top">
            <thead>
            <tr>
                <th>{{__('consumers.name')}}</th>
                <th>{{__('consumers.phone')}}</th>
                <th>{{__('consumers.roles')}}</th>
                <th>{{__('site.actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->phone}}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <strong>{{$role->name}}</strong>
                        @endforeach
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="consumers/{{$user->id}}/edit?billiard_id={{$billiard_id}}" class="text-body">
                                <i class="ti ti-edit ti-sm me-2"></i>
                            </a>
                            <form action="{{ route('consumers.destroy', $user->id) }}?billiard_id={{$billiard_id}}"
                                  method="post">
                                @csrf
                                @method('DELETE')
                                <button style="border: none;background: inherit;" type="submit"
                                        class="text-body delete-record" onclick="return confirm('{{__('site.are')}}')">
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
    <div class="row">
        <div class="col-md-12 mt-5">
            {{ $users->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

@endsection
