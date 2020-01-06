<?php
session_start();
$_SESSION['KCFINDER'] = array(
    'disabled' => false
);
?>
@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . 'Sliders')

@section('content')
@include('backend.forms.lng_selector', ['lngs'=>$lngs])
    <form action="{{route('admin.sliders.store')}}" enctype="multipart/form-data" method="post" class="form-horizontal form-label-left">
        @csrf
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Sliders
                        <small class="text-muted">Create</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col">
        
@foreach($lngs as $lng)
            <div class="row lng-form" id="{{ $lng->u_id }}"
                 @if(!$lng->default) style="display: none" @endif>

                @include('backend.forms.number', ['label' => 'Ordering',
                        'name'=>'ordering',
                        'lng'=>$lng,
                        'value'=>old('ordering'.$lng->u_id),
                        'required'=>$lng->default])
 
                 
                @include('backend.forms.text', ['label' => 'Ilk başlıq',
                        'name'=>'first_title',
                        'lng'=>$lng,
                        'value'=>old('first_title'.$lng->u_id),
                        'required'=>$lng->default])

                @include('backend.forms.textarea', ['label' => 'Ikinci başlıq',
                        'name'=>'second_title',
                        'lng'=>$lng,
                        'value'=>old('second_title'.$lng->u_id),
                        'required'=>$lng->default])

                @include('backend.forms.text', ['label' => 'Düymə mətni',
                                   'name'=>'button_text',
                                   'lng'=>$lng,
                                   'value'=>old('button_text'.$lng->u_id),
                                   'required'=>$lng->default])


                @include('backend.forms.text', ['label' => 'Düymə linki',
                      'name'=>'button_path',
                      'lng'=>$lng,
                      'value'=>old('button_path'.$lng->u_id),
                      'required'=>$lng->default])
            </div>
        @endforeach

        @include('backend.forms.file_image', ['label' => 'Şəkil',
                       'name'=>'picture',
                       'required'=>1])

        
        </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.sliders'), __('buttons.general.cancel')) }}
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

