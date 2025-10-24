@extends('layouts.main')

@section('title', 'Inquiry ' . $service->name)

@section('content')
<!-- Breadcrumb -->
<section class="bg-gray-100 py-4">
    <div class="container mx-auto px-6">
        <nav class="text-sm">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('home') }}" class="text-green-600 hover:text-green-700">Beranda</a>
                    <i class="fas fa-chevron-right mx-2 text-gray-400"></i>
                </li>
                <li class="flex items-center">
                    <a href="/#layanan" class="text-green-600 hover:text-green-700">Layanan</a>
                    <i class="fas fa-chevron-right mx-2 text-gray-400"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('services.show', $service) }}" class="text-green-600 hover:text-green-700">{{ $service->name }}</a>
                    <i class="fas fa-chevron-right mx-2 text-gray-400"></i>
                </li>
                <li class="text-gray-600">Inquiry</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Inquiry Form -->
<section class="py-16 md:py-24">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Inquiry {{ $service->name }}</h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Isi form di bawah ini untuk mendapatkan konsultasi dan penawaran terbaik untuk kebutuhan {{ $service->name }} Anda
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Service Info -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-6">
                        @if($service->image_path)
                            <div class="h-48 bg-gray-200 rounded-lg overflow-hidden mb-4">
                                <img src="{{ asset('storage/' . $service->image_path) }}" 
                                     alt="{{ $service->name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        @endif
                        
                        <div class="flex items-center mb-4">
                            @if($service->icon)
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="{{ $service->icon }} text-green-600 text-xl"></i>
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $service->name }}</h3>
                                @if($service->category)
                                    <span class="text-sm text-gray-500">{{ $service->category }}</span>
                                @endif
                            </div>
                        </div>
                        
                        @if($service->price_range)
                            <div class="mb-4">
                                <span class="text-sm text-gray-600">Kisaran Harga:</span>
                                <span class="text-green-600 font-semibold ml-1">{{ $service->price_range }}</span>
                            </div>
                        @endif
                        
                        <p class="text-gray-600 text-sm mb-6">{{ Str::limit($service->description, 150) }}</p>
                        
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                Konsultasi gratis
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                Estimasi akurat
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                Tim profesional
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                Garansi pekerjaan
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Inquiry Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form action="{{ route('inquiries.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            
                            <!-- Personal Information -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pribadi</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                        <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name ?? '') }}" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                        <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>
                                    
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon *</label>
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>
                                    
                                    <div>
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat *</label>
                                        <input type="text" id="address" name="address" value="{{ old('address', Auth::user()->address ?? '') }}" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Project Details -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Proyek</h3>
                                <div class="space-y-6">
                                    <div>
                                        <label for="project_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Proyek *</label>
                                        <input type="text" id="project_title" name="project_title" value="{{ old('project_title') }}" required
                                               placeholder="Contoh: Renovasi Kamar Tidur Utama"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>
                                    
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Kebutuhan *</label>
                                        <textarea id="description" name="description" rows="5" required
                                                  placeholder="Jelaskan detail kebutuhan Anda, ukuran ruangan, material yang diinginkan, dll."
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('description') }}</textarea>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="budget_range" class="block text-sm font-medium text-gray-700 mb-2">Estimasi Budget</label>
                                            <select id="budget_range" name="budget_range"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                <option value="">Pilih range budget</option>
                                                <option value="< 5 juta" {{ old('budget_range') == '< 5 juta' ? 'selected' : '' }}>< 5 juta</option>
                                                <option value="5 - 10 juta" {{ old('budget_range') == '5 - 10 juta' ? 'selected' : '' }}>5 - 10 juta</option>
                                                <option value="10 - 25 juta" {{ old('budget_range') == '10 - 25 juta' ? 'selected' : '' }}>10 - 25 juta</option>
                                                <option value="25 - 50 juta" {{ old('budget_range') == '25 - 50 juta' ? 'selected' : '' }}>25 - 50 juta</option>
                                                <option value="> 50 juta" {{ old('budget_range') == '> 50 juta' ? 'selected' : '' }}>> 50 juta</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="timeline" class="block text-sm font-medium text-gray-700 mb-2">Target Waktu</label>
                                            <select id="timeline" name="timeline"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                <option value="">Pilih timeline</option>
                                                <option value="Segera" {{ old('timeline') == 'Segera' ? 'selected' : '' }}>Segera (< 1 bulan)</option>
                                                <option value="1-3 bulan" {{ old('timeline') == '1-3 bulan' ? 'selected' : '' }}>1-3 bulan</option>
                                                <option value="3-6 bulan" {{ old('timeline') == '3-6 bulan' ? 'selected' : '' }}>3-6 bulan</option>
                                                <option value="> 6 bulan" {{ old('timeline') == '> 6 bulan' ? 'selected' : '' }}>> 6 bulan</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="attachments" class="block text-sm font-medium text-gray-700 mb-2">Lampiran (Opsional)</label>
                                        <input type="file" id="attachments" name="attachments[]" multiple accept="image/*,.pdf,.doc,.docx"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <p class="text-sm text-gray-500 mt-1">Upload foto, sketsa, atau dokumen pendukung (Max: 5MB per file)</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="flex flex-col sm:flex-row gap-4">
                                <button type="submit" 
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                                    <i class="fas fa-paper-plane mr-2"></i>Kirim Inquiry
                                </button>
                                <a href="{{ route('services.show', $service) }}" 
                                   class="flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 px-8 py-3 rounded-lg font-semibold text-center transition-colors">
                                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
