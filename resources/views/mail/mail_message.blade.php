@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')
@section('title',__('Letters'))

@section('vendor-style')
    {{--    <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/katex.css')}}"/>--}}
    {{--    <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/editor.css')}}"/>--}}
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-email.css')}}"/>
@endsection

@section('vendor-script')
    {{--    <script src="{{asset('assets/vendor/libs/quill/katex.js')}}"></script>--}}
    {{--    <script src="{{asset('assets/vendor/libs/quill/quill.js')}}"></script>--}}
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/block-ui/block-ui.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/app-email.js')}}"></script>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ __(session('success')) }}
        </div>
    @endif

    <div class="app-email card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-3">{{__('Letters')}}</h2>
        </div>

        @if($mail_messages)
            <div class="row g-0">
                <div class="col-md-12 p-3 ">
                    {{ $mail_messages->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        @endif

        <div class="row g-0">

            <!-- Emails List -->
            <div class="col app-emails-list">
                <div class="shadow-none border-0">

                    <!-- Email List: Items -->
                    <div class="email-list pt-0 ">
                        @if($mail_messages)
                            <ul class="list-unstyled m-0">
                                @foreach($mail_messages as $mail_message)
                                    <li class="email-list-item" data-starred="true" data-bs-toggle="sidebar">
                                        <div class="d-flex align-items-center justify-content-between">

                                            <div class="email-list-item-content ms-2 ms-sm-0 me-2">
                                                <span class="h6 email-list-item-username me-2">{{$mail_message->name}}</span>
                                                <span class="h6 email-list-item-username me-2">{{$mail_message->email}}</span>
                                                <span class="email-list-item-subject d-xl-inline-block d-block">
                                                   {{$mail_message->message}}
                                                </span>
                                            </div>
                                            <div class="  d-flex align-items-center">
                                                {{--                                                <span class="email-list-item-label badge badge-dot bg-danger d-none d-md-inline-block me-2" data-label="private"></span>--}}
                                                <small class=" text-muted  text-nowrap p-3">{{$mail_message->created_at}}</small>
                                                <form action="{{ route('mail-messages.destroy', $mail_message->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger"><i class='ti ti-trash ti-sm'></i></button>
                                                </form>

                                                {{--                                                <ul class="list-inline email-list-item-actions text-nowrap">--}}
                                                {{--                                                    <li class="list-inline-item email-read"><i class='ti ti-mail-opened ti-sm'></i></li>--}}
                                                {{--                                                    <li class="list-inline-item email-delete"><i class='ti ti-trash ti-sm'></i></li>--}}
                                                {{--                                                    <li class="list-inline-item"><i class="ti ti-archive ti-sm"></i></li>--}}
                                                {{--                                                </ul>--}}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <ul class="list-unstyled m-0">
                                <li class="email-list-empty text-center d-none">No items found.</li>
                            </ul>
                        @endif


                    </div>
                </div>
                <div class="app-overlay"></div>
            </div>
            <!-- /Emails List -->

        </div>

    </div>

@endsection
