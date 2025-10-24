@extends('layouts.main')

@section('title', $portfolio->title . ' - ARDFYA')

@section('content')
<!-- Hero Section -->
<section class="bg-cover bg-center py-20 md:py-32 text-white" style="background-image: linear-gradient(rgba(0, 77, 64, 0.8), rgba(0, 77, 64, 0.8)), url('{{ $portfolio->image_path ? asset('storage/' . $portfolio->image_path) : 'https://img.freepik.com/free-photo/luxury-pool-villa-spectacular-contemporary-design-digital-art-real-estate-home-house-property-genera_1258-150763.jpg' }}');">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl">
            <nav class="text-sm mb-6 opacity-90">
                <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
                <span class="mx-2">›</span>
                <a href="{{ route('portfolio') }}" class="hover:text-white">Portfolio</a>
                <span class="mx-2">›</span>
                <span>{{ $portfolio->title }}</span>
            </nav>
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight tracking-tight">{{ $portfolio->title }}</h1>
            <div class="flex flex-wrap gap-3 mb-6">
                @php
                    $badgeColors = [
                        'renovasi' => 'bg-green-100 text-green-800',
                        'pembangunan' => 'bg-blue-100 text-blue-800',
                        'interior' => 'bg-purple-100 text-purple-800',
                        'eksterior' => 'bg-orange-100 text-orange-800',
                        'landscape' => 'bg-green-100 text-green-800',
                        'komersial' => 'bg-gray-100 text-gray-800',
                        'residensial' => 'bg-indigo-100 text-indigo-800'
                    ];
                    $badgeColor = $badgeColors[$portfolio->category] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="px-3 py-1 {{ $badgeColor }} rounded-full text-sm font-medium">{{ $portfolio->category_name }}</span>
                @if($portfolio->completion_date)
                    <span class="px-3 py-1 bg-white bg-opacity-20 text-white rounded-full text-sm font-medium">{{ $portfolio->completion_date->format('Y') }}</span>
                @endif
                @if($portfolio->location)
                    <span class="px-3 py-1 bg-white bg-opacity-20 text-white rounded-full text-sm font-medium">
                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $portfolio->location }}
                    </span>
                @endif
            </div>
            <p class="text-xl max-w-3xl opacity-90">{{ $portfolio->description }}</p>
        </div>
    </div>
</section>

<!-- Portfolio Details -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Main Image -->
                <div class="mb-8">
                    @if($portfolio->image_path)
                        <img src="{{ asset('storage/' . $portfolio->image_path) }}" 
                             alt="{{ $portfolio->title }}" 
                             class="w-full h-96 object-cover rounded-xl shadow-lg">
                    @else
                        <div class="w-full h-96 bg-gray-200 rounded-xl shadow-lg flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="prose max-w-none mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Tentang Proyek</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $portfolio->description }}</p>
                </div>

                <!-- Call to Action -->
                <div class="bg-green-50 rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Tertarik dengan proyek serupa?</h3>
                    <p class="text-gray-600 mb-4">Konsultasikan kebutuhan renovasi atau pembangunan Anda dengan tim profesional kami.</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('inquiries.create') }}" 
                           class="bg-green-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-800 transition-all duration-300">
                            Konsultasi Gratis
                        </a>
                        <a href="{{ route('contact') }}" 
                           class="bg-transparent border-2 border-green-700 text-green-700 px-6 py-3 rounded-lg font-semibold hover:bg-green-700 hover:text-white transition-all duration-300">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Project Info -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Proyek</h3>
                    <div class="space-y-3">
                        @if($portfolio->client_name)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Klien:</span>
                                <span class="font-medium text-gray-800">{{ $portfolio->client_name }}</span>
                            </div>
                        @endif
                        @if($portfolio->location)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Lokasi:</span>
                                <span class="font-medium text-gray-800">{{ $portfolio->location }}</span>
                            </div>
                        @endif
                        @if($portfolio->completion_date)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Selesai:</span>
                                <span class="font-medium text-gray-800">{{ $portfolio->completion_date->format('M Y') }}</span>
                            </div>
                        @endif
                        @if($portfolio->project_value)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nilai:</span>
                                <span class="font-medium text-gray-800">{{ $portfolio->formatted_project_value }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kategori:</span>
                            <span class="font-medium text-gray-800">{{ $portfolio->category_name }}</span>
                        </div>
                    </div>
                </div>

                <!-- Share -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Bagikan</h3>
                    <div class="flex space-x-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                           target="_blank"
                           class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($portfolio->title) }}" 
                           target="_blank"
                           class="bg-blue-400 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($portfolio->title . ' - ' . request()->fullUrl()) }}" 
                           target="_blank"
                           class="bg-green-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-green-700 transition-colors">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Projects -->
@if($relatedPortfolios->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-12">Proyek Serupa</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedPortfolios as $related)
                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative overflow-hidden h-48">
                        @if($related->image_path)
                            <img src="{{ asset('storage/' . $related->image_path) }}" 
                                 alt="{{ $related->title }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-40 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $related->title }}</h3>
                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($related->description, 80) }}</p>
                        @if($related->location)
                            <p class="text-gray-500 text-xs mb-3">
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $related->location }}
                            </p>
                        @endif
                        <a href="{{ route('portfolio.detail', $related) }}" 
                           class="text-green-700 font-medium hover:text-green-800 transition-colors duration-300 inline-flex items-center">
                            Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('portfolio') }}" 
               class="inline-block bg-transparent border-2 border-green-700 text-green-700 px-8 py-3 rounded-full font-semibold hover:bg-green-700 hover:text-white transition-all duration-300">
                Lihat Semua Portfolio
            </a>
        </div>
    </div>
</section>
@endif
@endsection
