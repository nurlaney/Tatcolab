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
    <form action="{{route('admin.products.store')}}" enctype="multipart/form-data" method="post" class="form-horizontal form-label-left">
        @csrf
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Products
                        <small class="text-muted">Create</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col">
        @foreach($lngs as $lng)
            <div class="row lng-form" id="{{ $lng->u_id }}" @if(!$lng->default) style="display: none" @endif>
                
                @include('backend.forms.number', ['label' => 'Ordering',
                'name'=>'ordering',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>$lng->default])
                 
                @include('backend.forms.text', ['label' => 'Başlıq',
                'name'=>'title',
                'lng'=>$lng,
                'value'=>old('title'.$lng->u_id),
                'required'=>$lng->default])

                @include('backend.forms.textarea', ['label' => 'Haqqında',
                'name'=>'brief_info',
                'lng'=>$lng,
                'value'=>old('description'.$lng->u_id),
                'required'=>$lng->default])

                @include('backend.forms.ckeditor', ['label' => 'Mətn',
               'name'=>'description',
               'lng'=>$lng,
               'value'=>old('text'.$lng->u_id),
               'required'=>$lng->default])
               
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
                    <input type="text" class="form-control" name='tag' /> 
                </div> 
            </div>
            </div> 
        </div>
        
        @include('backend.forms.file_image', ['label' => 'İlk şəkil',
                'name'=>'first_image',
                'required'=>1])

        @include('backend.forms.file_image', ['label' => 'İkinci şəkil',
                'name'=>'second_image',
                'required'=>1])
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-2"></div>
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cats">
                        Qiymət
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="number" class="form-control" min="0" name="price" required/>
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
                        <input type="number" class="form-control" min="0" name="discount_price" required/>
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
                <select id="cats" name="categories[]" class="select2" multiple="multiple" style="width: 100%"
                        autocomplete="off" required>
                    @foreach($category_options as $option)
                        <option value="{{ $option->u_id }}">{{ $option->title }}</option>
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
                <select id="brands" name="brands[]" class="select2" multiple="multiple" style="width: 100%"
                        autocomplete="off" required>
                    @foreach($brand_options as $option)
                        <option value="{{ $option->u_id }}">{{ $option->title }}</option>
                    @endforeach
                </select>
            </div>
            </div>     
        </div>
        
        <div class="form-group">
            <div class="row">
                 <div class="col-md-2 col-sm-2 col-xs-2"></div>
                    
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="products">
                Linked products
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <select id="products" name="linked_products[]" class="select2" multiple="multiple" style="width: 100%"
                        autocomplete="off">
                    @foreach($products as $option)
                        <option value="{{ $option->u_id }}">{{ $option->title }}</option>
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
                    <input type="file" id="" name="picture[]" value="" class="form-control"/>
                    <div class="input-group-btn">
                        <button class="btn btn-success" type="button"><i class="fas fa-plus"></i>Add</button>
                    </div>
                </div>
                <div class="clone hide" style="display:none">
                    <div class="control-group input-group" style="margin-top:10px">
                        <input type="file" name="picture[]"  class="form-control">
                        <div class="input-group-btn">
                            <button class="btn btn-danger" type="button"><i class="fas fa-trash"></i> Remove</button>
                        </div>
                    </div>
                </div>
            </div>
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
                        class="btn btn-success"> {{ __('buttons.general.crud.create') }}
                    </button>
                    
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
</form>
<script>
    $('input[type="radio"]').on('click', function () {
        var forms = $('.lng-form');
        for (var i = 0; i < forms.length; i++) {
            if ($(forms[i]).attr('id') != $(this).val()) {
                $(forms[i]).css('display', 'none');
            } else $(forms[i]).css('display', 'block');
        }
    });

        $('#cats').select2();
        $('#brands').select2();
        $('#products').select2();

    $('input[type=number]').on('keyup',function(){
        if($(this).val() <0){
            $(this).val('');
        }
    });

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

