@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/typography.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/katex.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/editor.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}"/>
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/quill/katex.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/quill/quill.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
@endsection

@section('page-script')
@endsection

@section('title',__('Faqs'))
@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ __(session('success')) }}
        </div>
    @endif
    <div class="card  mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-3">{{__('Faq edit')}}</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('faqs.update', $faq->id) }}" method="post" id="add_faq">
                @csrf
                @method('PUT')

                <div class="row mb-5 ">
                    <div class="col-md-12">
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
                            @php
                                $full_editor=[];
                            @endphp
                            @foreach($langs as $key=>$lang)
                                @php
                                         $langId=$lang->id;
                                        $reg=false;
                                        if($lang->slug=='en'){
                                            $question='question';
                                             $value_question=$faq->question;
                                            $answer='answer';
                                            $value_answer=$faq->answer;
                                            $reg=true;
                                            $full='full-editor';
                                        }else{
                                            $question='question_'.$lang->slug;
                                             $value_question=$faq->{$question};
                                            $answer='answer_'.$lang->slug;
                                            $value_answer=$faq->{$answer};
                                            $full='full-editor_'.$lang->slug;
                                        }
                                        $full_editor[]=$full;
                                         $tags[]='Tagify_'.$lang->slug;
                                         $tags_th = $faq->tags()->wherePivot('lang_id', $langId)->pluck('name')->toArray();
                                         $value_tag='';
                                         if($tags_th){
                                             $value_tag=implode(',',$tags_th);
                                         }
                                @endphp
                                <div class="tab-pane fade  @if($key==0) show active @endif " id="{{$lang->slug}}" role="tabpanel" aria-labelledby="{{$lang->slug}}-tab">
                                    <div class="mb-5">
                                        <label class="form-label">{{__('Question')}} {{__($lang->slug)}} @if($reg)
                                                <span style="color: red;">*</span>
                                            @endif</label>
                                        <input type="text" class="form-control" value="{{$value_question}}"
                                               placeholder="{{__('Question')}} {{__($lang->slug)}}" name="{{$question}}" @if($reg) required @endif />
                                    </div>
                                    <div class="mb-5">
                                        <label class="col-sm-2 col-form-label" for="basic-default-name">{{__('Answer')}} {{__($lang->slug)}}</label>
                                        <input type="hidden" id="{{$full}}_name" name="{{$answer}}">
                                        <div id="{{$full}}">{!! $value_answer !!}</div>
                                    </div>
                                    <div class="mb-5">
                                        <label for="Tagify_{{$lang->slug}}" class="form-label">{{__('Tags')}}</label>
                                        <input id="Tagify_{{$lang->slug}}" data-lang="{{$lang->slug}}" class="form-control" name="tagify_{{$lang->slug}}" value="{{$value_tag}}"/>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <hr class="mb-5"/>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">{{__('Additional for search')}}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="{{__('Additional for search')}}" name="search" value="{{$faq->search}}"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">{{__('Sort')}}</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" placeholder="{{__('Sort')}}" name="sort" value="{{$faq->sort}}"/>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary w-50">{{__('Send')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script>
        window.editors = @php echo json_encode($full_editor); @endphp;
        window.tags = @php echo json_encode($tags); @endphp;
        window.lang_tags = @php echo json_encode($lang_tags); @endphp;
    </script>

@endsection
