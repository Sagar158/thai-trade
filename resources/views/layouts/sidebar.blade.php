<nav class="sidebar">
    <div class="sidebar-header">
      <a href="{{ route('dashboard') }}" class="sidebar-brand">
        GScan
      </a>
      <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="sidebar-body">
      <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('products.index') }}" class="nav-link">
              <i class="link-icon" data-feather="airplay"></i>
              <span class="link-title">Product Center</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('repackProducts') }}" class="nav-link">
              <i class="link-icon" data-feather="archive"></i>
              <span class="link-title">Processed Data</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('bkwc2t') }}" class="nav-link">
              <i class="link-icon" data-feather="book"></i>
              <span class="link-title">BKKW Data</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('CKW_C2T') }}" class="nav-link">
              <i class="link-icon" data-feather="bookmark"></i>
              <span class="link-title">BKKO Data</span>
            </a>
        </li>
        <li class="nav-item nav-category">System Settings</li>

        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
              <i class="link-icon" data-feather="users"></i>
              <span class="link-title">Users</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('customers.index') }}" class="nav-link">
              <i class="link-icon" data-feather="user-plus"></i>
              <span class="link-title">Customers</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('logStatus.index') }}" class="nav-link">
              <i class="link-icon" data-feather="clock"></i>
              <span class="link-title">Log Status</span>
            </a>
        </li>
    </ul>
    </div>
</nav>
