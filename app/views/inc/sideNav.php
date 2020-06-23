<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php echo ($_SESSION['current_page'] == 'Dashboard') ?'active': ''; ?> ">
        <a class="nav-link" href="<?php echo URLROOT; ?>/DashboardController/dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <li class="nav-item <?php echo ($_SESSION['current_page'] == 'TaskHistory') ?'active': ''; ?>">
        <a class="nav-link" href="<?php echo URLROOT; ?>/TaskHistoryController/taskHistory"> 
          <i class="fas fa-fw fa-table"></i>
          <span>Task History</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-folder"></i>
          <span>Projects</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-calendar-alt"></i>
          <span>Calendar</span></a>
      </li>

      <!-- Divider -->
      

      <?php if($_SESSION["buisness_user_account_type"] == true): ?>
        <hr class="sidebar-divider">
        
        <li class="nav-item">
          <a class="nav-link" href="index.html">
            <i class="fas fa-user-friends"></i>
            <span>Groups</span>
          </a>
        </li>

      <?php endif;?>
      

      <!-- Divider -->
      <hr class="sidebar-divider">

      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-user-circle"></i>
          <span>Account</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->