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
    <form action="{{route('admin.news.store')}}" enctype="multipart/form-data" method="post" class="form-horizontal form-label-left">
        @csrf
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Post
                        <small class="text-muted">Create</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col">
        
        @foreach($lngs as $lng)
            <div class="row lng-form" id="{{ $lng->u_id }}" @if(!$lng->default) style="display: none" @endif>

                @include('backend.forms.text', ['label' => 'Başlıq',
                'name'=>'title',
                'lng'=>$lng,
                'value'=>old('title'.$lng->u_id),
                'required'=>$lng->default])

                @include('backend.forms.textarea', ['label' => 'Haqqında',
                'name'=>'description',
                'lng'=>$lng,
                'value'=>old('description'.$lng->u_id),
                'required'=>$lng->default])

                @include('backend.forms.textarea', ['label' => 'Qısa Başlıq',
                                'name'=>'stitle',
                                'lng'=>$lng,
                                'value'=>old('stitle'.$lng->u_id),
                                'required'=>$lng->default])


                @include('backend.forms.ckeditor', ['label' => 'Mətn',
               'name'=>'text',
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
                    <input type="text" class="form-control" name='tag' value=''/> 
                </div> 
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
                    @foreach($options as $option)
                        <option value="{{ $option->u_id }}">{{ $option->title }}</option>
                    @endforeach
                </select>
            </div>
            </div>    
        </div>
        
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">


        @include('backend.forms.file_image', ['label' => 'picture',
                'name'=>'image',
                'required'=>1])

        </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.news'), __('buttons.general.cancel')) }}
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
        })
        $('#cats').select2();
    </script>
    
@endsection

