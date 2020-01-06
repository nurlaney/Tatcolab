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
        <form action="{{route('admin.main_page.fluid_banner.update',[$banners[0]->u_id])}}" enctype="multipart/form-data" file="true" method="post" class="form-horizontal form-label-left">
            @csrf
        
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Fluid Banner
                        <small class="text-muted">Edit</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                
         <div class="col">   
        @foreach($banners as $banner)
            <div class="row lng-form" id="{{ $banner->lng->u_id }}" @if(!$banner->lng->default) style="display: none" @endif>
                
                @include('backend.forms.text', ['label' => 'First text',
                    'name'=>'first_text',
                    'lng'=>$banner->lng,
                    'value'=>$banner->first_text,
                    'required'=>0])

                @include('backend.forms.text', ['label' => 'Second text',
                    'name'=>'second_text',
                    'lng'=>$banner->lng,
                    'value'=>$banner->second_text,
                    'required'=>0])

                @include('backend.forms.text', ['label' => 'Button_text',
                    'name'=>'button_text',
                    'lng'=>$banner->lng,
                    'value'=>$banner->button_text,
                    'required'=>0])
                
            </div>

        @endforeach

        <div class="col-md-12 col-sm-12 col-xs-12"> 
            <div class="form-group">
                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2"></div>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tag">
                    Button path
                    <span class="required">*</span> 
                </label> 
                <div class="col-md-4 col-sm-4 col-xs-12"> 
                    <input type="text" class="form-control" name='button_path' value='{{$banners[0]->button_path}}'/> 
                </div> 
            </div>
            </div> 
        </div>
        
        <div class="alert alert-warning text-center">Ideal photo size is @if($banner->u_id == 1) 1397 X 446  @else 537 x 452 @endif</div>
        
        @include('backend.forms.file_image', ['label' => 'Image',
                'name'=>'image',
                'required'=>0])
        
         
            
        
        </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.main_page.fluid_banner'), __('buttons.general.cancel')) }}
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

