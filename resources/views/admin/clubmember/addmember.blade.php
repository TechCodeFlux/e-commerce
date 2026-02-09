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
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clubs.dashboard', $club->id) }}">
                        <i class="bi bi-people-fill small me-2"></i>{{$club->name}}
                    </a>
                </li>
                    <li class="breadcrumb-item">
                    <a href="{{ route('admin.clubmember.viewmembers', $club->id) }}">
                        <i class="bi bi-people-fill small me-2"></i>club members
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-building small me-2"></i>add member/edit</li>  
            </ol>
        </nav>
    </div>

<div class="content ">
    <div class="row flex-md-row">
        
        @include('admin.club.side_bar')
    

       <div class="col-md-9">
        <div class="card shadow-sm">
                <div class="card-body">

                <h4 class="text-center mb-4">
                        {{ $clubmember->id ? 'Edit' : 'Add' }} Club member
                    </h4>

                    <form
                        action="{{ $clubmember->id ? route('admin.clubmember.update', $clubmember->id) : route('admin.clubmember.storemember',$club->id) }}"
                        {{-- route('admin.storemember') --}}
                        method="POST">
                        @csrf
                        @if($clubmember->id) @method('PUT') @endif

                        <div class="row">

                            {{-- Name --}}
                            <div class="col-md-4 mb-3">
                                <label>Name</label>
                                <input type="text" name="name"               
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $clubmember->name ?? '') }}">

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- Email --}}
                            <div class="col-md-4 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" 
                            class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $clubmember->email ?? '') }}">

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Contact --}}
                            <div class="col-md-4 mb-3">
                                <label>Contact</label>
                                <input type="text" name="contact" 
                                class="form-control @error('contact') is-invalid @enderror"
                                value="{{ old('contact', $clubmember->contact ?? '') }}">

                                @error('contact')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div class="col-md-12 mb-3">
                                <label>Address</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                value="{{ old('address', $clubmember->address ?? '') }}"></textarea>

                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                           
                            {{-- State --}}
                            <div class="col-md-4 mb-3">
                                <label>State</label>
                                {{-- <select name="state" id="state" class="form-select">
                                    <option value="{{old('state')}}">Select State</option>
                                </select> --}}
                                <input type="text" name="state" class="form-control @error('state') is-invalid @enderror"
                                    value="{{ old('state', $clubmember->state?? '') }}">

                            </div>

                            {{-- City --}}
                            <div class="col-md-4 mb-3">
                                <label>City</label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                    value="{{ old('city', $clubmember->city ?? '') }}">
                                    @error('city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- City --}}
                            <div class="col-md-4 mb-3">
                                <label>Zip code</label>
                                <input type="text" name="zip_code" class="form-control @error('zip_code') is-invalid @enderror"
                                    value="{{ old('zip_code', $clubmember->zip_code ?? '') }}">
                                    @error('zip_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                           

                        <div class="text-center mt-3">
                            <button class="btn btn-primary px-5">
                                {{ $clubmember->id ? 'Update' : 'Submit' }}
                            </button>
                        </div>

                    </form>
                </div>      
            </div>
        </div>
    
       </div>
</div>
@endsection