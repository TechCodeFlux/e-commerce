@extends('admin.components.app')
@section('page-title', $club->name)

@section('head')
@endsection

@section('content')
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clubsindex') }}">
                        <i class="bi bi-people-fill small me-2"></i> Clubs
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-building small me-2"></i>{{$club->name}}</li>
            </ol>
        </nav>
    </div>

<div class="content ">
    <div class="row flex-md-row">
        
        @include('admin.club.side_bar')

        <div class="col-md-9">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Over view</h6>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <div class="card border-0">
                                                <a href="">

                                                    <div class="card-body text-center">
                                                        <div class="display-5">
                                                            <i class="bi bi-globe text-info"></i>
                                                        </div>
                                                        <h5 class="my-3">Micro Sites</h5>
                                                        <div class="text-muted"> Microsites</div>
                                                        
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border-0">
                                                <a href="">
                                                <div class="card-body text-center">
                                                    <div class="display-5">
                                                        <i class="bi bi-receipt text-warning"></i>
                                                    </div>
                                                    <h5 class="my-3">Orders</h5>
                                                    <div class="text-muted">Orders</div>
                                                   
                                                </div>
                                                </a>
                                            </div>
                                                 
                                        
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
