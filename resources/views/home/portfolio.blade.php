@extends('layouts.main')

@section('title', 'Portofolio Proyek - ARDFYA')

@section('content')
<!-- Enhanced Hero Section -->
<section class="relative bg-cover bg-center h-screen flex items-center justify-center text-center text-white overflow-hidden" style="background-image: linear-gradient(135deg, rgba(21, 128, 61, 0.75), rgba(22, 101, 52, 0.75)), url('https://img.freepik.com/free-photo/luxury-pool-villa-spectacular-contemporary-design-digital-art-real-estate-home-house-property-genera_1258-150763.jpg'); background-attachment: fixed; background-size: cover; background-position: center;">
    <!-- Modern Overlay Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-green-900/20 via-transparent to-green-800/30"></div>
    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);"></div>

    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-white/20 rounded-full animate-ping"></div>
        <div class="absolute top-3/4 right-1/4 w-1 h-1 bg-yellow-300/30 rounded-full animate-pulse"></div>
        <div class="absolute top-1/2 right-1/3 w-3 h-3 bg-white/10 rounded-full animate-bounce"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-5xl mx-auto">
            <!-- Main Heading -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-black mb-6 leading-tight tracking-tight animate-fade-in-up" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                Portofolio <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-300">Proyek</span><br>
                <span class="text-green-300">ARDFYA</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-lg md:text-xl lg:text-2xl mb-10 max-w-4xl mx-auto opacity-95 animate-fade-in-up delay-400 leading-relaxed" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
                Berbagai proyek yang telah kami kerjakan dengan hasil yang memuaskan dan kepuasan klien yang tinggi
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in-up delay-600">
                <a href="#portofolio" class="group relative overflow-hidden bg-white text-green-700 px-8 py-4 rounded-full text-lg font-bold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-3xl">
                    <span class="relative z-10 flex items-center">
                        <i class="fas fa-images mr-2 group-hover:rotate-12 transition-transform duration-500"></i>
                        Lihat Portofolio
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-green-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                </a>
                <a href="{{ route('inquiries.create') }}" class="group relative overflow-hidden border-2 border-white text-white px-8 py-4 rounded-full text-lg font-bold hover:bg-white hover:text-green-700 transition-all duration-300 transform hover:scale-105 backdrop-blur-sm">
                    <span class="relative z-10 flex items-center">
                        <i class="fas fa-phone mr-2 group-hover:animate-bounce"></i>
                        Konsultasi Gratis
                    </span>
                </a>
            </div>
        </div>
    </div>

    <!-- Enhanced Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <a href="#portofolio" class="flex flex-col items-center text-white/70 hover:text-white transition-colors group">
            <span class="text-xs mb-2 opacity-0 group-hover:opacity-100 transition-opacity">Scroll untuk melihat portofolio</span>
            <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-white/70 rounded-full mt-2 animate-pulse"></div>
            </div>
        </a>
    </div>
</section>

<!-- Enhanced Portfolio Categories -->
<section class="py-20 md:py-24 lg:py-28 bg-gradient-to-br from-gray-50 via-white to-green-50/30">
    <div class="container mx-auto px-6">


        <!-- Enhanced Category Filters -->
        <div class="flex flex-wrap justify-center gap-4 mb-20 mt-8 animate-fade-in-up delay-600">
            <button class="category-btn active group relative overflow-hidden px-8 py-3 rounded-full bg-gradient-to-r from-green-600 to-green-700 text-white font-bold hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl" data-category="all">
                <span class="relative z-10">Semua</span>
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
            </button>
            @foreach($categories as $category)
                @php
                    $categoryNames = \App\Models\Portfolio::getCategories();
                    $categoryName = $categoryNames[$category] ?? ucfirst($category);
                @endphp
                <button class="category-btn group relative overflow-hidden px-8 py-3 rounded-full bg-white border-2 border-gray-200 text-gray-700 font-bold hover:border-green-500 hover:text-green-700 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg" data-category="{{ $category }}">
                    <span class="relative z-10">{{ $categoryName }}</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-50 to-green-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </button>
            @endforeach
        </div>
        
        <!-- Enhanced Portfolio Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10" id="portfolio-grid">
            @forelse($portfolios as $index => $portfolio)
                <div class="portfolio-item group relative bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden animate-fade-in-up"
                     data-category="{{ $portfolio->category }}"
                     style="animation-delay: {{ ($index * 0.1) + 0.8 }}s">

                    <!-- Card Background Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 via-transparent to-blue-50/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                    <!-- Image Container -->
                    <div class="relative overflow-hidden rounded-t-3xl h-64">
                        @if($portfolio->image_path)
                            <img src="{{ asset('storage/' . $portfolio->image_path) }}"
                                 alt="{{ $portfolio->title }}"
                                 class="w-full h-full object-cover object-center transform group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-200 via-gray-300 to-gray-400 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-700">
                                <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif

                        <!-- Always Visible Bottom Gradient for Description -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

                        <!-- Enhanced Hover Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                        <!-- Enhanced Preview Button -->
                        <a href="#portfolioModal{{ $portfolio->id }}"
                           class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 transform scale-75 group-hover:scale-100 z-10"
                           onclick="openProjectModal('portfolioModal{{ $portfolio->id }}')">
                            <div class="bg-white/90 backdrop-blur-sm text-green-700 rounded-full w-16 h-16 flex items-center justify-center shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110">
                                <i class="fas fa-search-plus text-xl"></i>
                            </div>
                        </a>

                        <!-- Category Badge -->
                        @php
                            $badgeColors = [
                                'renovasi' => 'bg-green-500',
                                'pembangunan' => 'bg-blue-500',
                                'interior' => 'bg-purple-500',
                                'eksterior' => 'bg-orange-500',
                                'landscape' => 'bg-green-500',
                                'komersial' => 'bg-gray-500',
                                'residensial' => 'bg-indigo-500'
                            ];
                            $badgeColor = $badgeColors[$portfolio->category] ?? 'bg-gray-500';
                        @endphp
                        <div class="absolute top-4 right-4 {{ $badgeColor }} text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg z-10">
                            {{ $portfolio->category_name }}
                        </div>

                        <!-- Description Overlay - Always Visible -->
                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white z-10">
                            <h3 class="text-lg font-bold mb-2 leading-tight">{{ $portfolio->title }}</h3>
                            <p class="text-sm text-gray-200 leading-relaxed line-clamp-2">
                                {{ Str::limit($portfolio->description, 80) }}
                            </p>
                            @if($portfolio->location)
                                <p class="text-xs text-gray-300 mt-2 flex items-center">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ $portfolio->location }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-6">
                        <!-- Title and Category Badge -->
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-semibold text-gray-800 leading-tight">{{ $portfolio->title }}</h3>
                            @php
                                $badgeColors = [
                                    'renovasi' => 'bg-green-100 text-green-700',
                                    'pembangunan' => 'bg-blue-100 text-blue-700',
                                    'interior' => 'bg-purple-100 text-purple-700',
                                    'eksterior' => 'bg-orange-100 text-orange-700',
                                    'landscape' => 'bg-green-100 text-green-700',
                                    'komersial' => 'bg-gray-100 text-gray-700',
                                    'residensial' => 'bg-indigo-100 text-indigo-700'
                                ];
                                $badgeColor = $badgeColors[$portfolio->category] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="badge text-xs px-3 py-1 {{ $badgeColor }} rounded-full font-medium flex-shrink-0 ml-2">{{ $portfolio->category_name }}</span>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ Str::limit($portfolio->description, 100) }}
                            </p>
                        </div>

                        <!-- Location -->
                        @if($portfolio->location)
                            <div class="mb-4">
                                <p class="text-gray-500 text-xs flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>
                                    <span>{{ $portfolio->location }}</span>
                                </p>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <a href="{{ route('portfolio.detail', $portfolio) }}" class="text-green-700 font-medium hover:text-green-800 transition-colors duration-300 inline-flex items-center text-sm">
                                <span>Lihat Detail</span>
                                <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                            <a href="#portfolioModal{{ $portfolio->id }}" class="text-gray-400 hover:text-green-700 transition-colors duration-300 p-2 rounded-full hover:bg-green-50" onclick="openProjectModal('portfolioModal{{ $portfolio->id }}')" title="Preview">
                                <i class="fas fa-search-plus text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Portfolio</h3>
                    <p class="text-gray-500">Portfolio akan ditampilkan di sini setelah ditambahkan oleh admin.</p>
                </div>
            @endforelse
        </div>

        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 md:py-20 bg-green-700 text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6 leading-tight tracking-tight">Ingin Mewujudkan Proyek Anda Berikutnya?</h2>
        <p class="text-lg max-w-2xl mx-auto mb-10 opacity-90">Konsultasikan kebutuhan renovasi atau perbaikan rumah Anda dengan tim profesional kami sekarang.</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('contact') }}" class="bg-white text-green-700 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-all duration-300 ease-in-out transform hover:scale-105">Hubungi Kami</a>
            <a href="{{ route('inquiries.create') }}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-green-700 transition-all duration-300 ease-in-out transform hover:scale-105">Konsultasi Gratis</a>
        </div>
    </div>
