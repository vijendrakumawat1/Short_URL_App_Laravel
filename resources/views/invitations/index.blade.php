@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Invitations</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($invitations->count())
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Company ID</th>
                            <th>User ID</th>
                            <th>Sent At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invitations as $invite)
                            <tr>
                                <td>{{ $invite->email }}</td>
                                <td>{{ $invite->role }}</td>
                                <td>{{ $invite->company_id }}</td>
                                <td>{{ $invite->user_id }}</td>
                                <td>{{ $invite->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">No invitations found.</div>
            @endif
        </div>
    </div>
</div>
@endsection
