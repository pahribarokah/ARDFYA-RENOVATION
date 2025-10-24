@extends('layouts.main')

@section('title', $service->name . ' - Layanan')

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
                <li class="text-gray-600">{{ $service->name }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Service Detail -->
<section class="py-16 md:py-24">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Service Image -->
            <div>
                @if($service->image_path)
                    <div class="rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ asset('storage/' . $service->image_path) }}" 
                             alt="{{ $service->name }}" 
                             class="w-full h-96 object-cover">
                    </div>
                @else
                    <div class="bg-gray-200 rounded-xl h-96 flex items-center justify-center">
                        <div class="text-center">
                            @if($service->icon)
                                <i class="{{ $service->icon }} text-gray-400 text-6xl mb-4"></i>
                            @endif
                            <p class="text-gray-500">{{ $service->name }}</p>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Service Info -->
            <div>
                <div class="flex items-center mb-4">
                    @if($service->icon)
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <i class="{{ $service->icon }} text-green-600 text-2xl"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800">{{ $service->name }}</h1>
                        @if($service->category)
                            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium mt-2">
                                {{ $service->category }}
                            </span>
                        @endif
                    </div>
                </div>
                
                @if($service->price_range)
                    <div class="mb-6">
                        <span class="text-lg text-gray-600">Kisaran Harga:</span>
                        <span class="text-2xl font-bold text-green-600 ml-2">{{ $service->price_range }}</span>
                    </div>
                @endif
                
                <div class="prose prose-lg max-w-none mb-8">
                    <p class="text-gray-700 leading-relaxed">{{ $service->description }}</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('services.inquire', $service) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold text-center transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>Buat Inquiry
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="border border-green-600 text-green-600 hover:bg-green-600 hover:text-white px-8 py-3 rounded-lg font-semibold text-center transition-colors">
                        <i class="fas fa-phone mr-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Service Features -->
        <div class="bg-gray-50 rounded-xl p-8 mb-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Yang Anda Dapatkan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="flex items-start">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4 mt-1">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Konsultasi Gratis</h3>
                        <p class="text-gray-600 text-sm">Diskusi kebutuhan dan perencanaan tanpa biaya</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4 mt-1">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Estimasi Akurat</h3>
                        <p class="text-gray-600 text-sm">Perhitungan biaya yang detail dan transparan</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4 mt-1">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Tim Profesional</h3>
                        <p class="text-gray-600 text-sm">Dikerjakan oleh tenaga ahli berpengalaman</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4 mt-1">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Material Berkualitas</h3>
                        <p class="text-gray-600 text-sm">Menggunakan bahan terbaik sesuai standar</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4 mt-1">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Garansi Pekerjaan</h3>
                        <p class="text-gray-600 text-sm">Jaminan kualitas untuk hasil yang memuaskan</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4 mt-1">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Progress Monitoring</h3>
                        <p class="text-gray-600 text-sm">Pemantauan berkala dan laporan kemajuan</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Projects -->
        @if(isset($relatedProjects) && $relatedProjects->count() > 0)
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Proyek Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedProjects as $project)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                            @if($project->image_path)
                                <div class="h-48 bg-gray-200">
                                    <img src="{{ asset('storage/' . $project->image_path) }}" 
                                         alt="{{ $project->title }}" 
                                         class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="font-semibold text-gray-800 mb-2">{{ $project->title }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($project->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-green-600 font-medium">{{ $project->status }}</span>
                                    <span class="text-sm text-gray-500">{{ $project->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Other Services -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Layanan Lainnya</h2>
            <div class="text-center">
                <a href="/#layanan"
                   class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-th-large mr-2"></i>Lihat Semua Layanan
                </a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 md:py-24 bg-green-700 text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Tertarik dengan {{ $service->name }}?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">
            Konsultasikan kebutuhan Anda dengan tim ahli kami. Dapatkan estimasi dan penawaran terbaik!
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('services.inquire', $service) }}" 
               class="bg-white text-green-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Buat Inquiry Sekarang
            </a>
            <a href="{{ route('contact') }}" 
               class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-700 transition-colors">
                Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection
