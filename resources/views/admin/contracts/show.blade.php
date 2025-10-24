@extends('layouts.admin')

@section('title', 'Detail Kontrak - Admin ARDFYA')

@section('header', 'Detail Kontrak #' . $contract->id)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between">
        <div class="flex space-x-2">
            <a href="{{ route('admin.contracts.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
            <a href="{{ route('admin.contracts.edit', $contract) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center gap-2">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
        </div>
        <div class="flex space-x-2">
            @if($contract->contract_file)
                <a href="{{ route('admin.contracts.download', $contract) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center gap-2">
                    <i class="fas fa-download"></i>
                    <span>Download</span>
                </a>
            @endif
            <form action="{{ route('admin.contracts.destroy', $contract) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontrak ini?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md flex items-center gap-2">
                    <i class="fas fa-trash"></i>
                    <span>Hapus</span>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Contract Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-700">Informasi Kontrak</h3>
                    <div>
                        @if($contract->contract_status === 'draft')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>
                        @elseif($contract->contract_status === 'active')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                        @elseif($contract->contract_status === 'completed')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Selesai</span>
                        @elseif($contract->contract_status === 'terminated')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Dihentikan</span>
                        @endif
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Proyek</h4>
                            <div class="flex items-center">
                                <p class="text-gray-800">{{ $contract->project->name }}</p>
                                <a href="{{ route('admin.projects.show', $contract->project) }}" class="ml-2 text-brand-green hover:text-brand-green-dark">
                                    <i class="fas fa-external-link-alt text-xs"></i>
                                </a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Pelanggan</h4>
                            <div class="flex items-center">
                                <p class="text-gray-800">{{ $contract->user->name }}</p>
                                <a href="{{ route('admin.customers.show', $contract->user) }}" class="ml-2 text-brand-green hover:text-brand-green-dark">
                                    <i class="fas fa-external-link-alt text-xs"></i>
                                </a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Total Nilai Kontrak</h4>
                            <p class="text-gray-800 text-xl font-semibold">Rp {{ number_format($contract->amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Tanggal Mulai</h4>
                            <p class="text-gray-800">{{ $contract->start_date->format('d F Y') }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Tanggal Berakhir</h4>
                            <p class="text-gray-800">{{ $contract->end_date ? $contract->end_date->format('d F Y') : 'Tidak ditentukan' }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Dibuat Pada</h4>
                            <p class="text-gray-800">{{ $contract->created_at->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                @if($contract->notes)
                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Catatan</h4>
                    <p class="text-sm text-gray-600">{{ $contract->notes }}</p>
                </div>
                @endif
            </div>
            
            <!-- Contract File Preview -->
            @if($contract->contract_file)
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Dokumen Kontrak</h3>
                
                <div class="border border-gray-200 rounded-lg p-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-gray-100 p-3 rounded-lg mr-3">
                            <i class="fas fa-file-contract text-gray-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Dokumen Kontrak</p>
                            <p class="text-xs text-gray-500">{{ pathinfo($contract->contract_file, PATHINFO_BASENAME) }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.contracts.download', $contract) }}" class="bg-brand-green hover:bg-brand-green-dark text-white px-3 py-1 rounded-md text-sm">
                        <i class="fas fa-download mr-1"></i> Download
                    </a>
                </div>
            </div>
            @endif
            
            <!-- Project Information -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Proyek</h3>
                
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Status Proyek</h4>
                    <div>
                        @if($contract->project->status === 'planning')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Perencanaan</span>
                        @elseif($contract->project->status === 'in_progress')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Pengerjaan</span>
                        @elseif($contract->project->status === 'on_hold')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Tertunda</span>
                        @elseif($contract->project->status === 'completed')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Selesai</span>
                        @elseif($contract->project->status === 'cancelled')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
                        @endif
                    </div>
                </div>
                
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Progress Proyek</h4>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-brand-green h-2.5 rounded-full" style="width: {{ $contract->project->progress_percentage }}%"></div>
                    </div>
                    <span class="text-sm text-gray-500">{{ $contract->project->progress_percentage }}%</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Deskripsi</h4>
                        <p class="text-sm text-gray-600">{{ Str::limit($contract->project->description, 150) }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Tanggal Proyek</h4>
                        <p class="text-sm text-gray-600">Mulai: {{ $contract->project->start_date->format('d M Y') }}</p>
                        <p class="text-sm text-gray-600">
                            Selesai: {{ $contract->project->actual_end_date ? $contract->project->actual_end_date->format('d M Y') : 'Belum selesai' }}
                        </p>
                    </div>
                </div>
                
                <div class="mt-3">
                    <a href="{{ route('admin.projects.show', $contract->project) }}" class="text-brand-green hover:text-brand-green-dark text-sm">
                        Lihat Detail Proyek →
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Customer Information and Notes -->
        <div class="space-y-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Pelanggan</h3>
                
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-gray-200 rounded-full w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-user text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-md font-medium">{{ $contract->user->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $contract->user->email }}</p>
                    </div>
                </div>
                
                <div class="space-y-2">
                    @if($contract->user->phone)
                    <div class="flex items-center">
                        <i class="fas fa-phone text-gray-500 w-6"></i>
                        <span class="text-sm text-gray-700">{{ $contract->user->phone }}</span>
                    </div>
                    @endif
                    
                    @if($contract->user->address)
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-gray-500 w-6"></i>
                        <span class="text-sm text-gray-700">{{ $contract->user->address }}</span>
                    </div>
                    @endif
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.customers.show', $contract->user) }}" class="text-brand-green hover:text-brand-green-dark text-sm">
                        Lihat Detail Pelanggan →
                    </a>
                </div>
            </div>

    </div>
</div>
@endsection 