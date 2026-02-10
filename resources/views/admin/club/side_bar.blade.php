<div class="col-md-3 ">
    <div class="card sticky-top mb-4 mb-md-0">
        <div class="card-body">
            <ul class="nav nav-pills flex-column gap-2" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" href="{{ route('admin.clubs.dashboard', $club->id) }}" role="tab" aria-controls="profile" aria-selected="true">
                        <i class="bi-graph-up me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" href="{{ route('admin.clubmember.viewmembers',$club->id) }}" role="tab" aria-controls="profile" aria-selected="true">
                        <i class="bi-people me-2"></i> Club Members
                    </a>
                </li>
               
            </ul>
        </div>
    </div>
</div>