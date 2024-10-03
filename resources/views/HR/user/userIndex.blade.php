@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
        <h1 class="text-2xl font-bold mb-2 md:mb-0">User List</h1>
        <div class="flex-shrink-0">
            <a href="{{ route('users.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Add User
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4 relative" id="success-alert">
            {{ session('success') }}
            <button type="button" class="absolute top-0 right-0 p-2 text-white" onclick="document.getElementById('success-alert').remove();">
                &times;
            </button>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border-b">No Karyawan</th>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Role</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Division</th>
                    <th class="py-2 px-4 border-b">Jabatan</th>
                    <th class="py-2 px-4 border-b">Tanggal Join</th>
                    <th class="py-2 px-4 border-b">KTP</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ $user->no_karyawan }}</td>
                        <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                        <td class="py-2 px-4 border-b">{{ $user->role->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $user->status }}</td>
                        <td class="py-2 px-4 border-b">
                            @foreach($user->divisions as $division)
                                <span class="inline-block bg-gray-300 text-gray-800 text-sm px-2 py-1 rounded">{{ $division->name }}</span>
                            @endforeach
                        </td>
                        <td class="py-2 px-4 border-b">{{ $user->position->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $user->tanggal_join }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($user->upload_ktp)
                                <a href="{{ asset('storage/' . $user->upload_ktp) }}" target="_blank" class="text-blue-500 hover:underline">Lihat Dokumen</a>
                            @else
                                Tidak ada dokumen
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b">
                            <div class="flex items-center">
                                <a href="{{ route('user.edit', $user->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded mr-2">Edit</a>
                                <form action="{{ route('users.delete', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for KTP Preview -->
<div id="ktpModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-xl font-bold mb-4" id="ktpModalTitle">KTP</h2>
            <img id="ktpModalImage" src="" alt="KTP" class="max-w-full h-auto">
            <div class="text-right mt-4">
                <button onclick="closeKtpModal()" class="bg-red-500 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showKtpModal(imageSrc, userName) {
        document.getElementById('ktpModalImage').src = imageSrc;
        document.getElementById('ktpModalTitle').textContent = 'KTP ' + userName;
        document.getElementById('ktpModal').classList.remove('hidden');
    }

    function closeKtpModal() {
        document.getElementById('ktpModal').classList.add('hidden');
    }
</script>
@endsection
