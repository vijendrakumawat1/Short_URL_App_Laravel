@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                @if ($urls->count())
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold"> Short URLs</h3>
                        @can('create', App\Models\ShortUrl::class)
                            <a href="{{ route('shorturls.create') }}" class="btn btn-primary">New Short URL</a>
                        @endcan

                    </div>

                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Short URL</th>
                                <th>Original URL</th>
                                <th>Created By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($urls as $url)
                                <tr>
                                    <td><a href="{{ $url->long_url }}">{{ $url->short_url }}</a></td>
                                    <td>{{ $url->long_url }}</td>
                                    <td>{{ $url->user->name ?? 'Unknown' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">No short URLs found..</div>
                @endif
            </div>
        </div>

    </div>
@endsection
