@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/blog/css/post_create.css'))}}" />
@endsection
@section('mainContent')
    @php
        $LanguageList = getLanguageList();
    @endphp
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('blog.add_new_post') }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="white-box">
        <form action="{{route('blog.posts.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-9">
                    <div class="white_box_25px box_shadow_white mb-20">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-title d-flex">
                                    <h3 class="mb-2 mr-30">{{ __('blog.post_info') }}</h3>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                    @foreach ($LanguageList as $key => $language)
                                        <li class="nav-item lang_code default_lang" data-id="{{$language->code}}">
                                            <a class="nav-link anchore_color  @if (auth()->user()->lang_code == $language->code) active @endif" href="#element{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach ($LanguageList as $key => $language)
                                        <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="element{{$language->code}}">
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{__('common.title')}} <span class="text-danger">*</span></label>
                                                    <input name="title[{{$language->code}}]" class="primary_input_field title" id="title{{$language->code}}" placeholder="{{ __('common.title') }}" type="text" autocomplete="off" value="{{old('title.'.$language->code)}}">
                                                </div>
                                                @if ($errors->has('title.'.auth()->user()->lang_code))
                                                    <span class="text-danger">{{ $errors->first('title.'.auth()->user()->lang_code) }}</span>
                                                @endif
                                            </div>
                                            <div class="col-lg-12 d-none" id="default_lang_{{$language->code}}">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{__('common.slug')}} <span class="text-danger">*</span></label>
                                                    <input name="slug[{{$language->code}}]" id="slug{{$language->code}}" class="primary_input_field" autocomplete="off" placeholder="{{ __('common.slug') }}" type="text" value="{{ old('slug.'.$language->code)}}">
                                                </div>
                                            </div>
                                            @if ($errors->has('slug.'.auth()->user()->lang_code))
                                                <span class="text-danger">{{ $errors->first('slug.'.auth()->user()->lang_code) }}</span>
                                            @endif
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-15">
                                                    <label class="primary_input_label" for=""> {{__("common.description")}} <span class="text-danger">*</span> </label>
                                                    <textarea class="summernote" name="content[{{$language->code}}]">{{ old('content.'.$language->code)}}</textarea>
                                                </div>
                                            </div>
                                            @if ($errors->has('content.'.auth()->user()->lang_code))
                                                <span class="text-danger">{{ $errors->first('content.'.auth()->user()->lang_code) }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 upload_item_area">
                    <div class="white_box_25px box_shadow_white upload_item_forms">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-title d-flex">
                                    <h3 class="mb-2 mr-30">{{ __('common.basic_info') }}</h3>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.category') }} <span class="text-danger">*</span></label>
                                    <select class="primary_select mb-25" name="categories[]" id="category_id" data-live-search="true" multiple>
                                        @foreach($CategoryList as $value)
                                        <option value="{{$value->id}}">
                                            <strong>-></strong>
                                            {{ $value->name }}
                                            @foreach ($value->childs as $child_account)
                                            @include('blog::category.category_select', ['child_account' => $child_account])
                                                @endforeach
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                    @if ($errors->has('categories'))
                                    <span class="text-danger">{{ $errors->first('categories') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <div class="single_field ">
                                    <label for="">@lang('blog.tags') (@lang('product.comma_separated'))<span class="text-danger">*</span></label>
                                </div>
                                <div class="tagInput_field mb_26">
                                    <input name="tag" class="tag-input" id="tag-input-upload-shots" type="text" value="{{old('tag')}}" data-role="tagsinput" />
                                </div>
                                    <div class="suggeted_tags">
                                        <label>@lang('blog.suggested_tags')</label>
                                        <div class="tagInput_field mb_26">
                                            <ul id="tag_show" class="suggested_tag_show">
                                            </ul>
                                        </div>
                                    </div>
                                @if ($errors->has('tag'))
                                <span class="text-danger">{{ $errors->first('tag') }}</span>
                                @endif
                            </div>
                            <br>
                            <div class="col-lg-12">
                                <div class="main-title d-flex">
                                    <label class="mb-2 mr-30">{{__('common.image') }}<small>({{getNumberTranslate(1000)}} X {{getNumberTranslate(500)}}){{__('common.px')}}</small></label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <div class="primary_file_uploader" data-toggle="amazuploader" data-multiple="false" data-type="image" data-name="blog_image">
                                        <input class="primary-input file_amount" type="text" id="image" placeholder="{{__('common.browse_image_file')}}" readonly="">
                                        <button class="" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="image">{{__("common.image")}} </label>
                                            <input type="hidden" class="selected_files" value="">
                                        </button>
                                    </div>
                                    <div class="product_image_all_div">
                                        
                                    </div>
                                </div>
                                @if ($errors->has('blog_image'))
                                    <span class="text-danger"> {{ $errors->first('blog_image') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <input type="checkbox" id="comments" class="filled-in" name="comments" value="0">
                                    <label for="comments">{{__("blog.close_comments")}}</label>
                                </div>
                                <div  class="col-lg-12">
                                    <input type="checkbox" id="publish" class="filled-in" name="status" value="1">
                                    <label for="publish">{{__("blog.publish")}}</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="primary_btn_2 mt-5"><i class="ti-check"></i>{{__("common.save")}} </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
</section>
@endsection
@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            $(document).ready(function () {
                $(document).on('keyup', '#title{{auth()->user()->lang_code}}', function(event){
                    processSlug($('#title{{auth()->user()->lang_code}}').val(), '#slug');
                });
                $('.summernote').summernote({
                    height: 200,
                    codeviewFilter: true,
                    codeviewIframeFilter: true,
                    disableDragAndDrop:true,
                    callbacks: {
                        onImageUpload: function (files) {
                            sendFile(files, '.summernote')
                        }
                    }
                });
                $(document).on('click', '.default_lang', function(event){
                    var lang = $(this).data('id');
                    if (lang == "{{auth()->user()->lang_code}}") {
                        $('#default_lang_{{auth()->user()->lang_code}}').removeClass('d-none');
                    }
                });
                if ("{{auth()->user()->lang_code}}") {
                    $('#default_lang_{{auth()->user()->lang_code}}').removeClass('d-none');
                }
                $(document).on('keyup', '#title{{auth()->user()->lang_code}}', function(event){
                    processSlug($('#title{{auth()->user()->lang_code}}').val(), '#slug{{auth()->user()->lang_code}}');
                });
                $(document).on('click', '.tag-add', function(e){
                    e.preventDefault();
                    $('#tag-input-upload-shots').tagsinput('add', $(this).text());
                });
                $(document).on('change', '#blog_image', function(event){
                    getFileName($('#blog_image').val(),'#image');
                    imageChangeWithFile($(this)[0],'#MetaImgDiv');
                });
                $(document).on('focusout', '#title', function(){
                    // tag get
                    $("#tag_show").html('<li></li>');
                    var sentence = $(this).val();
                    $.get('/setup/getTagBySentence',{sentence:sentence},function(result){
                        $("#tag_show").append(result);
                    })
                });
            });
        })(jQuery);
    </script>
@endpush
