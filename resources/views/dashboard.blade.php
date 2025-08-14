<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @php $user = auth()->user(); @endphp
                        @if ($user->role === 'SuperAdmin')
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold">All Short URLs (All Companies)</h3>
                                <a href="{{ route('company.create') }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">New Company</a>
                            </div>
                            <table class="min-w-full mb-2 border">
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">Short URL</th>
                                        <th class="border px-4 py-2">Original URL</th>
                                        <th class="border px-4 py-2">Company</th>
                                        <th class="border px-4 py-2">Created By</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (App\Models\ShortUrl::all() as $url)
                                        <tr>
                                            <td class="border px-4 py-2"><a href="{{ $url->long_url }}">{{ $url->short_url }}</a></td>
                                            <td class="border px-4 py-2">{{ $url->long_url }}</td>
                                            <td class="border px-4 py-2">{{ $url->company->name }}</td>
                                            <td class="border px-4 py-2">{{ $url->user->name ?? 'Unknown' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @elseif($user->role === 'Admin')
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold">All Short URLs (Company)</h3>
                                <a href="{{ route('shorturls.create') }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Generate URL</a>
                            </div>
                            <table class="min-w-full mb-2 border">
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">Short URL</th>
                                        <th class="border px-4 py-2">Original URL</th>
                                        <th class="border px-4 py-2">Created By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (App\Models\ShortUrl::where('company_id', $user->company_id)->get() as $url)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $url->short_url }}</td>
                                            <td class="border px-4 py-2">{{ $url->long_url }}</td>
                                            <td class="border px-4 py-2">{{ $url->user->name ?? 'Unknown' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @elseif($user->role === 'Member')
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold">My Short URLs</h3>
                                <a href="{{ route('shorturls.create') }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Generate URL</a>
                            </div>
                            <table class="min-w-full mb-2 border">
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">Short URL</th>
                                        <th class="border px-4 py-2">Original URL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (App\Models\ShortUrl::where('user_id', $user->id)->get() as $url)
                                        <tr>
                                            <td class="border px-4 py-2"><a
                                                    href={{ $url->long_url }}>{{ $url->short_url }}</a></td>
                                            <td class="border px-4 py-2">{{ $url->long_url }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        @if ($user->role === 'Admin')
                            <div class="mb-8">
                                <a href="{{ url('/short-urls') }}"
                                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">View All</a>
                            </div>

                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold">Member List</h3>
                                <a href="{{ url('/invite/create') }}"
                                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Invite Member</a>
                            </div>
                            <table class="min-w-full mb-2 border">
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">Name</th>
                                        <th class="border px-4 py-2">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (App\Models\User::where('company_id', $user->company_id)->where('role', 'Member')->get() as $member)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $member->name }}</td>
                                            <td class="border px-4 py-2">{{ $member->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                <a href="{{ url('/invite') }}"
                                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">View All</a>
                            </div>
                        @else

 <div>
                                <a href="{{ route('company.index') }}"
                                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">View All</a>
                            </div>                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
