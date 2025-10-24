@extends('layouts.main')

@section('title', 'ARDFYA - Solusi Renovasi dan Perbaikan Rumah Anda')

@section('content')
<section id="beranda" class="relative bg-cover bg-center h-screen flex items-center justify-center text-center text-white overflow-hidden" style="background-image: linear-gradient(135deg, rgba(21, 128, 61, 0.75), rgba(22, 101, 52, 0.75)), url('https://img.freepik.com/free-photo/beautiful-luxury-outdoor-swimming-pool-hotel-resort_74190-7433.jpg'); background-attachment: fixed; background-size: cover; background-position: center;">
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
                <h1 class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-black mb-6 leading-tight tracking-tight animate-fade-in-up delay-200" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                    Wujudkan Rumah <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-300">Impian</span><br>
                    Anda Bersama <span class="text-green-300">ARDFYA</span>
                </h1>

                <!-- Subtitle -->
                <p class="text-lg md:text-xl lg:text-2xl mb-10 max-w-4xl mx-auto opacity-95 animate-fade-in-up delay-400 leading-relaxed" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
                    Solusi renovasi dan perbaikan rumah terpercaya dengan kualitas terbaik, desain yang menawan, dan harga yang kompetitif.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in-up delay-600">
                    <a href="#layanan" class="group relative overflow-hidden bg-white text-green-700 px-8 py-4 rounded-full text-lg font-bold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-3xl">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-rocket mr-2 group-hover:animate-bounce"></i>
                            Pelajari Lebih Lanjut
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-green-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                    </a>

                </div>


            </div>
        </div>

        <!-- Enhanced Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#layanan" class="flex flex-col items-center text-white/70 hover:text-white transition-colors group">
                <span class="text-xs mb-2 opacity-0 group-hover:opacity-100 transition-opacity">Scroll untuk melihat layanan</span>
                <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
                    <div class="w-1 h-3 bg-white/70 rounded-full mt-2 animate-pulse"></div>
                </div>
            </a>
        </div>
</section>

<section id="layanan" class="section-padding bg-gradient-to-br from-gray-50 via-white to-green-50/30">
        <div class="container mx-auto px-6">
                <!-- Enhanced Header -->
                <div class="text-center mb-20">
                    <div class="inline-flex items-center px-4 py-2 bg-green-100 rounded-full text-green-700 font-semibold mb-6 animate-fade-in-up">
                        <i class="fas fa-tools mr-2"></i>
                        Layanan Profesional
                    </div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-gray-800 mb-6 animate-fade-in-up delay-200">
                        Layanan <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-green-800">Terbaik</span> Kami
                    </h2>
                    <div class="w-32 h-1.5 bg-gradient-to-r from-green-600 via-green-500 to-green-700 mx-auto mb-8 rounded-full animate-fade-in-up delay-300"></div>
                    <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed animate-fade-in-up delay-400">
                        Kami menyediakan berbagai layanan renovasi dan perbaikan rumah dengan kualitas terbaik, teknologi modern, dan harga yang kompetitif
                    </p>
                </div>

                <!-- Enhanced Service Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                        @foreach($services as $index => $service)
                        <div class="group relative bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden cursor-pointer animate-fade-in-up text-center"
                             style="animation-delay: {{ ($index * 0.1) + 0.6 }}s"
                             onclick="openServiceModal('{{ $service->id }}', '{{ $service->name }}')">

                            <!-- Card Background Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 via-transparent to-blue-50/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                            <!-- Content -->
                            <div class="relative p-8">
                                <!-- Icon Container -->
                                <div class="relative mb-8">
                                    <div class="w-24 h-24 bg-gradient-to-br from-green-100 via-green-200 to-green-300 rounded-2xl flex items-center justify-center mx-auto group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 shadow-lg group-hover:shadow-xl">
                                        <i class="{{ $service->icon }} text-4xl text-green-700 group-hover:scale-110 transition-transform duration-300"></i>
                                    </div>
                                    <!-- Floating Elements -->
                                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-gradient-to-br from-yellow-200 to-yellow-300 rounded-full opacity-0 group-hover:opacity-70 transition-all duration-700 transform scale-0 group-hover:scale-100"></div>
                                    <div class="absolute -bottom-1 -left-1 w-4 h-4 bg-gradient-to-br from-blue-200 to-blue-300 rounded-full opacity-0 group-hover:opacity-50 transition-all duration-500 transform scale-0 group-hover:scale-100"></div>
                                </div>

                                <!-- Service Name -->
                                <h3 class="text-2xl font-bold mb-4 text-gray-800 group-hover:text-green-700 transition-colors duration-300">
                                    {{ $service->name }}
                                </h3>

                                <!-- Description -->
                                <p class="text-gray-600 text-base leading-relaxed mb-8">
                                    {{ Str::limit($service->description, 120) }}
                                </p>

                                <!-- Action Button -->
                                <div class="inline-flex items-center text-green-600 font-bold text-base group-hover:text-green-700 transition-all duration-300 bg-green-50 px-6 py-3 rounded-full group-hover:bg-green-100 group-hover:shadow-lg">
                                    <span class="mr-2">Pelajari Lebih Lanjut</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform duration-300"></i>
                                </div>

                                <!-- Decorative Elements -->
                                <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-gradient-to-br from-green-100 to-green-200 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-500 transform scale-0 group-hover:scale-100"></div>
                                <div class="absolute -top-4 -left-4 w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full opacity-0 group-hover:opacity-15 transition-opacity duration-700 transform scale-0 group-hover:scale-100"></div>
                            </div>
                        </div>
                        @endforeach
                </div>




                </div>
        </div>
