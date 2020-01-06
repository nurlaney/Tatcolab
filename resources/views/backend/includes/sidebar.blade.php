<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Route::is('admin/dashboard'))
                }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            @if ($logged_in_user->isAdmin())
                <li class="nav-title">
                    @lang('menus.backend.sidebar.system')
                </li>

                <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/auth*'), 'open')
                }}">
                    <a class="nav-link nav-dropdown-toggle {{
                        active_class(Route::is('admin/auth*'))
                    }}" href="#">
                        <i class="nav-icon far fa-user"></i>
                        @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/user*'))
                            }}" href="{{ route('admin.auth.user.index') }}">
                                @lang('labels.backend.access.users.management')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/role*'))
                            }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="divider"></li>
                
                <li class="nav-item">
                    <a class="nav-link {{
                        active_class(Route::is('admin/generals'))
                    }}" href="{{ route('admin.generals') }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        Generals
                    </a>
                </li>
            
                <li class="divider"></li>

                <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/menus*'), 'open')
                }}">
                        <a class="nav-link nav-dropdown-toggle {{
                            active_class(Route::is('admin/menus*'))
                        }}" href="#">
                        <i class="nav-icon fas fa-bars"></i> Menus
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/menus/'))
                        }}" href="{{ route('admin.menus') }}">
                                Top menu
                            </a>
                        </li>
                        
                    </ul>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/footer_menus/'))
                        }}" href="{{ route('admin.footer_menus') }}">
                                Footer menu
                            </a>
                        </li>
                        
                    </ul>
                </li>
                
                <li class="divider"></li>
                
                <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/menus*'), 'open')
                }}">
                        <a class="nav-link nav-dropdown-toggle {{
                            active_class(Route::is('admin/menus*'))
                        }}" href="#">
                        <i class="nav-icon fas fa-home"></i> Main page control
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/main_page/'))
                        }}" href="{{ route('admin.main_page') }}">
                                Put items on main page
                            </a>
                        </li>
                        
                    </ul>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/main_page/featured'))
                        }}" href="{{ route('admin.main_page.featured') }}">
                                Manage featured banner
                            </a>
                        </li>
                        
                    </ul>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/main_page/fluid_banners'))
                        }}" href="{{ route('admin.main_page.fluid_banner') }}">
                                Fluid banners
                            </a>
                        </li>
                        
                    </ul>
                </li>
                
                <li class="divider"></li>
                
                <li class="nav-item">
                    <a class="nav-link {{
                        active_class(Route::is('admin/categories'))
                    }}" href="{{ route('admin.categories') }}">
                        <i class="nav-icon fas fa-puzzle-piece"></i>
                        Categories
                    </a>
                </li>
                
                <li class="divider"></li>
                
                <li class="nav-item">
                    <a class="nav-link {{
                        active_class(Route::is('admin/brands'))
                    }}" href="{{ route('admin.brands') }}">
                        <i class="nav-icon fas fa-registered"></i>
                        Brands
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{
                        active_class(Route::is('admin/products'))
                    }}" href="{{ route('admin.products') }}">
                        <i class="nav-icon fas fa-wrench"></i>
                        Products
                    </a>
                </li>
                
                <li class="divider"></li>
                
                <li class="nav-item">
                    <a class="nav-link {{
                        active_class(Route::is('admin/news'))
                    }}" href="{{ route('admin.news') }}">
                        <i class="nav-icon far fa-newspaper"></i>
                        Post
                    </a>
                </li>
                
                <li class="divider"></li>
                
                <li class="nav-item">
                    <a class="nav-link {{
                        active_class(Route::is('admin/news_categories'))
                    }}" href="{{ route('admin.news_categories') }}">
                        <i class="nav-icon fas fa-puzzle-piece"></i>
                        Post categories
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{
                        active_class(Route::is('admin/sliders'))
                    }}" href="{{ route('admin.sliders') }}">
                        <i class="nav-icon fas fa-images"></i>
                        Sliders
                    </a>
                </li>
                
                <li class="divider"></li>
                
                <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/log-viewer*'), 'open')
                }}">
                        <a class="nav-link nav-dropdown-toggle {{
                            active_class(Route::is('admin/log-viewer*'))
                        }}" href="#">
                        <i class="nav-icon fas fa-list"></i> @lang('menus.backend.log-viewer.main')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/log-viewer'))
                        }}" href="{{ route('log-viewer::dashboard') }}">
                                @lang('menus.backend.log-viewer.dashboard')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/log-viewer/logs*'))
                        }}" href="{{ route('log-viewer::logs.list') }}">
                                @lang('menus.backend.log-viewer.logs')
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
