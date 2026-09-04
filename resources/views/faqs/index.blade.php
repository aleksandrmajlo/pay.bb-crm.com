@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')
@section('title',__('Faqs'))

@section('vendor-style')
{{--    <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/typography.css')}}"/>--}}
{{--    <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/katex.css')}}"/>--}}
{{--    <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/editor.css')}}"/>--}}
@endsection

@section('vendor-script')
{{--    <script src="{{asset('assets/vendor/libs/quill/katex.js')}}"></script>--}}
{{--    <script src="{{asset('assets/vendor/libs/quill/quill.js')}}"></script>--}}
@endsection

@section('page-script')
{{--    <script src="{{asset('assets/js/forms-editors.js')}}"></script>--}}
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ __(session('success')) }}
        </div>
    @endif
    <div class="card  mb-4">

        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-3">{{__('Faqs')}}</h2>
        </div>

        <div class="card-datatable table-responsive p-5">
            <div class="row me-2">
                <div class="col-md-12 p-3">
                    <a href="{{route('faqs.create')}}" class="dt-button add-new btn btn-primary" ><span>
                            <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                            <span class="d-none d-sm-inline-block">{{__('Add')}}</span>
                        </span>
                    </a>
                </div>
            </div>
            <table class="datatables-users table border-top">
                <thead>
                <tr>
                    <th>{{__('Question')}}</th>
                    <th class="w-25">{{__('Tags')}}</th>
                    <th>{{__('Sort')}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($fags as $faq)
                    <tr>
                        <td>{{ Str::words($faq->question, 20, '...') }}</td>
                        <td>
                            @foreach($faq->tags as $tag)
                                <span class="badge bg-label-primary mb-2">{{$tag->name}}</span>
                            @endforeach
                        </td>
                        <td>{{ $faq->sort}}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('faqs.edit', $faq->id) }}" class="text-body">
                                    <i class="ti ti-edit ti-sm me-2"></i>
                                </a>
                                <form action="{{ route('faqs.destroy', $faq->id) }}" method="post">
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

    </div>

@endsection