</section>

@include('components.how-it-works')

<section id="tentang-kami" class="py-20 md:py-28 bg-gradient-to-br from-gray-50 via-white to-green-50/20">
        <div class="container mx-auto px-6">
                <!-- Enhanced Header -->
                <div class="text-center mb-20">
                    <div class="inline-flex items-center px-6 py-3 bg-green-100 rounded-full text-green-700 font-semibold mb-8 text-lg">
                        <i class="fas fa-users mr-3 text-xl"></i>
                        Tentang Perusahaan
                    </div>
                    <h2 class="text-5xl md:text-6xl font-bold text-gray-800 mb-8 tracking-tight">
                        Tentang <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-green-800">Kami</span>
                    </h2>
                    <div class="w-40 h-2 bg-gradient-to-r from-green-600 via-green-500 to-green-700 mx-auto mb-10 rounded-full"></div>
                </div>

                <div class="flex flex-wrap items-center -mx-4 max-w-7xl mx-auto">
                        <!-- Image Section -->
                        <div class="w-full lg:w-1/2 px-6 mb-16 lg:mb-0">
                                <div class="relative group">
                                    <div class="absolute inset-0 bg-gradient-to-br from-green-200 to-green-300 rounded-3xl transform rotate-3 group-hover:rotate-6 transition-transform duration-500 opacity-20"></div>
                                    <img src="https://img.freepik.com/free-photo/construction-workers-sunset_53876-138180.jpg" alt="Tim Profesional ARDFYA" class="relative rounded-3xl shadow-2xl mx-auto w-full h-96 object-cover group-hover:shadow-3xl transition-all duration-500 transform group-hover:scale-105">
                                </div>
                        </div>

                        <!-- Content Section -->
                        <div class="w-full lg:w-1/2 lg:pl-20 px-6">
                                <div class="max-w-2xl">
                                    <p class="text-2xl text-gray-700 mb-10 leading-relaxed">ARDFYA adalah perusahaan yang bergerak di bidang jasa renovasi dan perbaikan rumah dengan pengalaman lebih dari 5 tahun. Kami didukung oleh tim profesional yang ahli di bidangnya.</p>

                                    <div class="space-y-8">
                                            <div class="flex items-start group">
                                                    <div class="text-green-700 mr-8 mt-2 flex-shrink-0 bg-green-50 rounded-full p-4 group-hover:bg-green-100 transition-colors duration-300">
                                                        <i class="fas fa-medal text-2xl"></i>
                                                    </div>
                                                    <div>
                                                            <h4 class="font-bold text-gray-800 mb-3 text-xl group-hover:text-green-700 transition-colors duration-300">Kualitas Terjamin</h4>
                                                            <p class="text-gray-600 leading-relaxed text-lg">Kami memberikan jaminan kualitas untuk setiap proyek yang kami kerjakan dengan standar tinggi.</p>
                                                    </div>
                                            </div>
                                            <div class="flex items-start group">
                                                    <div class="text-blue-700 mr-8 mt-2 flex-shrink-0 bg-blue-50 rounded-full p-4 group-hover:bg-blue-100 transition-colors duration-300">
                                                        <i class="fas fa-users text-2xl"></i>
                                                    </div>
                                                    <div>
                                                            <h4 class="font-bold text-gray-800 mb-3 text-xl group-hover:text-blue-700 transition-colors duration-300">Tim Profesional</h4>
                                                            <p class="text-gray-600 leading-relaxed text-lg">Tim kami terdiri dari ahli desain dan tukang berpengalaman dengan sertifikasi profesional.</p>
                                                    </div>
                                            </div>
                                            <div class="flex items-start group">
                                                    <div class="text-purple-700 mr-8 mt-2 flex-shrink-0 bg-purple-50 rounded-full p-4 group-hover:bg-purple-100 transition-colors duration-300">
                                                        <i class="fas fa-tag text-2xl"></i>
                                                    </div>
                                                    <div>
                                                            <h4 class="font-bold text-gray-800 mb-3 text-xl group-hover:text-purple-700 transition-colors duration-300">Harga Kompetitif</h4>
                                                            <p class="text-gray-600 leading-relaxed text-lg">Kami menawarkan harga yang transparan dan kompetitif dengan kualitas yang tidak mengecewakan.</p>
                                                    </div>
                                            </div>
                                    </div>

                                    <div class="mt-12">
                                        <a href="{{ route('about') }}" class="group relative overflow-hidden bg-gradient-to-r from-green-600 to-green-700 text-white px-12 py-5 rounded-2xl text-xl font-bold hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl inline-flex items-center">
                                            <span class="relative z-10 flex items-center">
                                                <i class="fas fa-info-circle mr-4 text-xl group-hover:rotate-12 transition-transform duration-300"></i>
                                                Selengkapnya
                                                <i class="fas fa-arrow-right ml-4 text-xl group-hover:translate-x-2 transition-transform duration-300"></i>
                                            </span>
                                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                                        </a>
                                    </div>
                                </div>
                        </div>
                </div>
        </div>
