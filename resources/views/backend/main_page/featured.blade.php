@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.generals.title'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Control main page <small class="text-muted">Featured</small>
                </h4>
            </div><!--col-->
            
        </div><!--row-->
        <form action="{{route('admin.main_page.store_featured')}}" method="get">    
        <div class="row mt-4">
                <div class="col-12">
                    <div class='alert alert-danger'>Using 2 products for featured banner is recommended for better design option.</div>
                    <h3>Add products to highlight on season sale section</h3>
                    <select id="products_on_sale" name="featured[]" class="select2" multiple="multiple" style="width: 100%" autocomplete="off" >
                    @if($products->count()>0)    
                    @foreach($products as $product)
                        <option @if($product->on_featured == 1 ) disabled @endif value="{{ $product->u_id }}">{{ $product->title }}</option>
                    @endforeach
                    @endif
                    </select>
                                        
                </div><!--col-->
                    @if($products_on_featured->count() > 0)
                        @foreach($products_on_featured as $featured)
                        <div class="col-md-2 col-sm-3 col-xs-12 mb-3 mt-3">
                        <img width='100' height='100' src="{{asset('img/site/'.$featured->first_image)}}"><a class="fas fa-times fa-2x text-danger" href="{{route('admin.main_page.remove_featured',[$featured->u_id])}}"></a>
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