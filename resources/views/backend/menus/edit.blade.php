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
                        @lang('labels.backend.access.users.management')
                        <small class="text-muted">@lang('labels.backend.access.users.edit')</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col">
        @include('backend.forms.lng_selector', ['lngs'=>$lngs])
        <form action="{{route('admin.menus.update',[$menusL[0]->u_id])}}" enctype="multipart/form-data" file="true" method="post" class="form-horizontal form-label-left">
            @csrf
        @foreach($menusL as $menu)
            @if($menu->lng)
            <div class="row lng-form" id="{{ $menu->l_id }}" @if(!$menu->lng->default) style="display: none" @endif>

            @include('backend.forms.number', ['label'=>'Ordering',
            'name'=>'ordering',
            'lng'=>$menu->lng,
            'value'=>$menu->ordering,
            'required'=>0])

                @include('backend.forms.text', ['label' => 'Title',
                'name'=>'title',
                'lng'=>$menu->lng,
                'value'=>$menu->title,
                'required'=>0])

                @include('backend.forms.text', ['label' => 'Description',
                'name'=>'description',
                'lng'=>$menu->lng,
                'value'=>$menu->description,
                'required'=>0])

                @include('backend.forms.text', ['label' => 'Keyword',
                'name'=>'keyword',
                'lng'=>$menu->lng,
                'value'=>$menu->keyword,
                'required'=>0])

                @include('backend.forms.text', ['label' => 'Name',
                'name'=>'name',
                'lng'=>$menu->lng,
                'value'=>$menu->name,
                'required'=>0])

                @include('backend.forms.ckeditor', ['label' => 'Text',
                'name'=>'text',
                'lng'=>$menu->lng,
                'value'=>$menu->text,
                'required'=>0])

                @include('backend.forms.text', ['label' => 'Url tag',
                'name'=>'url_tag',
                'lng'=>$menu->lng,
                'value'=>$menu->url_tag,
                'required'=>0])
            </div>
            @endif
        @endforeach

        @include('backend.forms.file_image', ['label' => 'Picture',
            'name'=>'picture',
            'required'=>0])

        @include('backend.forms.file_image', ['label' => 'Arxa fon',
                'name'=>'bg_image',
                'required'=>0])

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2"></div> 
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sub_id">
                    Alt menu
                    <span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <select class="select2_group form-control" name="sub_id" id="sub_id">
                        <option value="0">---</option>
                        @foreach($menus as $option)
                            <option value="{{ $option->u_id }}"
                                    @if($menu->sub_id == $option->u_id) selected @endif>{{ $option->name }}</option>
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
                    {{ form_cancel(route('admin.menus'), __('buttons.general.cancel')) }}
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

