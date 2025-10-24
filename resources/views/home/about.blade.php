@extends('layouts.main')

@section('title', 'Tentang Kami - ARDFYA')

@section('content')
<!-- Hero Section -->
<section class="bg-cover bg-center py-20 md:py-32 text-white" style="background-image: linear-gradient(rgba(0, 77, 64, 0.8), rgba(0, 77, 64, 0.8)), url('https://img.freepik.com/free-photo/team-young-specialist-engineers-working-construction-project_1303-28764.jpg');">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight tracking-tight">Tentang ARDFYA</h1>
        <p class="text-xl max-w-2xl mx-auto opacity-90">Mitra terpercaya untuk mewujudkan rumah impian Anda dengan kualitas dan desain yang terbaik.</p>
    </div>
</section>

<!-- Company Profile -->
<section class="py-16 md:py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-green-700 mb-6 tracking-tight">Siapa Kami</h2>
                <p class="text-gray-700 mb-6 leading-relaxed">ARDFYA didirikan pada tahun 2018 dengan visi menjadi perusahaan terdepan dalam industri renovasi dan perbaikan rumah di Indonesia. Kami memulai perjalanan kami dengan tim kecil yang berdedikasi dan tumbuh menjadi perusahaan yang dipercaya oleh ribuan pelanggan.</p>
                <p class="text-gray-700 mb-6 leading-relaxed">Dalam perjalanan kami selama 5+ tahun, ARDFYA telah menyelesaikan lebih dari 200 proyek renovasi dan perbaikan rumah dengan berbagai skala dan kompleksitas. Setiap proyek kami kerjakan dengan penuh dedikasi, ketelitian, dan mengutamakan kepuasan pelanggan.</p>
                <p class="text-gray-700 leading-relaxed">Kami percaya bahwa rumah bukan hanya tempat tinggal, tetapi juga tempat di mana kenangan dibuat dan mimpi terwujud. Itulah mengapa kami berkomitmen untuk memberikan layanan terbaik yang membantu mewujudkan rumah impian Anda.</p>
            </div>
            <div class="relative">
                <img src="https://img.freepik.com/free-photo/architect-working-interior-design-architectural-project_23-2149860896.jpg" alt="Tim ARDFYA" class="rounded-xl shadow-xl w-full">
                <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-green-700 rounded-xl hidden md:block"></div>
            </div>
        </div>
    </div>
</section>

