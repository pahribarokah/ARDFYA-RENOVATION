@extends('layouts.admin')

@section('title', 'Edit Proyek - Admin ARDFYA')

@section('header', 'Edit Proyek #' . $project->id)

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 mb-6">
    <div class="mb-6">
        <a href="{{ route('admin.projects.show', $project) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Dasar</h3>
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Proyek</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $project->name) }}" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="service_id" class="block text-sm font-medium text-gray-700 mb-1">Layanan</label>
                    <select id="service_id" name="service_id" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        <option value="">Pilih Layanan</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id', $project->service_id) == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Proyek</label>
                    <textarea id="description" name="description" rows="3" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">{{ old('description', $project->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        <option value="planning" {{ old('status', $project->status) == 'planning' ? 'selected' : '' }}>Perencanaan</option>
                        <option value="in_progress" {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }}>Pengerjaan</option>
                        <option value="on_hold" {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }}>Tertunda</option>
                        <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ old('status', $project->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="progress_percentage" class="block text-sm font-medium text-gray-700 mb-1">Progress (%)</label>
                    <input type="number" id="progress_percentage" name="progress_percentage" value="{{ old('progress_percentage', $project->progress_percentage) }}" min="0" max="100" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                    @error('progress_percentage')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan</label>
                    <textarea id="notes" name="notes" rows="2" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">{{ old('notes', $project->notes) }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Pelanggan & Jadwal</h3>
                
                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Pelanggan</label>
                    <select id="user_id" name="user_id" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        <option value="">Pilih Pelanggan</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('user_id', $project->user_id) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="inquiry_id" class="block text-sm font-medium text-gray-700 mb-1">Permintaan Terkait</label>
                    <select id="inquiry_id" name="inquiry_id" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        <option value="">Tidak Ada / Permintaan Langsung</option>
                        @foreach($inquiries as $inquiry)
                            <option value="{{ $inquiry->id }}" {{ old('inquiry_id', $project->inquiry_id) == $inquiry->id ? 'selected' : '' }}>
                                #{{ $inquiry->id }} - {{ $inquiry->name }} ({{ $inquiry->service->name }})
                            </option>
                        @endforeach
                    </select>
                    @error('inquiry_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="expected_end_date" class="block text-sm font-medium text-gray-700 mb-1">Perkiraan Selesai</label>
                        <input type="date" id="expected_end_date" name="expected_end_date" value="{{ old('expected_end_date', $project->expected_end_date ? $project->expected_end_date->format('Y-m-d') : '') }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        @error('expected_end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="actual_end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai Aktual</label>
                    <input type="date" id="actual_end_date" name="actual_end_date" value="{{ old('actual_end_date', $project->actual_end_date ? $project->actual_end_date->format('Y-m-d') : '') }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                    @error('actual_end_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="budget" class="block text-sm font-medium text-gray-700 mb-1">Budget (Rp)</label>
                        <input
                            type="number"
                            id="budget"
                            name="budget"
                            value="{{ old('budget', $project->budget) }}"
                            min="0"
                            max="9999999999.99"
                            step="0.01"
                            required
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
                        >
                        @error('budget')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Maksimal: Rp 9,999,999,999.99</p>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-brand-green hover:bg-brand-green-dark text-white px-6 py-2 rounded-md">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection 