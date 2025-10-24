@extends('layouts.admin')

@section('title', 'Detail Pelanggan - Admin ARDFYA')

@section('header', 'Detail Pelanggan')

@section('content')
<div class="container-fluid">
    <!-- Auto Refresh Notice -->
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4 rounded shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-sync text-blue-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    Halaman ini akan disegarkan secara otomatis setiap 30 detik untuk menampilkan data terbaru.
                    <span id="refresh-countdown" class="font-semibold">30</span> detik hingga penyegaran berikutnya.
                    <button type="button" id="refresh-now" class="ml-2 text-blue-500 hover:text-blue-700 underline">
                        Segarkan sekarang
                    </button>
                </p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mb-4">
        <a href="{{ route('admin.customers.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
        
        <div class="float-right">
            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>
    </div>

    <!-- Customer Info Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Informasi Pelanggan</h2>
        
        <div class="flex flex-col md:flex-row items-start md:space-x-6">
            <div class="flex-shrink-0 mb-4 md:mb-0">
                <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                    <i class="fas fa-user text-4xl"></i>
                </div>
            </div>
            
            <div class="flex-grow">
                <h3 class="text-2xl font-bold text-gray-800">{{ $customer->name }}</h3>
                <p class="text-gray-600">{{ $customer->email }}</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <p class="text-gray-600"><strong>Telepon:</strong> {{ $customer->phone ?? 'Tidak ada' }}</p>
                        <p class="text-gray-600"><strong>Alamat:</strong> {{ $customer->address ?? 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600"><strong>Terdaftar:</strong> {{ $customer->created_at->format('d/m/Y H:i') }}</p>
                        <p class="text-gray-600"><strong>Terakhir Diperbarui:</strong> {{ $customer->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Summary -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Ringkasan Aktivitas</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-700">{{ $stats['new_inquiries'] }}</h3>
                <p class="text-sm text-gray-600">Permintaan Baru</p>
            </div>
            
            <div class="bg-purple-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-purple-700">{{ $stats['in_progress'] }}</h3>
                <p class="text-sm text-gray-600">Permintaan Diproses</p>
            </div>
            
            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-green-700">{{ $stats['active_projects'] }}</h3>
                <p class="text-sm text-gray-600">Proyek Aktif</p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700">{{ $stats['completed_projects'] }}</h3>
                <p class="text-sm text-gray-600">Proyek Selesai</p>
            </div>
        </div>
    </div>

    <!-- Inquiries Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Permintaan</h2>
            
            <a href="{{ route('admin.inquiries.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Permintaan
            </a>
        </div>
        
        @if(count($inquiries) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($inquiries as $inquiry)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $inquiry->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($inquiry->service)
                                        {{ $inquiry->service->name }}
                                    @else
                                        <span class="text-red-500">Tidak ada layanan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $inquiry->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($inquiry->status === 'new') bg-blue-100 text-blue-800
                                        @elseif($inquiry->status === 'contacted') bg-yellow-100 text-yellow-800
                                        @elseif($inquiry->status === 'in_progress') bg-purple-100 text-purple-800
                                        @elseif($inquiry->status === 'completed') bg-green-100 text-green-800
                                        @elseif($inquiry->status === 'cancelled') bg-red-100 text-red-800
                                        @endif
                                    ">
                                        {{ ucfirst($inquiry->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="text-green-600 hover:text-green-900 mr-3">Detail</a>
                                    <a href="{{ route('admin.inquiries.edit', $inquiry) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-gray-50 p-6 rounded-lg text-center">
                <p class="text-gray-500">Pelanggan ini belum memiliki permintaan.</p>
                <a href="{{ route('admin.inquiries.create') }}" class="mt-2 inline-block text-green-600 hover:text-green-900">
                    <i class="fas fa-plus mr-1"></i> Buat Permintaan Baru
                </a>
            </div>
        @endif
    </div>

    <!-- Projects Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Proyek</h2>
            
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Proyek
            </a>
        </div>
        
        @if(count($projects) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($projects as $project)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $project->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $project->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($project->service)
                                        {{ $project->service->name }}
                                    @else
                                        <span class="text-red-500">Tidak ada layanan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($project->status === 'planning') bg-yellow-100 text-yellow-800
                                        @elseif($project->status === 'active') bg-green-100 text-green-800
                                        @elseif($project->status === 'on_hold') bg-orange-100 text-orange-800
                                        @elseif($project->status === 'completed') bg-blue-100 text-blue-800
                                        @elseif($project->status === 'cancelled') bg-red-100 text-red-800
                                        @endif
                                    ">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.projects.show', $project) }}" class="text-green-600 hover:text-green-900 mr-3">Detail</a>
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-gray-50 p-6 rounded-lg text-center">
                <p class="text-gray-500">Pelanggan ini belum memiliki proyek.</p>
                <a href="{{ route('admin.projects.create') }}" class="mt-2 inline-block text-green-600 hover:text-green-900">
                    <i class="fas fa-plus mr-1"></i> Buat Proyek Baru
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus pelanggan <strong>{{ $customer->name }}</strong>?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Auto-refresh functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let countdown = 30;
        const countdownDisplay = document.getElementById('refresh-countdown');
        
        // Update countdown every second
        const timer = setInterval(function() {
            countdown--;
            countdownDisplay.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(timer);
                location.reload();
            }
        }, 1000);
        
        // Manual refresh button
        document.getElementById('refresh-now').addEventListener('click', function() {
            clearInterval(timer);
            location.reload();
        });
    });
</script>
@endsection 