<!-- Mission and Values -->
<section class="py-16 md:py-24 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-14">
            <h2 class="text-3xl md:text-4xl font-bold text-green-700 mb-4 tracking-tight">Misi & Nilai Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Prinsip-prinsip yang selalu kami pegang dalam setiap proyek yang kami kerjakan.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-16 mb-16">
            <div class="flex flex-col">
                <div class="text-green-700 font-semibold mb-2 text-lg">Misi Kami</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Memberikan Solusi Rumah Terbaik</h3>
                <p class="text-gray-600 mb-4">Misi kami adalah memberikan layanan renovasi dan perbaikan rumah berkualitas tinggi yang memenuhi kebutuhan dan melebihi harapan pelanggan kami.</p>
                <p class="text-gray-600">Kami berkomitmen untuk terus berinovasi dan meningkatkan kemampuan kami demi menciptakan ruang hidup yang fungsional, indah, dan berkelanjutan untuk setiap keluarga.</p>
            </div>
            
            <div class="flex flex-col">
                <div class="text-green-700 font-semibold mb-2 text-lg">Visi Kami</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Menjadi Perusahaan Terdepan</h3>
                <p class="text-gray-600 mb-4">Visi kami adalah menjadi perusahaan renovasi dan perbaikan rumah terkemuka di Indonesia yang dikenal karena kualitas, integritas, dan inovasi.</p>
                <p class="text-gray-600">Kami ingin menjadi mitra terpercaya bagi setiap keluarga yang ingin mewujudkan rumah impian mereka.</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="bg-green-100 w-16 h-16 flex items-center justify-center rounded-full text-green-700 mb-6">
                    <i class="fas fa-award text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-4">Kualitas</h4>
                <p class="text-gray-600">Kami tidak pernah berkompromi dalam hal kualitas, baik dalam pemilihan material maupun pelaksanaan pekerjaan.</p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="bg-green-100 w-16 h-16 flex items-center justify-center rounded-full text-green-700 mb-6">
                    <i class="fas fa-handshake text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-4">Integritas</h4>
                <p class="text-gray-600">Kejujuran dan transparansi adalah landasan dari setiap hubungan dengan pelanggan dan mitra kerja kami.</p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="bg-green-100 w-16 h-16 flex items-center justify-center rounded-full text-green-700 mb-6">
                    <i class="fas fa-lightbulb text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-4">Inovasi</h4>
                <p class="text-gray-600">Kami selalu berusaha menghadirkan solusi terbaik dan paling inovatif untuk setiap tantangan renovasi.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16 md:py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-14">
            <h2 class="text-3xl md:text-4xl font-bold text-green-700 mb-4 tracking-tight">Tim Profesional Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">ARDFYA didukung oleh tim ahli yang berpengalaman dan berdedikasi untuk memberikan hasil terbaik.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Team Member 1 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 text-center group">
                <div class="relative overflow-hidden">
                    <img src="https://i.pinimg.com/736x/71/62/85/7162859e8ef40d2f17e820972f06a4b9.jpg" alt="Ahmad Rizky" class="w-full h-80 object-cover object-center group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                        <div class="flex space-x-4">
                            <a href="#" class="text-white hover:text-green-400 transition-colors duration-300">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="text-white hover:text-green-400 transition-colors duration-300">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-white hover:text-green-400 transition-colors duration-300">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="py-6 px-4">
                    <h4 class="text-xl font-bold text-gray-800 mb-1">Ahmad Rizky</h4>
                    <p class="text-green-700 font-medium mb-2">Direktur Utama</p>
                    <p class="text-sm text-gray-600">Berpengalaman lebih dari 15 tahun dalam industri konstruksi dan renovasi.</p>
                </div>
            </div>
            
            <!-- Team Member 2 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 text-center group">
                <div class="relative overflow-hidden">
                    <img src="https://i.pinimg.com/736x/9d/c6/91/9dc691dc174fd95a852c184a3a6a19b9.jpg" alt="Dewi Farida" class="w-full h-80 object-cover object-center group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                        <div class="flex space-x-4">
                            <a href="#" class="text-white hover:text-green-400 transition-colors duration-300">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="text-white hover:text-green-400 transition-colors duration-300">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-white hover:text-green-400 transition-colors duration-300">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="py-6 px-4">
                    <h4 class="text-xl font-bold text-gray-800 mb-1">Yanto Saptoni</h4>
                    <p class="text-green-700 font-medium mb-2">Kepala Desainer</p>
                    <p class="text-sm text-gray-600">Desainer interior berpengalaman dengan keahlian dalam menciptakan ruang yang indah dan fungsional.</p>
                </div>
            </div>
            
            <!-- Team Member 3 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 text-center group">
                <div class="relative overflow-hidden">
                    <img src="https://i.pinimg.com/736x/ac/72/e7/ac72e73e60d112e1ff56b6393e69b79d.jpg" alt="Budi Santoso" class="w-full h-80 object-cover object-center group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                        <div class="flex space-x-4">
                            <a href="#" class="text-white hover:text-green-400 transition-colors duration-300">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="text-white hover:text-green-400 transition-colors duration-300">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-white hover:text-green-400 transition-colors duration-300">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="py-6 px-4">
                    <h4 class="text-xl font-bold text-gray-800 mb-1">Budi Santoso</h4>
                    <p class="text-green-700 font-medium mb-2">Manajer Proyek</p>
                    <p class="text-sm text-gray-600">Ahli dalam mengelola proyek renovasi dengan efisien, tepat waktu, dan sesuai anggaran.</p>
                </div>
            </div>
            
            <!-- Team Member 4 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 text-center group">
                <div class="relative overflow-hidden">
                    <img src="https://i.pinimg.com/736x/05/34/bb/0534bb7a30d800ab6962a90934464ef8.jpg" alt="Arya Wibowo" class="w-full h-80 object-cover object-center group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                        <div class="flex space-x-4">
                            <a href="#" class="text-white hover:text-green-400 transition-colors duration-300">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="text-white hover:text-green-400 transition-colors duration-300">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-white hover:text-green-400 transition-colors duration-300">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="py-6 px-4">
                    <h4 class="text-xl font-bold text-gray-800 mb-1">Arya Wibowo</h4>
                    <p class="text-green-700 font-medium mb-2">Arsitek</p>
                    <p class="text-sm text-gray-600">Arsitek berpengalaman dengan spesialisasi dalam mendesain rumah tinggal dan ruang komersial.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 md:py-20 bg-green-700 text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6 leading-tight tracking-tight">Siap Wujudkan Rumah Impian Anda?</h2>
        <p class="text-lg max-w-2xl mx-auto mb-10 opacity-90">Hubungi kami sekarang untuk konsultasi gratis dan dapatkan penawaran terbaik untuk kebutuhan renovasi rumah Anda.</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('contact') }}" class="bg-white text-green-700 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-all duration-300 ease-in-out transform hover:scale-105">Hubungi Kami</a>
            <a href="{{ route('inquiries.create') }}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-green-700 transition-all duration-300 ease-in-out transform hover:scale-105">Konsultasi Gratis</a>
        </div>
    </div>
</section>
@endsection 