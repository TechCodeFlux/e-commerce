<div class="menu">
    <div class="menu-header">
        <a href="{{ route('club.dashboard') }}" class="menu-header-logo" style="display:flex; align-items:center; gap:0.1px;">
            <img src="{{ url('assets/images/grabit/logo1.png') }}" alt="logo" style="width:80px; height:auto;">
            <span style="font-size:25px; font-family:'Calibri', sans-serif; color:black; font-weight:530; font-style:italic; letter-spacing:2px;">
                <b>GRABiT</b>
            </span>
        </a>
        <a href="javascript:void(0)" class="btn btn-sm menu-close-btn d-md-none">
            <i class="bi bi-x"></i>
        </a>
    </div>
    
    <div class="menu-body">
        <div class="pb-4 mb-4 border-bottom text-center">
            @php
    $club = auth('club')->user();
@endphp

 <img id="avatarPreview"
                 src="{{ $club->image 
                        ? asset('storage/'.$club->image) 
                        : asset('assets/images/user/man_avatar3.jpg') }}"
                 width="130"
                 height="130"
                 class="rounded-circle border shadow"
                 style="object-fit:cover;">
            <h6 class="mb-0">{{ auth('club')->user()->name ?? 'Admin' }}</h6>
            <small class="text-muted">{{ auth('club')->user()->email ?? '' }}</small>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
    <a href="{{ route('club.dashboard') }}" class="nav-link {{ request()->routeIs('club.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid me-3"></i> Dashboard
    </a>
</li>
            <li class="nav-item">
               <a href="{{ route('club.member.index') }}" 
   class="nav-link {{ request()->routeIs('club.member.*') ? 'active' : '' }}">
    <i class="bi bi-people me-3"></i> Club Members
</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-cart me-3"></i> Orders
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-globe me-3"></i> Microsites
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-person me-3"></i> Profile
                </a>
            </li>
            <li class="nav-item mt-3">
                <a href="#" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-right me-3"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>