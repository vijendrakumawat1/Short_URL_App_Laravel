@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Send Invitation</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('invite.store') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label for="role" class="form-label fw-bold">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="Admin">Admin</option>
                        <option value="Member">Member</option>
                    </select>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary">Send Invitation</button>
            </form>
        </div>
    </div>
</div>
@endsection
