@extends('layouts.admin')

@section('title', 'Detail Portfolio')
@section('header', 'Detail Portfolio')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <a href="{{ route('admin.portfolios.index') }}" 
               class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="text-xl font-semibold text-gray-800">{{ $portfolio->title }}</h2>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.portfolios.edit', $portfolio) }}" 
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <form action="{{ route('admin.portfolios.destroy', $portfolio) }}" 
                  method="POST" 
                  class="inline-block"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus portfolio ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Image Section -->
        <div>
            <div class="aspect-w-16 aspect-h-12 rounded-lg overflow-hidden bg-gray-100">
                @if($portfolio->image_path)
                    <img src="{{ asset('storage/' . $portfolio->image_path) }}" 
                         alt="{{ $portfolio->title }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <div class="text-center">
                            <svg class="mx-auto h-16 w-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm">Tidak ada gambar</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Details Section -->
        <div class="space-y-6">
            <!-- Basic Info -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Kategori:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $portfolio->category_name }}
                        </span>
                    </div>
                    @if($portfolio->client_name)
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500">Klien:</span>
                            <span class="text-sm text-gray-900">{{ $portfolio->client_name }}</span>
                        </div>
                    @endif
                    @if($portfolio->location)
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500">Lokasi:</span>
                            <span class="text-sm text-gray-900">{{ $portfolio->location }}</span>
                        </div>
                    @endif
                    @if($portfolio->completion_date)
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500">Tanggal Selesai:</span>
                            <span class="text-sm text-gray-900">{{ $portfolio->completion_date->format('d M Y') }}</span>
                        </div>
                    @endif
                    @if($portfolio->project_value)
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500">Nilai Proyek:</span>
                            <span class="text-sm text-gray-900 font-semibold">{{ $portfolio->formatted_project_value }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Urutan:</span>
                        <span class="text-sm text-gray-900">{{ $portfolio->ordering }}</span>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                <div class="flex items-center space-x-4">
                    @if($portfolio->is_active)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Tidak Aktif
                        </span>
                    @endif
                    
                    @if($portfolio->is_featured)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Unggulan
                        </span>
                    @endif
                </div>
            </div>

            <!-- Timestamps -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Sistem</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Dibuat:</span>
                        <span>{{ $portfolio->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Diperbarui:</span>
                        <span>{{ $portfolio->updated_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi</h3>
        <div class="prose max-w-none">
            <p class="text-gray-700 leading-relaxed">{{ $portfolio->description }}</p>
        </div>
    </div>
</div>
@endsection
