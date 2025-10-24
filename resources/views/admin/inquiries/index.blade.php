@extends('layouts.admin')

@section('title', 'Daftar Permintaan - Admin ARDFYA')

@section('header', 'Daftar Permintaan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        @if(isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ $error }}
        </div>
        @endif
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold" style="color: #1A3C34;">Daftar Permintaan</h2>
            
            <!-- Search and Filter -->
            <div class="flex space-x-4">
                <form action="{{ route('admin.inquiries.index') }}" method="GET" class="flex space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari permintaan..." 
                        class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    
                    <select name="status" class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                        @foreach($statuses as $key => $value)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    
                    <button type="submit" class="btn-primary px-4 py-2 rounded-lg">
                        Filter
                    </button>
                </form>
                
                <a href="{{ route('admin.inquiries.create') }}" class="btn-primary px-4 py-2 rounded-lg">
                    Tambah Baru
                </a>
            </div>
        </div>

        <!-- Inquiries Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="inquiries-table-body">
                    @if($inquiries->count() > 0)
                        @foreach($inquiries as $inquiry)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $inquiry->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $inquiry->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($inquiry->service)
                                    {{ $inquiry->service->name }}
                                @else
                                    <span class="text-red-500">Tidak ada layanan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $inquiry->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($inquiry->status == 'new') bg-blue-100 text-blue-800
                                    @elseif($inquiry->status == 'contacted') bg-yellow-100 text-yellow-800
                                    @elseif($inquiry->status == 'in_progress') bg-purple-100 text-purple-800
                                    @elseif($inquiry->status == 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $statuses[$inquiry->status] ?? $inquiry->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.inquiries.show', $inquiry) }}" 
                                    class="text-green-600 hover:text-green-900 mr-3">
                                    Detail
                                </a>
                                <a href="{{ route('admin.inquiries.edit', $inquiry) }}" 
                                    class="text-blue-600 hover:text-blue-900">
                                    Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr class="border-b">
                            <td colspan="6" class="px-6 py-4 text-center">Tidak ada data permintaan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $inquiries->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-refresh functionality
    function refreshTable() {
        const url = new URL(window.location.href);
        
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTableBody = doc.getElementById('inquiries-table-body');
                
                if (newTableBody) {
                    document.getElementById('inquiries-table-body').innerHTML = newTableBody.innerHTML;
                    console.log('Tabel permintaan diperbarui pada ' + new Date().toLocaleTimeString());
                }
            })
            .catch(error => console.error('Error refreshing table:', error));
    }

    // Refresh every 30 seconds
    setInterval(refreshTable, 30000);
    console.log('Auto-refresh aktif, interval 30 detik');
</script>
@endpush
@endsection 