</section>

<!-- Portfolio Modal Templates -->
@foreach($portfolios as $portfolio)
<div id="portfolioModal{{ $portfolio->id }}" class="fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center hidden">
    <div class="bg-white w-full max-w-5xl rounded-xl p-6 max-h-[90vh] overflow-y-auto relative">
        <button onclick="closeProjectModal('portfolioModal{{ $portfolio->id }}')" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 transition-colors duration-300 text-2xl">
            <i class="fas fa-times"></i>
        </button>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-4">
                @if($portfolio->image_path)
                    <img src="{{ asset('storage/' . $portfolio->image_path) }}" alt="{{ $portfolio->title }}" class="w-full h-auto rounded-lg">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $portfolio->title }}</h3>

                <div class="mb-6">
                    <div class="flex flex-wrap gap-2 mb-4">
                        @php
                            $badgeColors = [
                                'renovasi' => 'bg-green-100 text-green-700',
                                'pembangunan' => 'bg-blue-100 text-blue-700',
                                'interior' => 'bg-purple-100 text-purple-700',
                                'eksterior' => 'bg-orange-100 text-orange-700',
                                'landscape' => 'bg-green-100 text-green-700',
                                'komersial' => 'bg-gray-100 text-gray-700',
                                'residensial' => 'bg-indigo-100 text-indigo-700'
                            ];
                            $badgeColor = $badgeColors[$portfolio->category] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="badge text-xs px-2 py-1 {{ $badgeColor }} rounded-full">{{ $portfolio->category_name }}</span>
                        @if($portfolio->completion_date)
                            <span class="badge text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded-full">{{ $portfolio->completion_date->format('Y') }}</span>
                        @endif
                        @if($portfolio->location)
                            <span class="badge text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">{{ $portfolio->location }}</span>
                        @endif
                    </div>

                    <p class="text-gray-700 mb-4">{{ $portfolio->description }}</p>
                </div>

                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Detail Proyek</h4>
                    <div class="space-y-2 text-gray-700">
                        @if($portfolio->client_name)
                            <div class="flex items-start">
                                <i class="fas fa-user text-green-600 mt-1 mr-2"></i>
                                <span><strong>Klien:</strong> {{ $portfolio->client_name }}</span>
                            </div>
                        @endif
                        @if($portfolio->location)
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-green-600 mt-1 mr-2"></i>
                                <span><strong>Lokasi:</strong> {{ $portfolio->location }}</span>
                            </div>
                        @endif
                        @if($portfolio->completion_date)
                            <div class="flex items-start">
                                <i class="fas fa-calendar-check text-green-600 mt-1 mr-2"></i>
                                <span><strong>Tanggal Selesai:</strong> {{ $portfolio->completion_date->format('d M Y') }}</span>
                            </div>
                        @endif
                        @if($portfolio->project_value)
                            <div class="flex items-start">
                                <i class="fas fa-money-bill-wave text-green-600 mt-1 mr-2"></i>
                                <span><strong>Nilai Proyek:</strong> {{ $portfolio->formatted_project_value }}</span>
                            </div>
                        @endif
                        <div class="flex items-start">
                            <i class="fas fa-tag text-green-600 mt-1 mr-2"></i>
                            <span><strong>Kategori:</strong> {{ $portfolio->category_name }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('portfolio.detail', $portfolio) }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all duration-300">Lihat Detail Lengkap</a>
                    <a href="{{ route('inquiries.create') }}" class="inline-block bg-green-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-800 transition-all duration-300">Konsultasikan Proyek Anda</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('styles')
