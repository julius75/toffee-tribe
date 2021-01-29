

<!-- Sidebar -->
<ul class="navbar-nav toggled sidebar sidebar-dark accordion" style="background-color: #1a9082" id="accordionSidebar" >

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('member.index')}}">
        <div class="sidebar-brand-text mx-3"></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">



    <!-- Nav Item - Dashboard -->
    @if(Auth::user()->hasRole('admin'))
    <li class="nav-item active">
        <a class="nav-link" href="{{route('admin.home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Admin Panel</span></a>
    </li>
        <hr class="sidebar-divider">
    @endif

    <li class="nav-item active">
        <a class="nav-link" href="{{route('member.index')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        ACTIONS
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('member.locations')}}">
            <i class="fas fa-search-location"></i>
            <span>Locations</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('member.account')}}">
            <i class="fas fa-money-check"></i>
            <span>Purchase</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('member.events')}}">
            <i class="fas fa-tasks"></i>
            <span>Events</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('member.visits',['username'=>$user->username])}}">
            <i class="far fa-map"></i>
            <span>Visits</span></a>
    </li>
    <li class="nav-item">
            <a class="nav-link" href="{{route('member.profile',['username'=>$user->username])}}">
                <i class="far fa-user"></i>
                <span>Profile</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
