<div class="modal fade admin-query" id="editModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('common.edit')}}</h4>
                <button type="button" class="close" data-dismiss="modal"><i class="ti-close "></i></button>
            </div>
            <form  method="POST" action="{{route('footerSetting.footer.widget-update')}}" id="widget_edit_form">
                @csrf
                @method('POST')
                <input type="hidden" name="id" id="widgetEditId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                @foreach ($LanguageList as $key => $language)
                                    <li class="nav-item">
                                        <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#emacelement{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach ($LanguageList as $key => $language)
                                    <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="emacelement{{$language->code}}">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="name">{{__('frontendCms.page_name')}}<span class="text-danger">*</span></label>
                                            <input class="primary_input_field " type="text" name="name[{{$language->code}}]" id="widget_name_{{$language->code}}" autocomplete="off">
                                        </div>
                                        @error('name.'.auth()->user()->lang_code)
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.page') }} {{__('common.list')}} <span class="text-danger">*</span></label>
                                <select name="page" id="editPage" class="primary_select mb-15">
                                    <option value="" selected disabled>{{__('common.select_one')}}</option>
                                    @if(isModuleActive('MultiVendor'))
                                        @foreach ($dynamicPageList as $page)
                                            <option value="{{ $page->id }}">{{ $page->title }}</option>
                                        @endforeach
                                    @else
                                        @foreach ($dynamicPageList->where('id', '!=', 4) as $page)
                                            <option value="{{ $page->id }}">{{ $page->title }}</option>
                                        @endforeach
                                    @endif

                                </select>
                                @error('page')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="col-lg-12 text-center mt-40">
                            <button type="button" class="primary-btn tr-bg mr-10 modal_cancel_btn" data-dismiss="modal">{{__('common.cancel')}}</button>
                            <button type="submit" class="primary-btn fix-gr-bg tooltip-wrapper " data-original-title="" title="">
                                <span class="ti-check"></span>
                                {{__('common.update')}} </button>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>
