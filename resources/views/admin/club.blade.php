
@extends('admin.components.app')
@section('content')

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">

            <h3 class="mb-4 text-center">ADD CLUB</h3>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.club.store') }}" method="GET" class="card shadow-sm border-0">
                @csrf

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Club Name</label>
                        <input type="text" name="club_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Club Address</label>
                        <textarea name="club_address" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Club Contact</label>
                        <input type="text" name="club_contact" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country_id" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">State</label>
                            <input type="text" name="state_id" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ZIP Code</label>
                            <input type="text" name="zip_code" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-white d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary px-4">
                        Submit
                    </button>

                    <a href="{{ route('admin.club.store') }}" class="btn btn-outline-secondary">
                        View Clubs
                    </a>
                </div>
            </form>

        </div>
    </div>

</div>

@endsection