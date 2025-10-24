@extends('layouts.main')

@section('title', 'Konsultasi Layanan - ARDFYA')

@section('content')
<!-- Hero Section -->
<section class="bg-cover bg-center py-20 md:py-32 text-white" style="background-image: linear-gradient(rgba(0, 77, 64, 0.8), rgba(0, 77, 64, 0.8)), url('https://img.freepik.com/free-photo/home-renovation-construction-concept-with-tools_23-2148838560.jpg');">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight tracking-tight">Konsultasi Layanan</h1>
        <p class="text-xl max-w-2xl mx-auto opacity-90">Sampaikan kebutuhan renovasi atau perbaikan rumah Anda, dan kami akan memberikan solusi terbaik.</p>
    </div>
</section>

<!-- Inquiry Form -->
<section class="py-16 md:py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-10 flex items-center">
                <i class="fas fa-check-circle text-xl mr-3"></i>
                <div>
                    <h4 class="font-semibold mb-1">Permintaan Berhasil Dikirim!</h4>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="bg-gray-50 p-8 md:p-12 rounded-xl shadow-lg">
                <form action="{{ route('inquiries.store') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    @if(isset($selectedService))
                        <input type="hidden" name="service_id" value="{{ $selectedService->id }}">
                        <div class="mb-4 bg-green-50 p-4 rounded-lg border border-green-200 flex items-start">
                            <i class="fas fa-info-circle text-green-600 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-green-800 mb-1">Layanan yang Dipilih: {{ $selectedService->name }}</h4>
                                <p class="text-sm text-green-700">{{ Str::limit($selectedService->description, 150) }}</p>
                            </div>
                        </div>
                    @else
                        <div class="space-y-4">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Pilih Layanan</h2>
                            <div>
                                <label for="service_id" class="block text-sm font-medium text-gray-700 mb-1">Jenis Layanan</label>
                                <select id="service_id" name="service_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                                    <option value="">Pilih Layanan</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <hr class="border-gray-200">
                    @endif
                    
                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Pribadi</h2>
                        
                        @guest
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Nama Lengkap Anda">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="email@example.com">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 mb-4">
                                <p class="text-blue-700">Anda login sebagai: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})</p>
                            </div>
                        @endguest
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="tel"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   required
                                   pattern="[0-9+\-\s()]+"
                                   minlength="10"
                                   maxlength="15"
                                   oninput="validatePhoneInput(this)"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                   placeholder="08xxxxxxxxxx">
                            <small class="text-gray-500 text-xs">Hanya boleh berisi angka, +, -, spasi, dan tanda kurung</small>
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <hr class="border-gray-200">
                    
                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Properti</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="property_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Properti</label>
                                <select id="property_type" name="property_type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                                    <option value="">Pilih Tipe Properti</option>
                                    <option value="Rumah" {{ old('property_type') == 'Rumah' ? 'selected' : '' }}>Rumah</option>
                                    <option value="Apartemen" {{ old('property_type') == 'Apartemen' ? 'selected' : '' }}>Apartemen</option>
                                    <option value="Ruko" {{ old('property_type') == 'Ruko' ? 'selected' : '' }}>Ruko</option>
                                    <option value="Kantor" {{ old('property_type') == 'Kantor' ? 'selected' : '' }}>Kantor</option>
                                    <option value="Lainnya" {{ old('property_type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('property_type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="area_size" class="block text-sm font-medium text-gray-700 mb-1">Luas Area (m²)</label>
                                <input type="number" id="area_size" name="area_size" value="{{ old('area_size') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Contoh: 50">
                                @error('area_size')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Properti</label>
                            <textarea id="address" name="address" rows="2" required class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Alamat lengkap properti">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="budget" class="block text-sm font-medium text-gray-700 mb-1">Estimasi Budget (Rp)</label>
                            <input type="number" id="budget" name="budget" value="{{ old('budget') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Contoh: 10000000">
                            <p class="text-gray-500 text-xs mt-1">*Opsional. Masukkan estimasi budget Anda untuk membantu kami memberikan penawaran yang sesuai.</p>
                            @error('budget')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <hr class="border-gray-200">
                    
                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Deskripsi Kebutuhan</h2>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Jelaskan kebutuhan Anda secara detail</label>
                            <textarea id="description" name="description" rows="5" required class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" placeholder="Jelaskan apa yang ingin Anda lakukan dengan properti Anda, kebutuhan spesifik, dan harapan Anda.">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mt-2">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox" required class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="text-gray-700">Saya setuju bahwa data yang diberikan akan digunakan untuk keperluan konsultasi dan penawaran</label>
                                </div>
                            </div>
                            @error('terms')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-6">
                        <button type="submit" class="bg-green-700 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-800 transition-all duration-300 ease-in-out transform hover:scale-105 flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Permintaan
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="mt-12 text-center">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Sudah Mengirim Permintaan?</h3>
                <p class="text-gray-600 max-w-2xl mx-auto mb-6">Anda dapat melihat status permintaan Anda di akun Anda. Jika Anda memiliki pertanyaan lain, jangan ragu untuk menghubungi kami.</p>
                <div class="flex flex-wrap gap-4 justify-center">
                    @guest
                        <a href="{{ route('login') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                        </a>
                    @else
                        @if(Auth::user()->role === 'customer')
                            <a href="{{ route('customer.profile') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg inline-flex items-center">
                                <i class="fas fa-user mr-2"></i> Lihat Profil
                            </a>
                        @else
                            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg inline-flex items-center">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                        @endif
                    @endguest
                    <a href="{{ route('contact') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg inline-flex items-center">
                        <i class="fas fa-phone-alt mr-2"></i> Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-16 md:py-24 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Apa Kata Pelanggan Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Lihat pengalaman pelanggan yang telah menggunakan layanan kami untuk renovasi dan perbaikan rumah mereka.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="text-green-500 mr-1">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-gray-600 text-sm ml-1">5.0</span>
                </div>
                <p class="text-gray-700 mb-6 italic">"ARDFYA benar-benar mengubah tampilan rumah saya. Proses renovasi berjalan lancar dan hasilnya melebihi ekspektasi. Tim yang profesional dan komunikatif sepanjang proyek."</p>
                <div class="flex items-center">
                    <img src="https://img.freepik.com/free-photo/portrait-cheerful-businessman-outdoors_23-2147892036.jpg" alt="Ahmad Hakim" class="w-12 h-12 rounded-full object-cover mr-4">
                    <div>
                        <h4 class="font-semibold text-gray-800">Ahmad Hakim</h4>
                        <p class="text-gray-600 text-sm">Jakarta Selatan</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="text-green-500 mr-1">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="text-gray-600 text-sm ml-1">4.5</span>
                </div>
                <p class="text-gray-700 mb-6 italic">"Sangat puas dengan layanan dari ARDFYA. Mereka membantu merenovasi dapur saya dengan desain yang modern dan fungsional. Harga yang diberikan juga sangat kompetitif."</p>
                <div class="flex items-center">
                    <img src="https://img.freepik.com/free-photo/young-beautiful-woman-smiling-posing-wall_176420-6468.jpg" alt="Dewi Putri" class="w-12 h-12 rounded-full object-cover mr-4">
                    <div>
                        <h4 class="font-semibold text-gray-800">Dewi Putri</h4>
                        <p class="text-gray-600 text-sm">Tangerang</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="text-green-500 mr-1">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-gray-600 text-sm ml-1">5.0</span>
                </div>
                <p class="text-gray-700 mb-6 italic">"Terima kasih ARDFYA! Apartemen saya menjadi lebih luas dan nyaman berkat desain interior yang mereka buat. Tim yang sangat ramah dan memahami kebutuhan klien dengan baik."</p>
                <div class="flex items-center">
                    <img src="https://img.freepik.com/free-photo/cheerful-young-man-posing-studio_23-2148213756.jpg" alt="Budi Santoso" class="w-12 h-12 rounded-full object-cover mr-4">
                    <div>
                        <h4 class="font-semibold text-gray-800">Budi Santoso</h4>
                        <p class="text-gray-600 text-sm">Jakarta Barat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Phone number validation function
function validatePhoneInput(input) {
    // Remove any non-allowed characters
    let value = input.value;
    let cleanValue = value.replace(/[^0-9+\-\s()]/g, '');

    // Update input value if it was cleaned
    if (value !== cleanValue) {
        input.value = cleanValue;

        // Show error message
        let errorMsg = input.parentNode.querySelector('.phone-error');
        if (!errorMsg) {
            errorMsg = document.createElement('p');
            errorMsg.className = 'text-red-500 text-xs mt-1 phone-error';
            input.parentNode.appendChild(errorMsg);
        }
        errorMsg.textContent = 'Karakter tidak valid dihapus. Hanya boleh angka, +, -, spasi, dan tanda kurung.';

        // Remove error message after 3 seconds
        setTimeout(() => {
            if (errorMsg) {
                errorMsg.remove();
            }
        }, 3000);
    }

    // Validate length
    if (cleanValue.length < 10 && cleanValue.length > 0) {
        input.setCustomValidity('Nomor telepon minimal 10 digit');
    } else if (cleanValue.length > 15) {
        input.setCustomValidity('Nomor telepon maksimal 15 digit');
    } else {
        input.setCustomValidity('');
    }
}
</script>
@endsection