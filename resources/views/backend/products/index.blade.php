@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.generals.title'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Products <small class="text-muted">Main page</small>
                </h4>
            </div><!--col-->
            <div class="col-sm-7">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i></a>
                </div><!--btn-toolbar-->
            </div>
            
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Language</th>
                            <th>Title</th>
                            <th>Brief info</th>
                            <th>Price</th>
                            <th>Discount price</th>
                            <th>First image</th>
                            <th>Second image</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->lng->org_name }}</td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->brief_info }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->discount_price }}</td>
                                <td><img src="{{asset('img/site/'.$product->first_image)}}" width="50px"
                                         alt="{{ $product->first_image }}"></td>
                                <td><img src="{{asset('img/site/'.$product->second_image) }}" width="50px"
                                         alt="{{ $product->second_image }}"></td>

                                <td>
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        
                                        @if(!$product->trashed())
                                            <a href="{{ route('admin.products.edit', [$product->u_id]) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasRole('administrator'))
                                            @if($product->trashed())
                                                <a href="{{ route('admin.products.restore', [$product->u_id]) }}" data-toggle="tooltip" data-placement="top" title="Restore" class="btn btn-secondary">
                                                    <i class="fas fa-undo"></i>
                                                </a>
                                                <a href="{{ route('admin.products.forceDelete', [$product->u_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                    
                                            @else
                                                <a href="{{ route('admin.products.destroy', [$product->u_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                        @endif
                                        
                                        

                                    </div>    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-9">
                
            </div><!--col-->

            <div class="col-3">
                {{ $products->links() }}
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