<style>
    /* Portfolio Grid Layout - Force proper grid behavior */
    #portfolio-grid {
        display: grid !important;
        grid-template-columns: 1fr;
        gap: 2rem;
        width: 100%;
        /* Debug border */
        /* border: 2px solid red; */
    }

    /* Responsive grid adjustments */
    @media (min-width: 768px) {
        #portfolio-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 2rem;
        }
    }

    @media (min-width: 1024px) {
        #portfolio-grid {
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 2.5rem;
        }
    }

    /* Ensure portfolio items maintain proper layout */
    .portfolio-item {
        display: block !important;
        width: 100%;
        max-width: none;
        margin: 0;
        /* Debug border */
        /* border: 1px solid blue; */
    }

    /* Fix for hidden items to not affect grid layout */
    .portfolio-item[style*="display: none"] {
        display: none !important;
    }

    /* Override any conflicting Tailwind classes */
    .grid.grid-cols-1.md\:grid-cols-2.lg\:grid-cols-3 {
        display: grid !important;
    }

    /* Animation improvements */
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
        transform: translateY(30px);
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Ensure proper card sizing */
    .portfolio-item > div {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .portfolio-item .p-6 {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Force grid layout on container */
    .container .grid {
        display: grid !important;
    }

    /* Line clamp utility for description */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.4;
        max-height: 2.8em; /* 2 lines * 1.4 line-height */
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.5;
        max-height: 4.5em; /* 3 lines * 1.5 line-height */
        min-height: 3rem; /* Ensure minimum height for consistency */
    }

    /* Ensure description is visible */
    .portfolio-item .text-gray-700 {
        color: #374151 !important;
        font-size: 0.875rem !important;
        line-height: 1.5 !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    /* Enhanced card styling */
    .portfolio-item .bg-white {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .portfolio-item:hover .bg-white {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: #d1d5db;
    }

    /* Badge styling improvements */
    .badge {
        font-weight: 500;
        letter-spacing: 0.025em;
    }

    /* Description text styling */
    .portfolio-item p {
        color: #4b5563;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    /* Action button styling */
    .portfolio-item a[href*="portfolio.detail"] {
        font-size: 0.875rem;
        font-weight: 600;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const categoryButtons = document.querySelectorAll('.category-btn');
        const portfolioItems = document.querySelectorAll('.portfolio-item');
        
        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                categoryButtons.forEach(btn => {
                    btn.classList.remove('active', 'bg-green-700', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });
                
                // Add active class to clicked button
                this.classList.add('active', 'bg-green-700', 'text-white');
                this.classList.remove('bg-gray-200', 'text-gray-700');
                
                const selectedCategory = this.getAttribute('data-category');
                
                // Show/hide items based on category
                portfolioItems.forEach(item => {
                    if (selectedCategory === 'all' || item.getAttribute('data-category') === selectedCategory) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
    
    function openProjectModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeProjectModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection 