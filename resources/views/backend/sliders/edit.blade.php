<?php
session_start();
$_SESSION['KCFINDER'] = array(
    'disabled' => false
);
?>
@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . 'Slider')

@section('content')
@include('backend.forms.lng_selector', ['lngs'=>$lngs])
        <form action="{{route('admin.sliders.update',[$sliders[0]->u_id])}}" enctype="multipart/form-data" file="true" method="post" class="form-horizontal form-label-left">
            @csrf
        
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Sliders
                        <small class="text-muted">Edit</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                
         <div class="col">   
        @foreach($sliders as $slider)
            @if($slider->lng)
                <div class="row lng-form" id="{{ $slider->l_id }}"
                     @if(!$slider->lng->default) style="display: none" @endif>

                     @include('backend.forms.number', ['label' => 'Ordering',
                            'name'=>'ordering',
                            'lng'=>$slider->lng,
                            'value'=>$slider->ordering,
                            'required'=>0])

                     
                    @include('backend.forms.text', ['label' => 'Ilk başliq',
                            'name'=>'first_title',
                            'lng'=>$slider->lng,
                            'value'=>$slider->first_title,
                            'required'=>0])

                    @include('backend.forms.textarea', ['label' => 'İkinci başlıq',
                            'name'=>'second_title',
                            'lng'=>$slider->lng,
                            'value'=>$slider->second_title,
                            'required'=>0])

                    @include('backend.forms.text', ['label' => 'Düymə mətni',
                            'name'=>'button_text',
                            'lng'=>$slider->lng,
                            'value'=>$slider->button_text,
                            'required'=>0])

                    @include('backend.forms.text', ['label' => 'Düymə linki',
                            'name'=>'button_path',
                            'lng'=>$slider->lng,
                            'value'=>$slider->button_path,
                            'required'=>0])

                </div>
            @endif
        @endforeach
        
        @include('backend.forms.file_image', ['label' => 'Şəkil',
                       'name'=>'picture',
                       'required'=>0])

        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2"></div>
        <img  style='width:100px !important;'  class="col-md-6"  src="{{asset('img/site/'.$slider->picture)}}" alt='{{$slider->picture}}'>
        </div>               
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

