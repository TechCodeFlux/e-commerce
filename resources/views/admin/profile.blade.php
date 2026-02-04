
@extends('admin.components.app')
@section('content') 
    <!-- content -->
    <div class="content ">
        
    <div class="row flex-column-reverse flex-md-row">
        <div class="col-md-12">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="mb-4">
                        <div class="d-flex flex-column flex-md-row text-center text-md-start mb-3">
                            <figure class="me-4 flex-shrink-0">
                                <img width="100" class="rounded-pill"
                                     src="../../assets/images/user/man_avatar3.jpg" alt="...">
                            </figure>
                            <div class="flex-fill">
                                <h3 class="mb-6">{{$user->name}}</h3>
                                {{-- <button class="btn btn-primary me-2">Change Avatar</button>
                                <button class="btn btn-outline-danger btn-icon" data-bs-toggle="tooltip" title="Remove Avatar">
                                    <i class="bi bi-trash me-0"></i>
                                </button> --}}
                                {{-- <p class="small text-muted mt-3">For best results, use an image at least
                                    256px by 256px in either .jpg or .png format</p> --}}
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h6 class="card-title mb-4">Basic Information</h6>
                                <form method="POST" action="{{ route('admin.profile_update') }}">
                                @csrf
                                <div class="row">
                                    {{-- <div class="col-md-6"> --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" value="adek-kembar">
                                        </div> --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label class="form-label">Date of Birth</label>
                                            <div class="d-flex gap-3">
                                                <select class="form-select">
                                                    <option>Day</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                    <option>6</option>
                                                    <option>7</option>
                                                    <option>8</option>
                                                    <option>9</option>
                                                    <option>10</option>
                                                    <option>11</option>
                                                    <option>12</option>
                                                    <option>13</option>
                                                    <option>14</option>
                                                    <option>15</option>
                                                    <option>16</option>
                                                    <option>17</option>
                                                    <option>18</option>
                                                    <option>19</option>
                                                    <option selected="">20</option>
                                                    <option>21</option>
                                                    <option>22</option>
                                                    <option>23</option>
                                                    <option>24</option>
                                                    <option>25</option>
                                                    <option>26</option>
                                                    <option>27</option>
                                                    <option>28</option>
                                                    <option>29</option>
                                                    <option>30</option>
                                                </select>
                                                <select class="form-select">
                                                    <option>Month</option>
                                                    <option selected="">Jan</option>
                                                    <option>Feb</option>
                                                    <option>Mar</option>
                                                    <option>Apr</option>
                                                    <option>May</option>
                                                    <option>Jun</option>
                                                    <option>Jul</option>
                                                    <option>Aug</option>
                                                    <option>Sep</option>
                                                    <option>Oct</option>
                                                    <option>Nov</option>
                                                    <option>Dec</option>
                                                </select>
                                                <select class="form-select">
                                                    <option>Year</option>
                                                    <option>2018</option>
                                                    <option>2017</option>
                                                    <option>2016</option>
                                                    <option>2015</option>
                                                    <option>2014</option>
                                                    <option>2013</option>
                                                    <option>2012</option>
                                                    <option>2011</option>
                                                    <option>2010</option>
                                                    <option>2009</option>
                                                    <option>2008</option>
                                                    <option>2007</option>
                                                    <option>2006</option>
                                                    <option>2005</option>
                                                    <option>2004</option>
                                                    <option>2003</option>
                                                    <option>2002</option>
                                                    <option>2001</option>
                                                    <option>2000</option>
                                                    <option>1999</option>
                                                    <option>1998</option>
                                                    <option>1997</option>
                                                    <option>1996</option>
                                                    <option>1995</option>
                                                    <option>1994</option>
                                                    <option>1993</option>
                                                    <option>1992</option>
                                                    <option>1991</option>
                                                    <option>1990</option>
                                                    <option selected="">1989</option>
                                                    <option>1988</option>
                                                    <option>1987</option>
                                                    <option>1986</option>
                                                    <option>1985</option>
                                                    <option>1984</option>
                                                    <option>1983</option>
                                                    <option>1982</option>
                                                    <option>1981</option>
                                                    <option>1980</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        {{-- <div class="mb-3">
                                            <label class="form-label">Gender</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="inlineRadio1" name="inlineRadio"
                                                           class="form-check-input">
                                                    <label class="form-check-label" for="inlineRadio1">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="inlineRadio2" name="inlineRadio"
                                                           class="form-check-input">
                                                    <label class="form-check-label"
                                                           for="inlineRadio2">Female</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="inlineRadio3" name="inlineRadio"
                                                           class="form-check-input">
                                                    <label class="form-check-label" for="inlineRadio3">Other</label>
                                                </div>
                                            </div>
                                        </div> --}}
                                    {{-- </div> --}}
                                    {{-- <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Role</label>
                                            <select class="form-select">
                                                <option value="">All</option>
                                                <option value="" selected>Admin</option>
                                                <option value="">User</option>
                                                <option value="">Staff</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select">
                                                <option value="">All</option>
                                                <option value="" selected>Active</option>
                                                <option value="">Blocked</option>
                                            </select>
                                        </div>
                                        
                                    </div> --}}
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- error display --}}

                    <div class="mb-4">
                    @if ($errors->any())
                     <div class="alert alert-danger">
                     <ul>
                     @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                     @endforeach
                     </ul>
                     </div>
                     @endif
                    </div>
                   {{-- error display end --}}

                  
                
                {{-- <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-4">Change Password</h6>
                            <div class="mb-3">
                                <label class="form-label">Old Password</label>
                                <input type="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password Repeat</label>
                                <input type="password" class="form-control">
                            </div>
                        </div>
                    </div>
                </div> --}}
                
                
            </div>
        </div>
        {{-- <div class="col-md-4">
            <div class="card sticky-top mb-4 mb-md-0">
                <div class="card-body">
                    <ul class="nav nav-pills flex-column gap-2" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                               aria-controls="profile" aria-selected="true">
                                <i class="bi bi-person me-2"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab"
                               aria-controls="password" aria-selected="false">
                                <i class="bi bi-lock me-2"></i> Password
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div> --}}
    </div>

    </div>
    <!-- ./ content -->
    @endsection