@extends('club.components.app')

@section('content')
<div class="container mt-4">

    <div class="card mb-4 shadow-sm">
        <div class="card-body">

            <h6 class="card-title mb-4 text-center">
                {{ $clubmember->id ? 'Edit' : 'Add' }} Club Member
            </h6>

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <form 
                        action="{{ $clubmember->id 
                            ? route('club.members.update', $clubmember->id) 
                            : route('club.members.store') }}" 
                        method="POST" 
                        autocomplete="off">
                        @csrf
                        @if($clubmember->id)
                            @method('PUT')
                        @endif
                       
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" 
                                    value="{{ old('name', $clubmember->name ?? '') }}">
                                @error('name')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Contact"
                                    value="{{ old('phone', $clubmember->phone ?? '') }}">
                                @error('phone')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    value="{{ old('email', $clubmember->email ?? '') }}">
                                @error('email')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                         

                    

                            

                            
                        

                         

                            <div class="col-md-4 mb-4">
                                <label class="form-label d-block">Status</label>

                                <input type="hidden" name="status" value="0">

                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="status"
                                        id="statusSwitch"
                                        value="1"
                                        {{ old('status', $clubmember->status ?? 1) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="statusSwitch" id="statusLabel">
                                        {{ old('status', $clubmember->status ?? 1) ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5">
                                {{ $clubmember->id ? 'Update' : 'Submit' }}
                            </button> 
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusSwitch = document.getElementById('statusSwitch');
    const statusLabel = document.getElementById('statusLabel');

    if (statusSwitch) {
        statusSwitch.addEventListener('change', function () {
            statusLabel.innerText = this.checked ? 'Active' : 'Inactive';
        });
    }
});
</script>
@endsection
