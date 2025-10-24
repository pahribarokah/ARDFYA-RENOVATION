@extends('layouts.admin')

@section('title', 'Tambah Kontrak Baru - Admin ARDFYA')

@section('header', 'Tambah Kontrak Baru')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 mb-6">
    <div class="mb-6">
        <a href="{{ route('admin.contracts.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.contracts.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Proyek & Pelanggan</h3>
                
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-1">
                        <label for="project_id" class="block text-sm font-medium text-gray-700">Proyek</label>
                        <a href="{{ route('admin.projects.create') }}" class="text-sm text-brand-green hover:text-brand-green-dark">
                            <i class="fas fa-plus"></i> Buat Proyek Baru
                        </a>
                    </div>
                    <select id="project_id" name="project_id" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        <option value="">Pilih Proyek</option>
                        @if(isset($project))
                            <option value="{{ $project->id }}" selected>
                                {{ $project->name }} ({{ $project->user->name }})
                            </option>
                        @elseif(isset($projectsWithoutContracts) && count($projectsWithoutContracts) > 0)
                            @foreach($projectsWithoutContracts as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }} ({{ $project->user->name }})
                                </option>
                            @endforeach
                        @else
                            <option disabled>Tidak ada proyek tersedia</option>
                        @endif
                    </select>
                    @error('project_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @if(!isset($projectsWithoutContracts) || count($projectsWithoutContracts) === 0)
                        <p class="text-amber-600 text-xs mt-1">Tidak ada proyek tersedia untuk kontrak baru. Silakan buat proyek terlebih dahulu.</p>
                    @endif
                </div>
                
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Nilai Kontrak (Rp)</label>
                    <input type="number" id="amount" name="amount" value="{{ old('amount', isset($project) ? $project->budget : '') }}" min="0" max="9999999999.99" step="0.01" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                    @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- <div class="mb-4">
                    <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                    <select id="payment_status" name="payment_status" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="partial" {{ old('payment_status') == 'partial' ? 'selected' : '' }}>Pembayaran Sebagian</option>
                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                    </select>
                    @error('payment_status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div> -->
                

            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Jadwal & Catatan</h3>
                
                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', isset($project) && $project->start_date ? $project->start_date->format('Y-m-d') : '') }}" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                    @error('start_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', isset($project) && $project->expected_end_date ? $project->expected_end_date->format('Y-m-d') : '') }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                    @error('end_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="contract_status" class="block text-sm font-medium text-gray-700 mb-1">Status Kontrak</label>
                    <select id="contract_status" name="contract_status" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        <option value="draft" {{ old('contract_status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="active" {{ old('contract_status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="completed" {{ old('contract_status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="terminated" {{ old('contract_status') == 'terminated' ? 'selected' : '' }}>Dihentikan</option>
                    </select>
                    @error('contract_status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <textarea id="notes" name="notes" rows="5" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-brand-green hover:bg-brand-green-dark text-white px-6 py-2 rounded-md">
                Simpan Kontrak
            </button>
        </div>
    </form>
</div>
@endsection 