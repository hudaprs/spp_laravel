<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Laravel Starter</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img 
                    src="{{ Auth::user()->image === null 
                        ? Avatar::create(Auth::user()->name)->toBase64()
                        : asset('storage/images/users/' . Auth::user()->image) }}" 
                    class="img-circle elevation-2" 
                    alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('users.profile', Auth::user()->id) }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('cms') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @if(Auth::user()->role->name === 'High Admin')
                    <li 
                        class="nav-item has-treeview 
                            @if(Request::is('cms/master*')) 
                                {{ 'menu-open' }} 
                            @endif">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>
                                Master
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('cms/master/users') ? 'active' : '' }}">
                                    <i class="far fa-user nav-icon"></i>
                                    <p>Pengguna</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link {{ Request::is('cms/master/roles') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Hak Akses</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('grades.index') }}" class="nav-link {{ Request::is('cms/master/grades') ? 'active' : '' }}">
                                    <i class="far fa-star nav-icon"></i>
                                    <p>Kelas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('spp.index') }}" class="nav-link {{ Request::is('cms/master/spp') ? 'active' : '' }}">
                                    <i class="far fa-clipboard nav-icon"></i>
                                    <p>Spp</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>