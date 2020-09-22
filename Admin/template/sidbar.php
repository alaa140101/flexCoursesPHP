<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary ">
    <!-- Brand Logo -->
    <a href="<?php echo $config['app_url'] ?>" class="brand-link text-center">
      <span class="brand-text font-weight-light"><?php echo $config['app_name'] ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">    

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo $config['app_url'].'admin/' ?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo $config['app_url'].'admin/users' ?>" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>           
          </li> 
          <li class="nav-item">
            <a href="<?php echo $config['app_url'].'admin/services'?>" class="nav-link">
              <i class="nav-icon fas fa-magic"></i>
              <p>
                Services
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>            
          </li>          
          <li class="nav-item">
            <a href="<?php echo $config['app_url'].'admin/products' ?>" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Products
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>            
          </li>                   
          <li class="nav-item">
            <a href="<?php echo $config['app_url'].'admin/settings';?>" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>           
          </li>          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>