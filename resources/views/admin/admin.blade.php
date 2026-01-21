@extends('admin.components.app')
@section('content')

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">

            

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.addadmin.store') }}" method="POST" class="card shadow-sm border-0">
                @csrf

                <div class="card-body">
                    <h3 class="mb-4 text-center">ADD NEW ADMIN</h3>
                    <!-- Name + Email -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name"
                                   value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Enter full name">

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                   value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Enter email">

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- DOB + Contact -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob"
                                   value="{{ old('dob') }}"
                                   class="form-control @error('dob') is-invalid @enderror">

                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="tel" name="contact"
                                   value="{{ old('contact') }}"
                                   class="form-control @error('contact') is-invalid @enderror"
                                   placeholder="Enter contact number">

                            @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="mb-3">
                        <label class="form-label d-block">Gender</label>

                        @foreach(['Male', 'Female', 'Other'] as $gender)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="gender"
                                       value="{{ $gender }}"
                                       {{ old('gender') === $gender ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $gender }}</label>
                            </div>
                        @endforeach

                        @error('gender')
                            <div class="text-danger small d-block mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address"
                                  rows="3"
                                  class="form-control @error('address') is-invalid @enderror"
                                  placeholder="Enter address">{{ old('address') }}</textarea>

                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer bg-white d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary px-4">
                        Submit
                    </button>

                    <a href="{{ route('admin.addadmin.create') }}" class="btn btn-outline-secondary">
                        View Admins
                    </a>
                </div>
            </form>

        </div>
    </div>

</div>

@endsection
