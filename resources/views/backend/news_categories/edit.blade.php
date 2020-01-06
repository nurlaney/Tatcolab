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
        <form action="{{route('admin.news_categories.update',[$categoriesL[0]->u_id])}}" enctype="multipart/form-data" file="true" method="post" class="form-horizontal form-label-left">
            @csrf
        
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Categories
                        <small class="text-muted">Edit</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                
         <div class="col">   
        @foreach($categoriesL as $category) 
        @if($category->lng) 
            <div class="row lng-form" id="{{ $category->l_id }}" @if(!$category->lng->default) style="display: none" @endif> 
                 @include('backend.forms.number', 
                    ['label'=>'Ordering', 
                    'name'=>'ordering', 
                    'lng'=>$category->lng, 
                    'value'=>$category->ordering, 
                    'required'=>0]) 
                 
                 @include('backend.forms.text', 
                    ['label' => 'Title', 
                    'name'=>'title', 
                    'lng'=>$category->lng, 
                    'value'=>$category->title, 
                    'required'=>0]) 
         </div> 
        @endif 
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
                    <input type="text" class="form-control" name='tag' value='{{$categoriesL[0]->tag}}'/> 
                </div> 
            </div>
            </div> 
        </div>    
        <div class="col-md-12 col-sm-12 col-xs-12"> 
            <div class="form-group">
                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2"></div>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sub_id">
                    Alt kateqoriya 
                    <span class="required">*</span> 
                </label> 
                <div class="col-md-4 col-sm-4 col-xs-12"> 
                    <select class="select2_group form-control" name="sub_id" id="sub_id"> 
                        <option value="0">---</option> 
                        @foreach($categories as $option) 
                        <option value="{{ $option->u_id }}" @if($category->sub_id == $option->u_id) selected @endif>{{ $option->title }}</option> 
                        @endforeach 
                    </select> 
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
                    {{ form_cancel(route('admin.news_categories'), __('buttons.general.cancel')) }}
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
    <script>
        $('input[type="radio"]').on('click', function () {
            var forms = $('.lng-form');
            for (var i = 0; i < forms.length; i++) {
                if ($(forms[i]).attr('id') != $(this).val()) {
                    $(forms[i]).css('display', 'none');
                } else $(forms[i]).css('display', 'block');
            }
        });
        
    </script>
@endsection

