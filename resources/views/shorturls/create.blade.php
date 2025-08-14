@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Create Short URL</h1>
            <a href="{{ route('shorturls.index') }}" class="btn btn-secondary">Back to Short URLs</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('shorturls.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="long_url" class="form-label fw-bold">Original URL</label>
                        <input type="url" name="long_url" id="long_url" class="form-control" required placeholder="https://example.com">
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Short URL</button>
                </form>
            </div>
        </div>
    </div>
@endsection
