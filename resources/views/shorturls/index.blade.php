@extends('layouts.app')

@section('content')
    <h1>Short URLs</h1>

    @can('create', App\Models\ShortUrl::class)
        <a href="{{ route('shorturls.create') }}" class="btn btn-primary">New Short URL</a>
    @endcan

    <table class="table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Original URL</th>
                <th>Created By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($urls as $url)
                <tr>
                    <td>{{ $url->short_code }}</td>
                    <td>{{ $url->long_url }}</td>
                    <td>{{ $url->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
