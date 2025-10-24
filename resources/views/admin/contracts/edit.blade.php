@extends('layouts.admin')

@section('title', 'Edit Kontrak - Admin ARDFYA')

@section('header', 'Edit Kontrak #' . $contract->id)

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 mb-6">
    <div class="mb-6">
        <a href="{{ route('admin.contracts.show', $contract) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.contracts.update', $contract) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Proyek & Informasi Pembayaran</h3>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Proyek</label>
                    <div class="bg-gray-50 p-3 rounded-md border border-gray-200">
                        <p class="text-gray-800">{{ $contract->project->name }}</p>
                        <p class="text-xs text-gray-500">Pelanggan: {{ $contract->user->name }}</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Nilai Kontrak (Rp)</label>
                    <input type="number" id="amount" name="amount" value="{{ old('amount', $contract->amount) }}" min="0" max="9999999999.99" step="0.01" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                    @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- <div class="mb-4">
                    <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                    <select id="payment_status" name="payment_status" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        <option value="pending" {{ old('payment_status', $contract->payment_status) == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="partial" {{ old('payment_status', $contract->payment_status) == 'partial' ? 'selected' : '' }}>Pembayaran Sebagian</option>
                        <option value="paid" {{ old('payment_status', $contract->payment_status) == 'paid' ? 'selected' : '' }}>Lunas</option>
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
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $contract->start_date->format('Y-m-d')) }}" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                    @error('start_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $contract->end_date ? $contract->end_date->format('Y-m-d') : '') }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                    @error('end_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="contract_status" class="block text-sm font-medium text-gray-700 mb-1">Status Kontrak</label>
                    <select id="contract_status" name="contract_status" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        @foreach($contractStatuses as $value => $label)
                            <option value="{{ $value }}" {{ old('contract_status', $contract->contract_status) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('contract_status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>



                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <textarea id="notes" name="notes" rows="5" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">{{ old('notes', $contract->notes) }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
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