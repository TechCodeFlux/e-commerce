@extends('admin.components.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Registered Clubs</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Country Id</th>
                    <th>State Id</th>
                    <th>City</th>
                    <th>Zip Code</th>
                    {{-- <th>Status</th> --}}

                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($clubs as $club)
                    <tr>
                        <td>{{ $club->id }}</td>
                        <td>{{ $club->name }}</td>
                        <td>{{ $club->email }}</td>
                        <td>{{ $club->contact }}</td>
                        <td>{{ $club->address }}</td>
                        <td>{{ $club->country_id }}</td>
                        <td>{{ $club->state_id }}</td>
                        <td>{{ $club->city }}</td>
                        <td>{{ $club->zip_code }}</td>
                        {{-- <td>{{ $club->status }}</td> --}}

                        <td class="text-center">
                            {{-- Edit --}}
                            <a href="{{ route('admin.club.edit', $club->id) }}"
                            class="btn btn-sm btn-primary me-1">
                                Edit
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.club.destroy', $club->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this club?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No clubs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin.club') }}" class="btn btn-success mt-3">
        Add New Club
    </a>

</div>
@endsection
