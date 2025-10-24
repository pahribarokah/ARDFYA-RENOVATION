@extends('layouts.admin')

@section('title', 'Tambah Proyek Baru - Admin ARDFYA')

@section('header', 'Tambah Proyek Baru')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 mb-6">
    <div class="mb-6">
        <a href="{{ route('admin.projects.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Dasar</h3>
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Proyek</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="service_id" class="block text-sm font-medium text-gray-700 mb-1">Layanan</label>
                    <select id="service_id" name="service_id" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        <option value="">Pilih Layanan</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id', isset($inquiry) ? $inquiry->service_id : '') == $service->id ? 'selected' : '' }}>
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
                    <textarea id="description" name="description" rows="3" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan</label>
                    <textarea id="notes" name="notes" rows="2" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Pelanggan & Permintaan</h3>
                
                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Pelanggan</label>
                    <select id="user_id" name="user_id" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        <option value="">Pilih Pelanggan</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('user_id', isset($inquiry) ? $inquiry->user_id : '') == $customer->id ? 'selected' : '' }}>
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
                        @foreach($inquiries as $inquiryItem)
                            <option value="{{ $inquiryItem->id }}" {{ old('inquiry_id', isset($inquiry) ? $inquiry->id : '') == $inquiryItem->id ? 'selected' : '' }}>
                                #{{ $inquiryItem->id }} - {{ $inquiryItem->name }} ({{ $inquiryItem->service->name }})
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
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date', isset($inquiry) && $inquiry->start_date ? $inquiry->start_date->format('Y-m-d') : '') }}" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="expected_end_date" class="block text-sm font-medium text-gray-700 mb-1">Perkiraan Selesai</label>
                        <input type="date" id="expected_end_date" name="expected_end_date" value="{{ old('expected_end_date') }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        @error('expected_end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="budget" class="block text-sm font-medium text-gray-700 mb-1">Budget (Rp)</label>
    <input
        type="number"
        id="budget"
        name="budget"
        value="{{ old('budget', $inquiry ? $inquiry->budget : '') }}"
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
                Simpan Proyek
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // When changing the inquiry, update other fields
        const inquirySelect = document.getElementById('inquiry_id');
        inquirySelect.addEventListener('change', function() {
            // This would ideally fetch the inquiry details via AJAX
            // and fill in the form fields, but for now it's just a placeholder
            // The data is already pre-filled from the controller if inquiry_id is passed
        });
    });
</script>
@endsection 