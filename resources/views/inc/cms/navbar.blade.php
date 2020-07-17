<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <img 
          src="{{ Auth::user()->image === null 
            ? Avatar::create(Auth::user()->name)->toBase64()
            : asset('storage/images/users/' . Auth::user()->image) }}" 
          class="user-image img-circle elevation-2" 
          alt="User Image">
        <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <li class="user-header" style="background-color: #F8F9FA;">
          <img 
            src="{{ Auth::user()->image === null 
                  ? Avatar::create(Auth::user()->name)->toBase64()
                  : asset('storage/images/users/' . Auth::user()->image) }}" 
            class="img-circle elevation-2" 
            alt="User Image">
          <p>
            {{ auth()->user()->name }}
          </p>
        </li>
        <li class="user-footer">
          <a href="{{ route('users.profile', auth()->user()->id) }}" class="btn btn-default btn-flat">Profile</a>
          <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        </li>
      </ul>
    </li>
  </ul>
</nav>

<form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none;">
  @csrf
</form>