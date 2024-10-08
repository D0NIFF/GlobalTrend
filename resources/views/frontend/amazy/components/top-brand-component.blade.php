<div id="top_brands" class="amaz_brand {{$top_brands->status == 0?'d-none':''}}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title d-flex align-items-center gap-3 mb_30">
                    <h3 id="top_brands_title" class="m-0 flex-fill">{{$top_brands->title}}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="amazBrand_boxes">
                    @foreach($top_brands->getBrandByQuery() as $key => $brand)
                        <a href="{{route('frontend.category-product',['slug' => $brand->slug, 'item' =>'brand'])}}" class="single_brand d-flex align-items-center justify-content-center">
                            @if(app('general_setting')->lazyload == 1)
                            <img data-src="{{ showImage($brand->logo?$brand->logo:'frontend/default/img/brand_image.png') }}" src="{{showImage(themeDefaultImg())}}" class="lazyload" alt="{{$brand->name}}" title="{{$brand->name}}">
                            @else
                            <img src="{{ showImage($brand->logo?$brand->logo:'frontend/default/img/brand_image.png') }}" alt="{{$brand->name}}" title="{{$brand->name}}">

                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
