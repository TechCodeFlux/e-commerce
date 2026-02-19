<div class="col-md-3">
    <div class="card sticky-top mb-4 mb-md-0">
        <div class="card-body">
            <ul class="nav nav-pills flex-column gap-2" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ request()->routeIs('admin.clubs.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.clubs.dashboard', $club->id) }}">
                        <i class="bi bi-graph-up me-2"></i> Dashboard
                    </a>

                </li>
                
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ request()->routeIs('admin.clubmember.viewmembers') ? 'active' : '' }}" id="profile-tab" href="{{ route('admin.clubmember.viewmembers',$club->id) }}" role="tab" aria-controls="profile" aria-selected="true">
                        <i class="bi-people me-2"></i> Club Members
                    </a>
                </li>

                
               <li class="nav-item">
                    <a class="nav-link">
                        <i class="bi bi-receipt me-2"></i> Orders
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.show_microsites','admin.add_microsites') ? 'active' : '' }}" href="{{ route('admin.show_microsites', $club->id) }}">
                        <i class="bi bi-globe me-2"></i> Microsites
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.club.profile') ? 'active' : '' }}" id="profile-tab" href="{{ route('admin.club.profile',$club->id) }}" role="tab" aria-controls="profile" aria-selected="true">

                        <i class="bi bi-person me-2"></i> Profile
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.clubsindex') }}">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>

               
            </ul>
        </div>
    </div>
</div>