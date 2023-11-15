<div class="page-header">
  <div class="search-form">
    <form action="#" method="GET">
      <div class="input-group">
        <input type="text" name="search" class="form-control search-input" placeholder="Type something...">
        <span class="input-group-btn">
          <button class="btn btn-default" id="close-search" type="button"><i class="icon-close"></i></button>
        </span>
      </div>
    </form>
  </div>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <div class="logo-sm">
          <a href="javascript:void(0)" id="sidebar-toggle-button"><i class="fa fa-bars"></i></a>
          <a class="logo-box" href="{{url('doctor/dashboard')}}"><span>{{$setting->name}}</span></a>
        </div>
        <button type="button" class="navbar-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <i class="fa fa-angle-down"></i>
        </button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><a href="javascript:void(0)" id="collapsed-sidebar-toggle-button"><i class="fa fa-bars"></i></a></li>
          <li><a href="javascript:void(0)" id="toggle-fullscreen"><i class="fa fa-expand"></i></a></li>
          <li><a href="javascript:void(0)" id="search-button"><i class="fa fa-search"></i></a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown user-dropdown">
            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" type="button" aria-expanded="false"><img src="{{asset(Auth::guard('diagnostic')->user()->image != '0' ? Auth::guard('diagnostic')->user()->image:'/noimage.jpg')}}" alt="..." class="rounded-circle"></a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{route('diagnostic.profile')}}"><i class="fa fa-user"></i> Profile </a></li>
              <li role="separator" class="divider"></li>
              <li><a class="dropdown-item" href="{{route('diagnostic.password')}}"><i class="fa fa-key"></i> Change Password</a></li>
              <li> 
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  <i class="fas fa-sign-out-alt"></i> Log Out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
  </nav>
</div>