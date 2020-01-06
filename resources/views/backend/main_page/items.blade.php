@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.generals.title'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Control main page <small class="text-muted">Manage items</small>
                </h4>
            </div><!--col-->
            
        </div><!--row-->
        <form action="{{route('admin.main_page.store_items')}}" method="get">    
        <div class="row mt-4">
                <div class="col-12">
                    <h3>Add products to highlight on season sale section</h3>
                    <select id="products_on_sale" name="products_on_sale[]" class="select2" multiple="multiple" style="width: 100%" autocomplete="off" >
                    @if($products_sale->count()>0)    
                    @foreach($products_sale as $product)
                        <option @if($product->on_sale == 1 ) disabled @endif value="{{ $product->u_id }}">{{ $product->title }}</option>
                    @endforeach
                    @endif
                    </select>
                                        
                </div><!--col-->
                    @if($products_on_sale->count() > 0)
                        @foreach($products_on_sale as $sale)
                        <div class="col-md-2 col-sm-3 col-xs-12 mb-3 mt-3">
                        <img width='100' height='100' src="{{asset('img/site/'.$sale->first_image)}}"><a class="fas fa-times fa-2x text-danger" href="{{route('admin.main_page.remove_sale',[$sale->u_id])}}"></a>
                        </div>
                        @endforeach
                    @endif

                
            </div><!--row-->
        <div class="row mt-4">
                <div class="col-12">
                    <h3>Add products to highlight on new arrivals section</h3>
                    <select id="products_on_arrivals" name="products_on_arrivals[]" class="select2" multiple="multiple" style="width: 100%" autocomplete="off" >
                    @foreach($products as $product)
                        <option @if($product->on_arrivals == 1 ) disabled @endif value="{{ $product->u_id }}">{{ $product->title }}</option>
                    @endforeach
                    </select>
                                        
                </div><!--col-->
                    @if($products_on_arrivals->count() > 0)
                        @foreach($products_on_arrivals as $arrival)
                        <div class="col-md-2 col-sm-3 col-xs-12 mb-3 mt-3">
                        <img width='100' height='100' src="{{asset('img/site/'.$arrival->first_image)}}"> <a class="fas fa-times fa-2x text-danger" href="{{route('admin.main_page.remove_arrivals',[$arrival->u_id])}}"></a>
                        </div>
                        @endforeach
                    @endif

                
            </div><!--row-->
        <div class="row mt-4">
                <div class="col-12">
                    <h3>Add categories to highlight on main page</h3>
                    <select id="category" name="categories[]" class="select2" multiple="multiple" style="width: 100%" autocomplete="off" >
                    @foreach($categories as $category)
                        <option @if($category->on_main_page == 1 ) disabled @endif value="{{ $category->u_id }}">{{ $category->title }}</option>
                    @endforeach
                    </select>
                                        
                </div><!--col-->
                    @if($categories_on_main->count() > 0)
                        @foreach($categories_on_main as $category)
                        <div class="col-md-2 col-sm-3 col-xs-12 mb-3 mt-3">
                        <img width='100' height='100' src="{{asset('img/site/'.$category->image)}}"><a class="fas fa-times fa-2x text-danger" href="{{route('admin.main_page.remove_category',[$category->u_id])}}"></a>
                        </div>
                        @endforeach
                    @endif

                
            </div><!--row-->
            
            <div class="row mt-4">
                <div class="col-12">
                    <h3>Add brands to highlight on main page</h3>
                    <select id="brand" name="brands[]" class="select2" multiple="multiple" style="width: 100%" autocomplete="off" >
                    @foreach($brands as $brand)
                        <option @if($brand->on_main_page == 1 ) disabled @endif value="{{ $brand->u_id }}">{{ $brand->title }}</option>
                    @endforeach
                    </select>
                                        
                </div><!--col-->
                    @if($brands_on_main->count() > 0)
                        @foreach($brands_on_main as $brand)
                        <div class="col-md-2 col-sm-3 col-xs-12 mb-3 mt-3">
                        <img width='100' height='100' src="{{asset('img/site/'.$brand->logo)}}"><a class="fas fa-times fa-2x text-danger" href="{{route('admin.main_page.remove_brand',[$brand->u_id])}}"></a>
                        </div>
                        @endforeach
                    @endif

                
            </div><!--row-->
            
            <button type="submit" class="btn btn-success mt-4">Save</button>
            
        </form>    
                    
</div><!--card-body-->
</div><!--card-->

<script>
    $('#products_on_sale').select2();
    $('#products_on_arrivals').select2();
    $('#category').select2();
    $('#brand').select2();
</script>

@endsection