@extends('club.components.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-xl-5">

            <h3 class="mb-4 text-center">ADD OPTION</h3>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="" method="POST" class="card shadow-sm border-0">
                @csrf

                <div class="card-body">

                    <!-- Option Name -->
                    <div class="mb-3">
                        <label class="form-label">Option Name</label>
                        <input 
                            type="text" 
                            name="option_name" 
                            class="form-control" 
                            value="{{ old('option_name') }}" 
                            placeholder="Enter option name"
                            required
                        >
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="">Select status</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                </div>

                <div class="card-footer bg-white d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary px-4">
                        Submit
                    </button>

                    <a href="" class="btn btn-outline-secondary">
                        View Options
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
