<?php
session_start();
$_SESSION['KCFINDER'] = array(
    'disabled' => false
);
?>
@extends('admin.layouts.admin')

@section('title', 'Languages')

@section('content')
    <div class="row x_panel">
        @include('admin.forms.lng_selector', ['lngs'=>$lngs])
        {{ Form::open(['route'=>['admin.generals.store'],'enctype'=>'multipart/form-data', 'method' => 'post', 'class'=>'form-horizontal form-label-left']) }}
        @foreach($lngs as $lng)
            <div class="row lng-form" id="{{ $lng->u_id }}" @if(!$lng->default) style="display: none" @endif>

                @include('admin.forms.text', ['label' => 'Address',
                'name'=>'address',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>$lng->default])

                @include('admin.forms.text', ['label' => 'Addresss embed',
                'name'=>'addresss_embed',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>$lng->default])

                @include('admin.forms.number', ['label'=>'Phone number',
                'name'=>'phone',
                'value'=>old('ordering'.$lng->u_id),
                'lng'=>$lng,
                'required'=>$lng->default])
                
                @include('admin.forms.email', ['label' => 'Email',
                'name'=>'email',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>$lng->default])
                
                @include('admin.forms.text', ['label' => 'Copyright text',
                'name'=>'copyright',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>$lng->default])

                @include('admin.forms.text', ['label' => 'Facebook link',
                'name'=>'fb',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>$lng->default])

                @include('admin.forms.text', ['label' => 'Instagram link',
                'name'=>'instagram',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>$lng->default])

                @include('admin.forms.text', ['label' => 'Youtube link',
                'name'=>'youtube',
                'lng'=>$lng,
                'value'=>old('ordering'.$lng->u_id),
                'required'=>$lng->default])

            </div>
        @endforeach
        
        @include('admin.forms.file_image', ['label' => 'Logo',
                'name'=>'logo',
                'required'=>1])


                <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a class="btn btn-primary"
                   href="{{ URL::previous() }}"> {{ __('views.admin.users.edit.cancel') }}</a>
                <button type="submit"
                        class="btn btn-success"> {{ __('views.admin.users.edit.save') }}</button>
            </div>
        </div>
        {{ Form::close()}}
    </div>
@endsection

@section('scripts')
    @parent
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