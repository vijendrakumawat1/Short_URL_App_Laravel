@extends('layouts.app')

@section('content')
    <h1>Short Urls</h1>

    <form method="POST" action="{{ route('shorturls.store') }}">
        @csrf
        <div>
            <label>long url</label>
            <input type="text" name="long_url" id="long_url" required>
        </div>
        <button type="submit">Submit</button>
    </form>
@endsection
