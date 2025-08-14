@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Send Invitation</h1>
        <a href="{{ route('invite.index') }}" class="btn btn-secondary">Back to Invitations</a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('invite.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="Name" class="form-label fw-bold">Name</label>
                    <input type="text" name="name" id="Name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label fw-bold">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="Admin">Admin</option>
                        <option value="Member">Member</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Send Invitation</button>
            </form>
        </div>
    </div>
</div>
