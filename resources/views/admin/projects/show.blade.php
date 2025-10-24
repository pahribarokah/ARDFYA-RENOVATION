@extends('layouts.admin')

@section('title', 'Detail Proyek - Admin ARDFYA')

@section('header', 'Detail Proyek #' . $project->id)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between">
        <div class="flex space-x-2">
            <a href="{{ route('admin.projects.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
            <a href="{{ route('admin.projects.edit', $project) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center gap-2">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
        </div>
        <div class="flex space-x-2">
            @if(!$project->contract)
                <a href="{{ route('admin.contracts.create', ['project_id' => $project->id]) }}" class="bg-brand-green hover:bg-brand-green-dark text-white px-4 py-2 rounded-md flex items-center gap-2">
                    <i class="fas fa-file-contract"></i>
                    <span>Buat Kontrak</span>
                </a>
            @endif
            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');" class="inline">
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
        <!-- Project Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-700">Informasi Proyek</h3>
                    <div>
                        @if($project->status === 'planning')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Perencanaan</span>
                        @elseif($project->status === 'in_progress')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Pengerjaan</span>
                        @elseif($project->status === 'on_hold')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Tertunda</span>
                        @elseif($project->status === 'completed')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Selesai</span>
                        @elseif($project->status === 'cancelled')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
                        @endif
                    </div>
                </div>
                
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-800">{{ $project->name }}</h2>
                    <p class="text-gray-600">{{ $project->description }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Pelanggan</h4>
                            <p class="text-gray-800">{{ $project->user->name }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Layanan</h4>
                            <p class="text-gray-800">{{ $project->service->name }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Budget</h4>
                            <p class="text-gray-800">Rp {{ number_format($project->budget, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Tanggal Mulai</h4>
                            <p class="text-gray-800">{{ $project->start_date ? $project->start_date->format('d F Y') : '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Perkiraan Selesai</h4>
                            <p class="text-gray-800">{{ $project->expected_end_date ? $project->expected_end_date->format('d F Y') : 'Belum ditentukan' }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Tanggal Selesai Aktual</h4>
                            <p class="text-gray-800">{{ $project->actual_end_date ? $project->actual_end_date->format('d F Y') : 'Belum selesai' }}</p>
                        </div>
                    </div>
                </div>
                
                @if($project->inquiry)
                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between">
                        <h4 class="text-sm font-medium text-gray-700">Permintaan Terkait</h4>
                        <a href="{{ route('admin.inquiries.show', $project->inquiry) }}" class="text-xs text-brand-green hover:text-brand-green-dark">Lihat Detail</a>
                    </div>
                    <p class="text-sm text-gray-600">{{ $project->inquiry->name }}</p>
                </div>
                @endif
                
                @if($project->notes)
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-500">Catatan</h4>
                    <p class="text-gray-800">{{ $project->notes }}</p>
                </div>
                @endif
            </div>
            
            <!-- Progress Tracking -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Progress Proyek</h3>
                
                <div class="mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Progress</span>
                        <span>{{ $project->progress_percentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-brand-green h-2.5 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                    </div>
                </div>
                
                <!-- Project Timeline -->
                <div class="mt-6">
                    <h4 class="text-md font-medium text-gray-700 mb-3">Timeline</h4>
                    <div class="relative">
                        <div class="border-l-2 border-gray-200 ml-3 py-2">
                            <div class="flex mb-4">
                                <div class="absolute w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center -left-[0.65rem]">
                                    <i class="fas fa-calendar-plus text-white text-xs"></i>
                                </div>
                                <div class="ml-6">
                                    <p class="text-sm font-medium">Dimulai</p>
                                    <p class="text-xs text-gray-500">{{ $project->start_date->format('d F Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex mb-4">
                                <div class="absolute w-6 h-6 bg-{{ $project->progress_percentage >= 25 ? 'green' : 'gray' }}-500 rounded-full flex items-center justify-center -left-[0.65rem]">
                                    <i class="fas fa-tasks text-white text-xs"></i>
                                </div>
                                <div class="ml-6">
                                    <p class="text-sm font-medium">25% Selesai</p>
                                    <p class="text-xs text-gray-500">{{ $project->progress_percentage >= 25 ? 'Tercapai' : 'Belum tercapai' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex mb-4">
                                <div class="absolute w-6 h-6 bg-{{ $project->progress_percentage >= 50 ? 'green' : 'gray' }}-500 rounded-full flex items-center justify-center -left-[0.65rem]">
                                    <i class="fas fa-tasks text-white text-xs"></i>
                                </div>
                                <div class="ml-6">
                                    <p class="text-sm font-medium">50% Selesai</p>
                                    <p class="text-xs text-gray-500">{{ $project->progress_percentage >= 50 ? 'Tercapai' : 'Belum tercapai' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex mb-4">
                                <div class="absolute w-6 h-6 bg-{{ $project->progress_percentage >= 75 ? 'green' : 'gray' }}-500 rounded-full flex items-center justify-center -left-[0.65rem]">
                                    <i class="fas fa-tasks text-white text-xs"></i>
                                </div>
                                <div class="ml-6">
                                    <p class="text-sm font-medium">75% Selesai</p>
                                    <p class="text-xs text-gray-500">{{ $project->progress_percentage >= 75 ? 'Tercapai' : 'Belum tercapai' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class="absolute w-6 h-6 bg-{{ $project->progress_percentage == 100 ? 'green' : 'gray' }}-500 rounded-full flex items-center justify-center -left-[0.65rem]">
                                    <i class="fas fa-flag-checkered text-white text-xs"></i>
                                </div>
                                <div class="ml-6">
                                    <p class="text-sm font-medium">Selesai</p>
                                    <p class="text-xs text-gray-500">{{ $project->progress_percentage == 100 ? ($project->actual_end_date ? $project->actual_end_date->format('d F Y') : 'Tercapai') : 'Belum tercapai' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contract Information (if exists) -->
            @if($project->contract)
<div class="bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-700">Informasi Kontrak</h3>
        <div class="flex space-x-2">
            <a href="{{ route('admin.contracts.show', $project->contract) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm">
                Detail Kontrak
            </a>
                @if($project->contract->file_path)
                    <a href="{{ route('admin.contracts.download', $project->contract) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded-md text-sm">
                        <i class="fas fa-download mr-1"></i> Download
                    </a>
                @endif
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">ID Kontrak</h4>
                            <p class="text-gray-800">#{{ $project->contract->id ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Jumlah</h4>
                            <p class="text-gray-800">{{ $project->contract->amount ? 'Rp ' . number_format($project->contract->amount, 0, ',', '.') : '-' }}</p>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Tanggal Mulai</h4>
                            <p class="text-gray-800">{{ $project->contract->start_date ? $project->contract->start_date->format('d F Y') : '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500">Tanggal Berakhir</h4>
                            <p class="text-gray-800">{{ $project->contract->end_date ? $project->contract->end_date->format('d F Y') : '-' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-500">Status Pembayaran</h4>
                    <p class="text-gray-800">{{ $project->contract->payment_status ?? 'Belum ada status' }}</p>
                </div> -->
                
                @if($project->contract->notes)
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-500">Catatan Kontrak</h4>
                    <p class="text-gray-800">{{ $project->contract->notes }}</p>
                </div>
                @endif
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
                        <h4 class="text-md font-medium">{{ $project->user->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $project->user->email }}</p>
                    </div>
                </div>
                
                <div class="space-y-2">
                    @if($project->user->phone)
                    <div class="flex items-center">
                        <i class="fas fa-phone text-gray-500 w-6"></i>
                        <span class="text-sm text-gray-700">{{ $project->user->phone }}</span>
                    </div>
                    @endif
                    
                    @if($project->user->address)
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-gray-500 w-6"></i>
                        <span class="text-sm text-gray-700">{{ $project->user->address }}</span>
                    </div>
                    @endif
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.customers.show', $project->user) }}" class="text-brand-green hover:text-brand-green-dark text-sm">
                        Lihat Detail Pelanggan →
                    </a>
                </div>
            </div>
            
            <!-- Chat/Messages Panel -->
            <!-- <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Pesan Proyek</h3>
                
                <div class="space-y-4 max-h-96 overflow-y-auto mb-4">
                    @forelse($project->messages->sortBy('created_at') as $message)
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
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
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