</section>

@include('components.why-choose-us')

<section id="portofolio" class="py-20 md:py-28 bg-gradient-to-br from-gray-50 via-white to-green-50/20">
        <div class="container mx-auto px-6">
                <!-- Enhanced Header -->
                <div class="text-center mb-24">
                    <div class="inline-flex items-center px-6 py-3 bg-green-100 rounded-full text-green-700 font-semibold mb-8 text-lg">
                        <i class="fas fa-images mr-3 text-xl"></i>
                        Karya Terbaik Kami
                    </div>
                    <h2 class="text-5xl md:text-6xl font-bold text-gray-800 mb-8 tracking-tight">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-green-800">Portofolio</span> Kami
                    </h2>
                    <div class="w-40 h-2 bg-gradient-to-r from-green-600 via-green-500 to-green-700 mx-auto mb-10 rounded-full"></div>
                    <p class="text-2xl text-gray-600 max-w-4xl mx-auto leading-relaxed">Beberapa hasil pekerjaan yang telah kami selesaikan dengan kualitas terbaik dan kepuasan pelanggan</p>
                </div>

                <!-- Enhanced Portfolio Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:gap-16">
                        @forelse($featuredPortfolios as $portfolio)
                        <div class="group relative bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-3">
                                <!-- Background Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 via-transparent to-blue-50/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                                <!-- Image Container -->
                                <div class="relative overflow-hidden rounded-t-3xl">
                                    @if($portfolio->image_path)
                                        <img src="{{ asset('storage/' . $portfolio->image_path) }}" alt="{{ $portfolio->title }}" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-80 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Category Badge -->
                                    @if($portfolio->category)
                                        <div class="absolute top-6 left-6">
                                            <span class="inline-block bg-white/90 backdrop-blur-sm text-green-800 text-sm px-4 py-2 rounded-full font-semibold shadow-lg">
                                                {{ ucfirst($portfolio->category) }}
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Overlay Gradient -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                </div>

                                <!-- Content -->
                                <div class="relative p-10">
                                        <h3 class="text-2xl font-bold mb-4 text-gray-800 group-hover:text-green-700 transition-colors duration-300">{{ $portfolio->title }}</h3>
                                        <p class="text-gray-600 mb-8 leading-relaxed text-lg">{{ Str::limit($portfolio->description, 100) }}</p>

                                        <!-- Project Details -->
                                        <div class="space-y-4 mb-8">
                                            @if($portfolio->location)
                                                <div class="flex items-center text-gray-500 text-base">
                                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-4 group-hover:bg-green-100 transition-colors duration-300">
                                                        <i class="fas fa-map-marker-alt text-sm"></i>
                                                    </div>
                                                    <span>{{ $portfolio->location }}</span>
                                                </div>
                                            @endif

                                            @if($portfolio->completion_date)
                                                <div class="flex items-center text-gray-500 text-base">
                                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-4 group-hover:bg-blue-100 transition-colors duration-300">
                                                        <i class="fas fa-calendar text-sm"></i>
                                                    </div>
                                                    <span>{{ $portfolio->completion_date->format('M Y') }}</span>
                                                </div>
                                            @endif

                                            @if($portfolio->project_value)
                                                <div class="flex items-center text-green-700 text-base font-semibold">
                                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4 group-hover:bg-green-200 transition-colors duration-300">
                                                        <i class="fas fa-tag text-sm"></i>
                                                    </div>
                                                    <span>Rp {{ number_format($portfolio->project_value, 0, ',', '.') }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Action Area -->
                                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                                            <a href="{{ route('portfolio.detail', $portfolio) }}" class="group/btn inline-flex items-center text-green-700 font-semibold hover:text-green-800 transition-all duration-300 text-lg">
                                                <span class="mr-3">Lihat Detail</span>
                                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center group-hover/btn:bg-green-200 group-hover/btn:scale-110 transition-all duration-300">
                                                    <i class="fas fa-arrow-right text-sm group-hover/btn:translate-x-0.5 transition-transform duration-300"></i>
                                                </div>
                                            </a>

                                            @if($portfolio->client_name)
                                                <div class="text-right">
                                                    <div class="text-sm text-gray-400 mb-1">Client</div>
                                                    <div class="text-base font-medium text-gray-600">{{ $portfolio->client_name }}</div>
                                                </div>
                                            @endif
                                        </div>
                                </div>

                                <!-- Decorative Elements -->
                                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-green-100 to-green-200 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-500 transform scale-0 group-hover:scale-100"></div>
                                <div class="absolute -top-6 -left-6 w-20 h-20 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full opacity-0 group-hover:opacity-15 transition-opacity duration-700 transform scale-0 group-hover:scale-100"></div>
                        </div>
                        @empty
                        <!-- Fallback static portfolios if no featured portfolios exist -->
                        <div class="group relative bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-3">
                                <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 via-transparent to-blue-50/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative overflow-hidden rounded-t-3xl">
                                    <img src="https://img.freepik.com/free-photo/modern-residential-district-with-green-roof-balcony-generated-by-ai_188544-10276.jpg" alt="Renovasi Rumah Minimalis" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute top-6 left-6">
                                        <span class="inline-block bg-white/90 backdrop-blur-sm text-green-800 text-sm px-4 py-2 rounded-full font-semibold shadow-lg">Renovasi</span>
                                    </div>
                                </div>
                                <div class="relative p-10">
                                        <h3 class="text-2xl font-bold mb-4 text-gray-800 group-hover:text-green-700 transition-colors duration-300">Renovasi Rumah</h3>
                                        <p class="text-gray-600 mb-8 leading-relaxed text-lg">Renovasi total interior rumah dengan konsep minimalis modern yang elegan dan fungsional.</p>
                                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                                            <a href="{{ route('portfolio') }}" class="group/btn inline-flex items-center text-green-700 font-semibold hover:text-green-800 transition-all duration-300 text-lg">
                                                <span class="mr-3">Lihat Detail</span>
                                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center group-hover/btn:bg-green-200 group-hover/btn:scale-110 transition-all duration-300">
                                                    <i class="fas fa-arrow-right text-sm group-hover/btn:translate-x-0.5 transition-transform duration-300"></i>
                                                </div>
                                            </a>
                                        </div>
                                </div>
                                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-green-100 to-green-200 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-500 transform scale-0 group-hover:scale-100"></div>
                        </div>

                        <div class="group relative bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-3">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 via-transparent to-purple-50/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative overflow-hidden rounded-t-3xl">
                                    <img src="https://i.pinimg.com/736x/6c/89/6c/6c896c30adb5b975866b3de632a5c70d.jpg" alt="Desain Interior Apartemen" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute top-6 left-6">
                                        <span class="inline-block bg-white/90 backdrop-blur-sm text-blue-800 text-sm px-4 py-2 rounded-full font-semibold shadow-lg">Interior</span>
                                    </div>
                                </div>
                                <div class="relative p-10">
                                        <h3 class="text-2xl font-bold mb-4 text-gray-800 group-hover:text-blue-700 transition-colors duration-300">Desain Interior</h3>
                                        <p class="text-gray-600 mb-8 leading-relaxed text-lg">Desain dan implementasi interior untuk unit apartemen 2BR dengan sentuhan modern dan nyaman.</p>
                                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                                            <a href="{{ route('portfolio') }}" class="group/btn inline-flex items-center text-blue-700 font-semibold hover:text-blue-800 transition-all duration-300 text-lg">
                                                <span class="mr-3">Lihat Detail</span>
                                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center group-hover/btn:bg-blue-200 group-hover/btn:scale-110 transition-all duration-300">
                                                    <i class="fas fa-arrow-right text-sm group-hover/btn:translate-x-0.5 transition-transform duration-300"></i>
                                                </div>
                                            </a>
                                        </div>
                                </div>
                                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-500 transform scale-0 group-hover:scale-100"></div>
                        </div>

                        <div class="group relative bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-3">
                                <div class="absolute inset-0 bg-gradient-to-br from-orange-50/50 via-transparent to-red-50/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative overflow-hidden rounded-t-3xl">
                                    <img src="https://i.pinimg.com/736x/5a/6d/4e/5a6d4e48363397acb3356c522b3bcd63.jpg" alt="Perbaikan Atap dan Plafon" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute top-6 left-6">
                                        <span class="inline-block bg-white/90 backdrop-blur-sm text-orange-800 text-sm px-4 py-2 rounded-full font-semibold shadow-lg">Perbaikan</span>
                                    </div>
                                </div>
                                <div class="relative p-10">
                                        <h3 class="text-2xl font-bold mb-4 text-gray-800 group-hover:text-orange-700 transition-colors duration-300">Perbaikan Rumah</h3>
                                        <p class="text-gray-600 mb-8 leading-relaxed text-lg">Perbaikan kebocoran atap dan penggantian plafon yang rusak dengan material berkualitas tinggi.</p>
                                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                                            <a href="{{ route('portfolio') }}" class="group/btn inline-flex items-center text-orange-700 font-semibold hover:text-orange-800 transition-all duration-300 text-lg">
                                                <span class="mr-3">Lihat Detail</span>
                                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center group-hover/btn:bg-orange-200 group-hover/btn:scale-110 transition-all duration-300">
                                                    <i class="fas fa-arrow-right text-sm group-hover/btn:translate-x-0.5 transition-transform duration-300"></i>
                                                </div>
                                            </a>
                                        </div>
                                </div>
                                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-500 transform scale-0 group-hover:scale-100"></div>
                        </div>
                        @endforelse
                </div>

                <!-- Enhanced Call to Action -->
                <div class="text-center mt-24">
                    <div class="bg-white rounded-3xl shadow-xl p-12 max-w-4xl mx-auto">
                        <h3 class="text-3xl font-bold text-gray-800 mb-6">Lihat Lebih Banyak Proyek Kami</h3>
                        <p class="text-gray-600 mb-10 text-lg leading-relaxed">Jelajahi koleksi lengkap portfolio kami dan temukan inspirasi untuk proyek Anda</p>
                        <a href="{{ route('portfolio') }}" class="group relative overflow-hidden border-2 border-green-600 text-green-700 px-12 py-5 rounded-2xl text-xl font-bold hover:bg-green-600 hover:text-white transition-all duration-300 transform hover:scale-105 backdrop-blur-sm inline-flex items-center">
                            <span class="relative z-10 flex items-center">
                                <i class="fas fa-images mr-4 text-xl group-hover:rotate-12 transition-transform duration-300"></i>
                                Lihat Semua Proyek
                                <i class="fas fa-arrow-right ml-4 text-xl group-hover:translate-x-2 transition-transform duration-300"></i>
                            </span>
                        </a>
                    </div>
                </div>
        </div>
</section>

@include('components.testimonials')



<!-- Service Modal -->
@foreach($services as $service)
<div id="service-modal-{{ $service->id }}" class="modal-overlay fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-[100] opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="modal-content bg-white rounded-xl shadow-2xl w-full max-w-2xl p-6 md:p-8 transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $service->name }}</h3>
                        <button onclick="closeServiceModal('{{ $service->id }}')" class="text-gray-400 hover:text-red-500 transition-colors duration-200 focus:outline-none">
                                <i class="fas fa-times text-2xl"></i>
                        </button>
                </div>
                
                <div class="mb-6 prose max-w-none">
                        <p class="text-gray-700">{{ $service->description }}</p>
                </div>
                
                <h4 class="text-xl font-semibold text-gray-800 mb-5">Ajukan Permintaan Layanan Ini</h4>
                
                <form action="{{ route('inquiries.store') }}" method="POST" class="service-modal-form space-y-5">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4">
                                <div>
                                        <label for="name-{{ $service->id }}" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                        <input type="text" id="name-{{ $service->id }}" name="name" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Nama Anda">
                                </div>
                                <div>
                                        <label for="email-{{ $service->id }}" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" id="email-{{ $service->id }}" name="email" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="email@example.com">
                                </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4">
                                <div>
                                        <label for="phone-{{ $service->id }}" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                        <input type="tel" id="phone-{{ $service->id }}" name="phone" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="08xxxxxxxxxx">
                                </div>
                                <div>
                                        <label for="property_type-{{ $service->id }}" class="block text-sm font-medium text-gray-700 mb-1">Tipe Properti</label>
                                        <select id="property_type-{{ $service->id }}" name="property_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                                                <option value="Rumah">Rumah</option>
                                                <option value="Apartemen">Apartemen</option>
                                                <option value="Ruko">Ruko</option>
                                                <option value="Kantor">Kantor</option>
                                                <option value="Lainnya">Lainnya</option>
                                        </select>
                                </div>
                        </div>
                        
                        <div>
                                <label for="address-{{ $service->id }}" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                                <textarea id="address-{{ $service->id }}" name="address" required rows="2" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Alamat lengkap properti"></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4">
                                <div>
                                        <label for="area_size-{{ $service->id }}" class="block text-sm font-medium text-gray-700 mb-1">Luas Area (m²)</label>
                                        <input type="number" id="area_size-{{ $service->id }}" name="area_size" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Contoh: 50">
                                </div>
                                <div>
                                        <label for="budget-{{ $service->id }}" class="block text-sm font-medium text-gray-700 mb-1">Estimasi Budget (Rp)</label>
                                        <input type="number" id="budget-{{ $service->id }}" name="budget" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Contoh: 10000000">
                                </div>
                        </div>
                        
                        <div>
                                <label for="description-{{ $service->id }}" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kebutuhan</label>
                                <textarea id="description-{{ $service->id }}" name="description" required rows="4" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Jelaskan kebutuhan renovasi atau perbaikan Anda"></textarea>
                        </div>
                        
                        <div>
                                <div class="flex items-center mt-3">
                                        <input type="checkbox" id="terms-{{ $service->id }}" name="terms" required class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                        <label for="terms-{{ $service->id }}" class="ml-2 block text-sm text-gray-700">Saya menyetujui penggunaan data untuk keperluan konsultasi</label>
                                </div>
                        </div>
                        
                        <div class="text-right pt-2">
                                <button type="button" onclick="closeServiceModal('{{ $service->id }}')" class="px-6 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200 mr-2">Batal</button>
                                <button type="submit" class="bg-green-700 text-white px-8 py-2.5 rounded-lg font-semibold hover:bg-green-800 transition-all duration-300 ease-in-out transform hover:scale-105">Kirim Permintaan</button>
                        </div>
                </form>
        </div>
