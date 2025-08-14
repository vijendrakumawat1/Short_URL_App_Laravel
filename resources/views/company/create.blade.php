@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Create Company</h1>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('company.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required placeholder="Enter company name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required placeholder="Enter company email">
                    </div>
                    <button type="submit" class="btn btn-primary">Generate company</button>
                </form>
            </div>
        </div>
    </div>
@endsection
