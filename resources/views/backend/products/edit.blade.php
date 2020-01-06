<?php
session_start();
$_SESSION['KCFINDER'] = array(
    'disabled' => false
);
?>
@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.generals.edit'))

@section('content')
@include('backend.forms.lng_selector', ['lngs'=>$lngs])
        <form action="{{route('admin.products.update',[$products[0]->u_id])}}" enctype="multipart/form-data" file="true" method="post" class="form-horizontal form-label-left">
            @csrf
        
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Products
                        <small class="text-muted">Edit</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                
         <div class="col">   
        @foreach($products as $product)
            <div class="row lng-form" id="{{ $product->lng->u_id }}" @if(!$product->lng->default) style="display: none" @endif>
                
                 @include('backend.forms.number', ['label' => 'Ordering',
                    'name'=>'ordering',
                    'lng'=>$product->lng,
                    'value'=>$product->ordering,
                    'required'=>0])

                 
                @include('backend.forms.text', ['label' => 'Basliq',
                    'name'=>'title',
                    'lng'=>$product->lng,
                    'value'=>$product->title,
                    'required'=>0])


                @include('backend.forms.textarea', ['label' => 'Haqqinda',
                            'name'=>'brief_info',
                            'lng'=>$product->lng,
                            'value'=>$product->brief_info,
                            'required'=>0])

                

                @include('backend.forms.ckeditor', ['label' => 'Mətn',
                       'name'=>'description',
                       'lng'=>$product->lng,
                       'value'=>$product->description,
                       'required'=>0])
            </div>

        @endforeach

        <div class="col-md-12 col-sm-12 col-xs-12"> 
            <div class="form-group">
                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2"></div>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tag">
                    Tag 
                    <span class="required">*</span> 
                </label> 
                <div class="col-md-4 col-sm-4 col-xs-12"> 
                    <input type="text" class="form-control" name='tag' value='{{$products[0]->tag}}'/> 
                </div> 
            </div>
            </div> 
        </div>
        
        @include('backend.forms.file_image', ['label' => 'First image',
                'name'=>'first_image',
                'required'=>0])
        
        @include('backend.forms.file_image', ['label' => 'Second image',
                'name'=>'second_image',
                'required'=>0])
        
         <div class="form-group">
             <div class="row"> 
                 <div class="col-md-2 col-sm-2 col-xs-2"></div>    
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cats">
                Qiymət
            </label>
             <div class="col-md-4 col-sm-4 col-xs-12">
                 <input type="number" class="form-control" value="{{$products[0]->price}}" name="price" required/>
             </div>
             </div>    
         </div>
         <div class="form-group">
            <div class="row"> 
                 <div class="col-md-2 col-sm-2 col-xs-2"></div>    
             
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cats">
                Endirim
            </label>
             <div class="col-md-4 col-sm-4 col-xs-12">
                 <input type="number" class="form-control" value="{{$products[0]->discount_price}}" name="discount_price" />
             </div>
            </div>    
         </div>      
                
        <div class="form-group">
            <div class="row"> 
                 <div class="col-md-2 col-sm-2 col-xs-2"></div>    
            
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cats">
                Kategoriya
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <select id="cats" name="categories[]" class="select2" multiple="multiple" style="width: 100%" autocomplete="off" required>
                    @foreach($category_options as $option)
                        <option @if($products[0]->categories()->select()->where('u_id', $option->u_id)->first()) selected @endif value="{{ $option->u_id }}">{{ $option->title }}</option>
                    @endforeach
                </select>
            </div>
            </div>     
        </div>
        <div class="form-group">
            <div class="row"> 
                 <div class="col-md-2 col-sm-2 col-xs-2"></div>    
            
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cats">
                Brend
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <select id="brands" name="brands[]" class="select2" multiple="multiple" style="width: 100%" autocomplete="off" required>
                    @foreach($brand_options as $option)
                        <option @if($products[0]->brands()->select()->where('u_id', $option->u_id)->first()) selected @endif value="{{ $option->u_id }}">{{ $option->title }}</option>
                    @endforeach
                </select>
            </div>
            </div>     
        </div>
        
        <div class="form-group">
            <div class="row"> 
                 <div class="col-md-2 col-sm-2 col-xs-2"></div>    
            
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cats">
                Linked products
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
                
                <select id="linked_products" name="linked_products[]" class="select2" multiple="multiple" style="width: 100%" autocomplete="off" required>
                    @foreach($option_products as $option)
                        <option @if(in_array($option->u_id,$linked_products)) selected @endif value="{{ $option->u_id }}">{{ $option->title }}</option>
                    @endforeach
                </select>
            </div>
            </div>     
        </div>
           
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        
        <div class="form-group">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2"></div>    
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                Add image
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="input-group control-group increment" >
                    <input type="file" id="" name="picture[]" value="" class="form-control" accept=".jpg,.jpeg,.png,.gif"/>
                    <div class="input-group-btn">
                        <button class="btn btn-success" type="button"><i class="fas fa-plus"></i>Add</button>
                    </div>
                </div>
                <div class="clone" style="display:none;">
                    <div class="control-group input-group" style="margin-top:10px">
                        <input type="file" name="picture[]"  class="form-control" accept=".jpg,.jpeg,.png,.gif"/>
                        <div class="input-group-btn">
                            <button class="btn btn-danger" type="button"><i class="fas fa-trash"></i> Remove</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>    
        </div>    
            
        <div class="form-group">
            <div class="row">
                @foreach($product_pictures as $picture)
                <div class="col-md-2 col-sm-2 col-xs-12">   
                    <img width="100" height="80" src="{{asset('img/site/'.$picture->name)}}" alt=""/>
                    <a class="close-icon fas fa-times" href='{{route('admin.products.delete_single_photo',['id'=>$picture->id])}}' ></a>
                </div>
                @endforeach
            </div>
                
        </div>    
        
        </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.products'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    <button type="submit"
                        class="btn btn-success"> {{ __('buttons.general.crud.update') }}
                    </button>
                    
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
</form>
    <style>
        .close-icon{
            font-size: 25px;
            color:red;
            cursor:pointer;
        }
        .close-icon:hover{
            text-decoration: none;
        }
    </style>
    <script>
        $('input[type="radio"]').on('click', function () {
            var forms = $('.lng-form');
            for (var i = 0; i < forms.length; i++) {
                if ($(forms[i]).attr('id') != $(this).val()) {
                    $(forms[i]).css('display', 'none');
                } else $(forms[i]).css('display', 'block');
            }
        })
        $('#brands').select2();
        $('#cats').select2();
        $('#linked_products').select2();
        
        $(document).ready(function() {

                $(".btn-success").click(function(){
                    var html = $(".clone").html();
                    $(".increment").after(html);
                });

                $("body").on("click",".btn-danger",function(){
                    $(this).parents(".control-group").remove();
                });

            });
    </script>                    

@endsection

