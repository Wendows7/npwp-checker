<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="/dashboard">NPWP CHECKER</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="/dashboard">NPWP</a>
      </div>
      <ul class="sidebar-menu">
          <li class={{ Request::is('suspect*')? 'active' : '' }}><a class="nav-link" href="{{route('suspect')}}"><i class="far fa-user"></i> <span>Check Data Tersangka</span></a></li>
          @canany(['superadmin','admin'])
          <li class="dropdown {{ Request::is('data/*')? 'active' : '' }}">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-database"></i> <span>Data</span></a>
            <ul class="dropdown-menu">
                @can('superadmin')
        <li class={{ Request::is('data/users')? 'active' : '' }}><a class="nav-link" href="{{route('users')}}"><i class="fa fa-database"></i> <span>User</span></a></li>
        @endcan
        @canany(['superadmin','admin'])
        <li class={{ Request::is('data/suspects')? 'active' : '' }}><a class="nav-link" href="{{route('suspects.all')}}"><i class="fa fa-database"></i> <span>Suspect</span></a></li>
                    @endcanany
            </ul>
          @endcanany
      </ul>
    </aside>
  </div>
