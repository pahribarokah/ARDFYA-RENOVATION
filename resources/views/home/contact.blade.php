@extends('layouts.main')

@section('title', 'Hubungi Kami - ARDFYA')

@section('content')
<!-- Hero Section -->
<section class="bg-cover bg-center py-20 md:py-32 text-white" style="background-image: linear-gradient(rgba(0, 77, 64, 0.8), rgba(0, 77, 64, 0.8)), url('https://img.freepik.com/free-photo/customer-service-operator-business-woman-suit-with-headset-working_1301-6800.jpg');">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight tracking-tight">Hubungi Kami</h1>
        <p class="text-xl max-w-2xl mx-auto opacity-90">Kami siap membantu mewujudkan rumah impian Anda. Hubungi kami untuk konsultasi atau pertanyaan.</p>
    </div>
</section>

<!-- Contact Form and Info -->
<section class="py-16 md:py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">
            <!-- Contact Form -->
            <div class="lg:col-span-3 bg-gray-50 p-8 rounded-xl shadow-lg">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Kirim Pesan</h2>
                
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif
                
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Nama Anda">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="email@example.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="08xxxxxxxxxx">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Subjek pesan Anda">
                        @error('subject')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                        <textarea id="message" name="message" rows="5" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Tulis pesan Anda disini...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="text-right">
                        <button type="submit" class="bg-green-700 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-800 transition-all duration-300 ease-in-out transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Contact Info -->
            <div class="lg:col-span-2">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Informasi Kontak</h2>
                
                <div class="space-y-8">
                    <div class="flex items-start">
                        <div class="bg-green-100 p-3 rounded-lg text-green-700 mr-4">
                            <i class="fas fa-map-marker-alt text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Alamat Kantor</h3>
                            <p class="text-gray-600">Jl. Contoh No. 123, Kemang<br>Jakarta Selatan, 12730<br>Indonesia</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-green-100 p-3 rounded-lg text-green-700 mr-4">
                            <i class="fas fa-phone-alt text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Telepon</h3>
                            <p class="text-gray-600">+62 123 4567 890</p>
                            <p class="text-gray-600">+62 098 7654 321</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-green-100 p-3 rounded-lg text-green-700 mr-4">
                            <i class="fas fa-envelope text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Email</h3>
                            <p class="text-gray-600">info@ardfya.com</p>
                            <p class="text-gray-600">support@ardfya.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-green-100 p-3 rounded-lg text-green-700 mr-4">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Jam Kerja</h3>
                            <p class="text-gray-600">Senin - Jumat: 09:00 - 17:00</p>
                            <p class="text-gray-600">Sabtu: 09:00 - 14:00</p>
                            <p class="text-gray-600">Minggu: Tutup</p>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Ikuti Kami</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-green-700 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-green-800 transition-colors duration-300">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="bg-green-700 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-green-800 transition-colors duration-300">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="bg-green-700 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-green-800 transition-colors duration-300">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="bg-green-700 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-green-800 transition-colors duration-300">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-8 md:py-12 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Lokasi Kami</h2>
            <p class="text-gray-600 max-w-xl mx-auto">Kunjungi showroom kami untuk melihat berbagai contoh desain dan konsultasi langsung dengan tim kami.</p>
        </div>
        
        <div class="rounded-xl overflow-hidden shadow-lg h-96">
            <!-- Replace with your Google Maps iframe -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253840.65294559383!2d106.6894283225357!3d-6.229386704898533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta%2C%20Indonesia!5e0!3m2!1sen!2sid!4v1699089614903!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 md:py-20 bg-green-700 text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6 leading-tight tracking-tight">Butuh Konsultasi Langsung?</h2>
        <p class="text-lg max-w-2xl mx-auto mb-10 opacity-90">Jika Anda memiliki pertanyaan spesifik atau ingin konsultasi tentang proyek renovasi, tim kami siap membantu.</p>
        <a href="{{ route('inquiries.create') }}" class="bg-white text-green-700 px-10 py-4 rounded-full text-lg font-semibold hover:bg-gray-100 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg inline-flex items-center">
            <i class="fas fa-calendar-check mr-2"></i> Jadwalkan Konsultasi Gratis
        </a>
    </div>
</section>
@endsection 