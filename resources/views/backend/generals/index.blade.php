@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.generals.title'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('strings.backend.generals.title') }} <small class="text-muted"> Main page </small>
                </h4>
            </div><!--col-->

            
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Logo</th>
                            <th>Fb</th>
                            <th>Instagram</th>
                            <th>Youtube</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$generals->address}}</td>
                                <td>{{$generals->email}}</td>
                                <td>{{$generals->phone}}</td>
                                <td><img width="100px" height="80px" src="{{asset('img/site/'.$generals->logo)}}" alt="Logo"></td>
                                <td>{{$generals->fb}}</td>
                                <td>{{$generals->instagram}}</td>
                                <td>{{$generals->youtube}}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <a href="{{ route('admin.generals.edit', [$generals->u_id]) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        

                                    </div>    
                                </td>
                            </tr>
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
