@extends('layouts.admin')

@section('title', 'Detail Permintaan - Admin ARDFYA')

@section('header', 'Detail Permintaan #' . $inquiry->id)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between">
        <div class="flex space-x-2">
            <a href="{{ route('admin.inquiries.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
            <a href="{{ route('admin.inquiries.edit', $inquiry) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center gap-2">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
        </div>
        <div class="flex space-x-2">
            @if(!$inquiry->project)
                <a href="{{ route('admin.projects.create', ['inquiry_id' => $inquiry->id]) }}" class="bg-brand-green hover:bg-brand-green-dark text-white px-4 py-2 rounded-md flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Buat Proyek</span>
                </a>
            @endif
            <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permintaan ini?');" class="inline">
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
        <!-- Inquiry Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-700">Informasi Permintaan</h3>
                    <div>
                        <form action="{{ route('admin.inquiries.updateStatus', $inquiry) }}" method="POST" class="flex space-x-2">
                            @csrf
                            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                <option value="new" {{ $inquiry->status == 'new' ? 'selected' : '' }}>Baru</option>
                                <option value="contacted" {{ $inquiry->status == 'contacted' ? 'selected' : '' }}>Dihubungi</option>
                                <option value="in_progress" {{ $inquiry->status == 'in_progress' ? 'selected' : '' }}>Diproses</option>
                                <option value="completed" {{ $inquiry->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $inquiry->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            <button type="submit" class="bg-brand-green hover:bg-brand-green-dark text-white px-3 py-1 rounded-md text-sm">
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Nama</h4>
                            <p class="text-gray-800">{{ $inquiry->name }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Email</h4>
                            <p class="text-gray-800">{{ $inquiry->email }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Telepon</h4>
                            <p class="text-gray-800">{{ $inquiry->phone }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Alamat</h4>
                            <p class="text-gray-800">{{ $inquiry->address }}</p>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Layanan</h4>
                            <p class="text-gray-800">{{ $inquiry->service->name }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Tipe Properti</h4>
                            <p class="text-gray-800">{{ ucfirst($inquiry->property_type) }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Luas Area</h4>
                            <p class="text-gray-800">{{ $inquiry->area_size }} m²</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Budget</h4>
                            <p class="text-gray-800">Rp {{ number_format($inquiry->budget, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-500">Kondisi Saat Ini</h4>
                    <p class="text-gray-800">{{ $inquiry->current_condition }}</p>
                </div>
                
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-500">Deskripsi</h4>
                    <p class="text-gray-800">{{ $inquiry->description }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
    <div>
        <h4 class="text-sm font-medium text-gray-500">Tanggal Mulai Diinginkan</h4>
        <p class="text-gray-800">
            @if($inquiry->start_date)
                {{ $inquiry->start_date->format('d F Y') }}
            @else
                <span class="text-gray-500">-</span>
            @endif
        </p>
    </div>
    <div>
        <h4 class="text-sm font-medium text-gray-500">Fleksibilitas Jadwal</h4>
        <p class="text-gray-800">
            {{ $inquiry->schedule_flexibility ?? '-' }}
        </p>
    </div>
</div>
                
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-500">Dibuat Pada</h4>
                    <p class="text-gray-800">{{ $inquiry->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>
            
            <!-- Project Information (if exists) -->
            @if($inquiry->project)
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-700">Informasi Proyek</h3>
                    <a href="{{ route('admin.projects.show', $inquiry->project) }}" class="text-brand-green hover:text-brand-green-dark">
                        Lihat Detail Proyek
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Nama Proyek</h4>
                            <p class="text-gray-800">{{ $inquiry->project->name }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Status</h4>
                            <div>
                                @if($inquiry->project->status === 'planning')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Perencanaan</span>
                                @elseif($inquiry->project->status === 'in_progress')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Pengerjaan</span>
                                @elseif($inquiry->project->status === 'on_hold')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Ditunda</span>
                                @elseif($inquiry->project->status === 'completed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Selesai</span>
                                @elseif($inquiry->project->status === 'cancelled')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Tanggal Mulai</h4>
                            <p class="text-gray-800">{{ $inquiry->project->start_date->format('d F Y') }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Perkiraan Selesai</h4>
                            <p class="text-gray-800">{{ $inquiry->project->expected_end_date->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-500">Progress</h4>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                        <div class="bg-brand-green h-2.5 rounded-full" style="width: {{ $inquiry->project->progress_percentage }}%"></div>
                    </div>
                    <span class="text-sm text-gray-500">{{ $inquiry->project->progress_percentage }}%</span>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Customer Information and Chat Panel -->
        <div class="space-y-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Pelanggan</h3>
                
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-gray-200 rounded-full w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-user text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-md font-medium">{{ $inquiry->user->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $inquiry->user->email }}</p>
                    </div>
                </div>
                
                <div class="space-y-2">
                    @if($inquiry->user->phone)
                    <div class="flex items-center">
                        <i class="fas fa-phone text-gray-500 w-6"></i>
                        <span class="text-sm text-gray-700">{{ $inquiry->user->phone }}</span>
                    </div>
                    @endif
                    
                    @if($inquiry->user->address)
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-gray-500 w-6"></i>
                        <span class="text-sm text-gray-700">{{ $inquiry->user->address }}</span>
                    </div>
                    @endif
                    
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-gray-500 w-6"></i>
                        <span class="text-sm text-gray-700">Bergabung: {{ $inquiry->user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.customers.show', $inquiry->user) }}" class="text-brand-green hover:text-brand-green-dark text-sm">
                        Lihat Detail Pelanggan →
                    </a>
                </div>
            </div>
            
            <!-- Chat/Messages Panel -->
            <!-- <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Pesan</h3>
                
                <div class="space-y-4 max-h-96 overflow-y-auto mb-4">
                    @forelse($inquiry->messages->sortBy('created_at') as $message)
                        <div class="flex {{ $message->is_from_admin ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-3/4 px-4 py-2 rounded-lg {{ $message->is_from_admin ? 'bg-brand-green text-white' : 'bg-gray-200 text-gray-800' }}">
                                <p class="text-sm">{{ $message->message }}</p>
                                <p class="text-xs {{ $message->is_from_admin ? 'text-green-100' : 'text-gray-500' }} mt-1">{{ $message->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center">Belum ada pesan.</p>
                    @endforelse
                </div>
                
                <form action="{{ route('messages.send') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="inquiry_id" value="{{ $inquiry->id }}">
                    <input type="hidden" name="is_from_admin" value="1">
                    
                    <div class="flex">
                        <input type="text" name="message" placeholder="Ketik pesan..." required class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <button type="submit" class="bg-brand-green text-white rounded-r-md px-4 py-2">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div> -->
        </div>
    </div>
</div>
@endsection 