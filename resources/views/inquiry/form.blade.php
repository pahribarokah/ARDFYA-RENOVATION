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
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-gray-50 p-8 md:p-12 rounded-xl shadow-lg">
                <form action="{{ route('inquiries.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    @if(isset($selectedService))
                        <input type="hidden" name="service_id" value="{{ $selectedService->id }}">
                    @else
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Layanan</label>
                            <select name="service_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="">Pilih Layanan</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" required 
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                   placeholder="Nama Anda">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required 
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                   placeholder="email@example.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="tel"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   required
                                   pattern="[0-9+\-\s()]+"
                                   minlength="10"
                                   maxlength="15"
                                   oninput="validatePhoneInput(this)"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                   placeholder="08xxxxxxxxxx">
                            <small class="text-gray-500 text-xs">Hanya boleh berisi angka, +, -, spasi, dan tanda kurung</small>
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Properti</label>
                            <select name="property_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="Rumah">Rumah</option>
                                <option value="Apartemen">Apartemen</option>
                                <option value="Ruko">Ruko</option>
                                <option value="Kantor">Kantor</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('property_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="address" required rows="2" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                placeholder="Alamat lengkap properti">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Luas Area (m²)</label>
                            <input type="number" name="area_size" value="{{ old('area_size') }}" min="1" 
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                   placeholder="Contoh: 50">
                            @error('area_size')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Budget (Rp)</label>
                            <input type="number" name="budget" value="{{ old('budget') }}" 
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                   placeholder="Contoh: 10000000" max="9999999999.99">
                            @error('budget')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kebutuhan</label>
                        <textarea name="description" required rows="4" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                placeholder="Jelaskan kebutuhan renovasi atau perbaikan Anda">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center mt-3">
                            <input type="checkbox" name="terms" required class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <label class="ml-2 block text-sm text-gray-700">Saya menyetujui penggunaan data untuk keperluan konsultasi</label>
                        </div>
                        @error('terms')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-right pt-2">
                        <button type="submit" class="bg-green-700 text-white px-8 py-2.5 rounded-lg font-semibold hover:bg-green-800 transition-all duration-300 ease-in-out transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim...';
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            const result = await response.json();
            
            if (response.ok) {
                // Tampilkan alert success
                alert('Permintaan layanan berhasil dikirim!');
                // Redirect ke home
                window.location.replace('/'); // atau gunakan route name
                // window.location.replace("{{ route('home') }}");
            } else {
                throw new Error(result.message || 'Terjadi kesalahan pada server');
            }

        } catch (error) {
            console.error('Error:', error);
            alert(error.message || 'Terjadi kesalahan. Silakan coba lagi.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Kirim Permintaan';
        }
    });

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
});
</script>
@endsection