 <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.index') }}" class="brand-link text-center">
      <span class="brand-text"><strong>Gdzie kupisz</strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <i class="fa fa-user fa-2x text-muted"></i>
        </div>
        <div class="info">
          <a href="{{ route('admin.profile') }}" class="d-block">{{ auth()->user()->user_display_name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item" data-tab-name="dashboard">
            <a href="{{ route('admin.index') }}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Pulpit
              </p>
            </a>
          </li>   
          <li class="nav-item" data-tab-name="pos">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-map-marker"></i>
              <p>
               POS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.pos.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lista POS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.pos.edit') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dodaj POS</p>
                </a>
              </li>
              <hr /> 
              <li class="nav-item">
                <a href="{{ route('admin.pos.categories') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lista kategorii</p>
                </a>
              </li>
            </ul>
          </li>                          
          <li class="nav-header">TREŚĆ</li> 
          <li class="nav-item" data-tab-name="blog">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-pen"></i>
              <p>
               Blog
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.blog.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lista wpisów</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.blog.edit') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dodaj wpis</p>
                </a>
              </li>
              <hr /> 
              <li class="nav-item">
                <a href="{{ route('admin.blog.categories') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lista kategorii</p>
                </a>
              </li>
            </ul>
          </li>          
          <li class="nav-item" data-tab-name="filesmanager">
            <a href="{{ route('admin.filesmanager.index') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
               Menadżer plików
              </p>
            </a>
          </li>
         </ul>                                                   
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>