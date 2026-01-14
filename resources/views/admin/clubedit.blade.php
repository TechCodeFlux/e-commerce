@extends('admin.components.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Edit Club</h3>

    @if(session('success'))
        <div class="alert alert-success text-center">
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

    <div class="row">
        <div class="col-md-6 col-lg-5">

            <form action="{{ route('admin.club.update', $club->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Club Name</label>
                    <input
                        type="text"
                        name="club_name"
                        class="form-control"
                        value="{{ old('club_name', $club->name) }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Club Address</label>
                    <textarea
                        name="club_address"
                        class="form-control"
                        rows="3"
                        required
                    >{{ old('club_address', $club->address) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Club Contact</label>
                    <input
                        type="text"
                        name="club_contact"
                        class="form-control"
                        value="{{ old('club_contact', $club->contact) }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $club->email) }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Country</label>
                    <input
                        type="text"
                        name="country_id"
                        class="form-control"
                        value="{{ old('country_id', $club->country_id) }}"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">State</label>
                    <input
                        type="text"
                        name="state_id"
                        class="form-control"
                        value="{{ old('state_id', $club->state_id) }}"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">City</label>
                    <input
                        type="text"
                        name="city"
                        class="form-control"
                        value="{{ old('city', $club->city) }}"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">ZIP Code</label>
                    <input
                        type="text"
                        name="zip_code"
                        class="form-control"
                        value="{{ old('zip_code', $club->zip_code) }}"
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="status"
                            id="statusSwitch"
                            {{ old('status', $club->status) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="statusSwitch" id="statusLabel">
                            {{ $club->status ? 'Active' : 'Inactive' }}
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                    <a href="{{ route('admin.club.index') }}" class="btn btn-warning">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
    document.getElementById('statusSwitch').addEventListener('change', function () {
        document.getElementById('statusLabel').innerText =
            this.checked ? 'Active' : 'Inactive';
    });
</script>
@endsection
