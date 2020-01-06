@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.generals.title'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Footer menus <small class="text-muted">Main page</small>
                </h4>
            </div><!--col-->
            <div class="col-sm-7">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                    <a href="{{ route('admin.footer_menus.create') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i></a>
                </div><!--btn-toolbar-->

            </div>
            
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Language</th>
                            <th>Ordering</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Keyword</th>
                            <th>Name</th>
                            <th>Url_tag</th>
                            <th>Front Picture</th>
                            <th>Back picture</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)
                            <tr>
                                <td>{{ $menu->lng->org_name }}</td>
                                <td>{{ $menu->ordering }}</td>
                                <td>{{ $menu->title }}</td>
                                <td>{{ $menu->description }}</td>
                                <td>{{ $menu->keyword }}</td>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->url_tag }}</td>
                                <td><img src="{{ asset('img/site/'.$menu->picture) }}" width="50px" alt="{{ $menu->picture }}"></td>
                                <td><img src="{{ asset('img/site/'.$menu->bg_image) }}" width="50px" alt="{{ $menu->bg_image }}"></td>
                    
                                <td>
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        
                                        @if(!$menu->trashed())
                                            <a href="{{ route('admin.footer_menus.edit', [$menu->u_id]) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasRole('administrator'))
                                            @if($menu->trashed())
                                                <a href="{{ route('admin.footer_menus.restore', [$menu->u_id]) }}" data-toggle="tooltip" data-placement="top" title="Restore" class="btn btn-secondary">
                                                    <i class="fas fa-undo"></i>
                                                </a>
                                                <a href="{{ route('admin.footer_menus.forceDelete', [$menu->u_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                    
                                            @else
                                                <a href="{{ route('admin.footer_menus.destroy', [$menu->u_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                        @endif
                                        
                                        

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
            <div class="col-9">
                
            </div><!--col-->

            <div class="col-3">
                {{ $menus->links() }}
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