</div>
@endforeach

@endsection

@section('scripts')
<script>


        function openServiceModal(id) {
                const modal = document.getElementById('service-modal-' + id);
                if (modal) {
                        modal.classList.remove('opacity-0', 'pointer-events-none');
                        modal.classList.add('opacity-100');
                        modal.querySelector('.modal-content').classList.remove('scale-95');
                        modal.querySelector('.modal-content').classList.add('scale-100');
                        document.body.style.overflow = 'hidden';
                }
        }



        function createServiceCard(service) {
            const card = document.createElement('div');
            card.className = 'card service-card bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 ease-in-out transform hover:-translate-y-2 text-center cursor-pointer group';
            card.onclick = () => openServiceModal(service.id);

            card.innerHTML = `
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mx-auto group-hover:scale-110 transition-transform duration-300">
                        <i class="${service.icon || 'fas fa-cogs'} text-3xl text-green-700"></i>
                    </div>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 group-hover:text-green-700 transition-colors">${service.name}</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">${service.description.substring(0, 120)}...</p>
                <div class="inline-flex items-center text-green-600 font-medium text-sm group-hover:text-green-700 transition-colors">
                    Pelajari Lebih Lanjut <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </div>
            `;

            // Add modal for this service
            createServiceModal(service);

            return card;
        }

        function createServiceModal(service) {
            const modal = document.createElement('div');
            modal.id = `service-modal-${service.id}`;
            modal.className = 'modal-overlay fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-[100] opacity-0 pointer-events-none transition-opacity duration-300';

            modal.innerHTML = `
                <div class="modal-content bg-white rounded-xl shadow-2xl w-full max-w-2xl p-6 md:p-8 transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-gray-800">${service.name}</h3>
                        <button onclick="closeServiceModal('${service.id}')" class="text-gray-400 hover:text-red-500 transition-colors duration-200 focus:outline-none">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>

                    <div class="mb-6 prose max-w-none">
                        <p class="text-gray-700">${service.description}</p>
                    </div>

                    <div class="text-center">
                        <a href="/services/${service.id}/inquire" class="btn btn-primary px-8 py-3">
                            <i class="fas fa-paper-plane mr-2"></i>Buat Inquiry
                        </a>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);

            // Add event listeners
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeServiceModal(service.id);
                }
            });
        }
        
        function closeServiceModal(id) {
                const modal = document.getElementById('service-modal-' + id);
                if (modal) {
                        modal.classList.add('opacity-0');
                        modal.classList.remove('opacity-100');
                        modal.querySelector('.modal-content').classList.add('scale-95');
                        modal.querySelector('.modal-content').classList.remove('scale-100');
                        setTimeout(() => {
                                modal.classList.add('pointer-events-none');
                        }, 300); // Match transition duration
                        document.body.style.overflow = 'auto';
                }
        }
        
        // Update form submit handler
document.querySelectorAll('.service-modal-form').forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Mengirim...';
        
        const formData = new FormData(this);
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            const result = await response.json();
            
            if (response.ok) {
                alert(result.message);
                const modalId = this.querySelector('[name="service_id"]').value;
                closeServiceModal(modalId);
                this.reset();
            } else {
                throw new Error(result.message || 'Terjadi kesalahan pada server');
            }

        } catch (error) {
            console.error('Error:', error);
            alert(error.message || 'Terjadi kesalahan. Silakan coba lagi.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Kirim Permintaan';
        }
    });
});
        // Close modal when clicking outside content or pressing Escape
        document.addEventListener('DOMContentLoaded', function() {
                const modals = document.querySelectorAll('.modal-overlay');
                modals.forEach(modal => {
                        modal.addEventListener('click', function(e) {
                                if (e.target === modal) {
                                        const modalId = modal.id.replace('service-modal-', '');
                                        closeServiceModal(modalId);
                                }
                        });
                });

                document.addEventListener('keydown', function(e) {
                        if (e.key === "Escape") {
                                modals.forEach(modal => {
                                        if (!modal.classList.contains('pointer-events-none')) {
                                                const modalId = modal.id.replace('service-modal-', '');
                                                closeServiceModal(modalId);
                                        }
                                });
                        }
                });
        });
</script>

<style>
        .section-padding {
                padding-top: 5rem;
                padding-bottom: 5rem;
        }

        @media (min-width: 768px) {
                .section-padding {
                        padding-top: 7rem;
                        padding-bottom: 7rem;
                }
        }

        /* Enhanced Animations */
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-500 {
            animation-delay: 0.5s;
        }

        /* Enhanced Card Hover Effects */
        .card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Service Card Enhancements */
        .service-card {
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .service-card:hover::before {
            left: 100%;
        }

        /* Button Enhancements */
        .btn {
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }
</style>
@endsection 