@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.generals.title'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Main page control <small class="text-muted"> Fluid banners </small>
                </h4>
            </div><!--col-->

            
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>First text</th>
                            <th>Second text</th>
                            <th>Button Path</th>
                            <th>Button text</th>
                            <th>Logo</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($banners as $banner)
                            <tr>
                                <td>{{$banner->first_text}}</td>
                                <td>{{$banner->second_text}}</td>
                                <td>{{$banner->button_path}}</td>
                                <td>{{$banner->button_text}}</td>
                                <td><img width="100px" height="80px" src="{{asset('img/site/'.$banner->image)}}" alt="Image"></td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <a href="{{ route('admin.main_page.fluid_banner.edit', [$banner->u_id]) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        

                                    </div>    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                
            </div><!--col-->

            <div class="col-5">
                
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
