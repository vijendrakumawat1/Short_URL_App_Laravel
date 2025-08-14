!<x-app-layout>
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
                                <h3 class="text-lg font-bold"> (All Companies)</h3>
                                <a href="{{ route('invite.index') }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">invite</a>
                            </div>
                            <table class="min-w-full mb-2 border">
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">Name</th>
                                        <th class="border px-4 py-2">Email</th>
                                        <th class="border px-4 py-2">Created date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($companies as $companie)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $companie->name }}</td>
                                            <td class="border px-4 py-2">{{ $companie->email }}</td>
                                            <td class="border px-4 py-2">{{ $companie->created_at }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                           
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
