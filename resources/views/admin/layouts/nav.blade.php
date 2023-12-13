 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item dropdown">
        <button class="nav-link btn" data-toggle="dropdown" aria-expanded="false"
         style="font-weight: bold">
          {{ Str::ucfirst(auth()->guard('admin')->user()->name) }}
          <i class="fas fa-angle-down"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right style" style="left: inherit; right: 0px;">
          <style>
            .dropdown-menu-lg{
              max-width: 200px !important;
              min-width: 180px !important;
            }
          </style>
          <div class="dropdown-divider"></div>
          <a href="{{route('admin.profile.edit')}}" class="dropdown-item">
            <i class="fas fa-user mr-2"></i>Profile
          </a>
          <div class="dropdown-divider"></div>
            <form action="{{ route('admin.logout')}}" method="post">
              @csrf
              <button type="submit" class="btn dropdown-item">
                <i class="fa fa-sign-out-alt mr-2"></i>Logout
              </button>
            </form>
          <div class="dropdown-divider"></div>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">{{ Str::ucfirst(auth()->guard('admin')->user()->name) }}</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="{{ route('admin.dashboard')}}" class="nav-link {{ request()->is('*/dashboard*') ? 'active' : ' '}}">
              <i class="nav-icon fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>
        

          <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->is('*/categories*') ? 'active' : ' '}}">
              <i class="nav-icon fas fa-th"></i>
              <p>Category</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->is('*/products*') ? 'active' : ' '}}">
              <i class="nav-icon fas fa-th"></i>
              <p>Product</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->is('*/banners*') ? 'active' : ' '}}">
              <i class="nav-icon fas fa-th"></i>
              <p>Banner</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.ads.index') }}" class="nav-link {{ request()->is('*/ads*') ? 'active' : ' '}}">
              <i class="nav-icon fas fa-th"></i>
              <p>ADS</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

