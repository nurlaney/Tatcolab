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
        <form action="{{route('admin.generals.update',[$generalsL[0]->u_id])}}" enctype="multipart/form-data" file="true" method="post" class="form-horizontal form-label-left">
            @csrf
        @foreach($generalsL as $general)
            @if($general->lng)
            <div class="row lng-form" id="{{ $general->l_id }}" @if(!$general->lng->default) style="display: none" @endif>

            
                @include('backend.forms.text', ['label' => 'Address',
                'name'=>'address',
                'lng'=>$general->lng,
                'value'=>$general->address,
                'required'=>0])

                @include('backend.forms.text', ['label' => 'Address embed',
                'name'=>'address_embed',
                'lng'=>$general->lng,
                'value'=>$general->address_embed,
                'required'=>0])
                
                @include('backend.forms.ckeditor', ['label' => 'Info',
                'name'=>'about',
                'lng'=>$general->lng,
                'value'=>$general->about,
                'required'=>0])

                @include('backend.forms.number', ['label' => 'Phone',
                'name'=>'phone',
                'lng'=>$general->lng,
                'value'=>$general->phone,
                'required'=>0])

                @include('backend.forms.email', ['label' => 'Email',
                'name'=>'email',
                'lng'=>$general->lng,
                'value'=>$general->email,
                'required'=>0])
                
                @include('backend.forms.text', ['label' => 'Copyright text',
                'name'=>'copyright',
                'lng'=>$general->lng,
                'value'=>$general->copyright,
                'required'=>0])
                
                @include('backend.forms.text', ['label' => 'Facebook link',
                'name'=>'fb',
                'lng'=>$general->lng,
                'value'=>$general->fb,
                'required'=>0])
                
                @include('backend.forms.text', ['label' => 'Instagram link',
                'name'=>'instagram',
                'lng'=>$general->lng,
                'value'=>$general->instagram,
                'required'=>0])

                @include('backend.forms.text', ['label' => 'Youtube link',
                'name'=>'youtube',
                'lng'=>$general->lng,
                'value'=>$general->youtube,
                'required'=>0])

            </div>
            @endif
        @endforeach

        @include('backend.forms.file_image', ['label' => 'Logo',
            'name'=>'logo',
            'required'=>0])

        </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.generals'), __('buttons.general.cancel')) }}
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
        
    </script>
@endsection

