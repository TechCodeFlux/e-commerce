@extends('admin.components.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Club Entry</h3>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="row justify-content">
        <div class="col-md-6 col-lg-5">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.club.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Club Name</label>
                    <input type="text" name="club_name" class="form-control" placeholder="name">
                </div>

                <div class="mb-3"> 
                    <label class="form-label">Club Address</label>
                    <textarea name="club_address" class="form-control" rows="3" placeholder="address"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Club Contact</label>
                    <input type="text" name="club_contact" class="form-control" placeholder="contact">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Country</label>
                    <input type="text" name="country_id" class="form-control" placeholder="country code">
                </div>

                <div class="mb-3">
                    <label class="form-label">State</label>
                    <input type="text" name="state_id" class="form-control" placeholder="state">
                </div>

                <div class="mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" placeholder="city name">
                </div>

                <div class="mb-3">
                    <label class="form-label">ZIP Code</label>
                    <input type="text" name="zip_code" class="form-control" placeholder="zip code">
                </div>

                <div class="mb-4">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="status"
                            id="statusSwitch"
                            checked
                        >
                        <label class="form-check-label" for="statusSwitch" id="statusLabel">
                            Active
                        </label>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
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
