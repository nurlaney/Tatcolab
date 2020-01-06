<?php
session_start();
$_SESSION['KCFINDER'] = array(
    'disabled' => false
);
?>
@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.generals.edit'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Footer menus
                        <small class="text-muted">Create</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col">
    @include('backend.forms.lng_selector', ['lngs'=>$lngs])
    <form action="{{route('admin.footer_menus.store')}}" enctype="multipart/form-data" method="post" class="form-horizontal form-label-left">
        @csrf
        
        @foreach($lngs as $lng)
            <div class="row lng-form" id="{{ $lng->u_id }}" @if(!$lng->default) style="display: none" @endif>

                @include('backend.forms.number', ['label'=>'Ordering',
                'name'=>'ordering',
                'value'=>old('ordering'.$lng->u_id),
                'lng'=>$lng,
                'required'=>$lng->default])
                
                @include('backend.forms.text', ['label' => 'Title',
                'name'=>'title',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>$lng->default])

                @include('backend.forms.text', ['label' => 'Description',
                'name'=>'description',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>$lng->default])

                @include('backend.forms.text', ['label' => 'Keyword',
                'name'=>'keyword',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>$lng->default])

                @include('backend.forms.text', ['label' => 'Name',
                'name'=>'name',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>$lng->default])

                @include('backend.forms.ckeditor', ['label' => 'Text',
                'name'=>'text',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>0])

                @include('backend.forms.text', ['label' => 'Url tag',
                'name'=>'url_tag',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>$lng->default])

            </div>
        @endforeach

        @include('backend.forms.file_image', ['label' => 'Picture',
                'name'=>'picture',
                'required'=>1])

        @include('backend.forms.file_image', ['label' => 'Arxa fon',
                'name'=>'bg_image',
                'required'=>1])

        </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.footer_menus'), __('buttons.general.cancel')) }}
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
    </script>
    
@endsection

