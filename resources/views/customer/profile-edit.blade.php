@extends('layouts.customer')

@section('title', 'Edit Profil')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Edit Profil</h1>
            <p class="text-gray-600 mt-2">Perbarui informasi profil Anda</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('customer.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}"
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-green focus:border-brand-green @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}"
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-green focus:border-brand-green @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @if(!$user->email_verified_at)
                        <p class="text-yellow-600 text-sm mt-1">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Email belum terverifikasi
                        </p>
                    @endif
                </div>

                <!-- Phone -->
                <div class="mb-6">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon
                    </label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone', $user->phone) }}"
                           placeholder="Contoh: 08123456789"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-green focus:border-brand-green @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">
                        Nomor telepon akan digunakan untuk komunikasi terkait proyek
                    </p>
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat
                    </label>
                    <textarea id="address" 
                              name="address" 
                              rows="3"
                              placeholder="Masukkan alamat lengkap Anda"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-green focus:border-brand-green @error('address') border-red-500 @enderror">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">
                        Alamat akan digunakan untuk keperluan proyek dan pengiriman dokumen
                    </p>
                </div>

                <!-- Account Info (Read Only) -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Informasi Akun</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Role:</span>
                            <span class="font-medium ml-2">{{ ucfirst($user->role) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Bergabung:</span>
                            <span class="font-medium ml-2">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Terakhir Update:</span>
                            <span class="font-medium ml-2">{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Status Email:</span>
                            @if($user->email_verified_at)
                                <span class="text-green-600 font-medium ml-2">
                                    <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                                </span>
                            @else
                                <span class="text-red-600 font-medium ml-2">
                                    <i class="fas fa-times-circle mr-1"></i>Belum Terverifikasi
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('customer.profile') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('customer.profile.password') }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors text-sm">
                            <i class="fas fa-key mr-2"></i>
                            Ubah Password
                        </a>
                        
                        <button type="submit" 
                                class="bg-brand-green hover:bg-brand-green-dark text-white px-6 py-2 rounded-md transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Security Notice -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-shield-alt text-yellow-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Keamanan Data</h3>
                    <p class="text-sm text-yellow-700 mt-1">
                        Informasi pribadi Anda akan dijaga kerahasiaannya dan hanya digunakan untuk keperluan layanan kami. 
                        Jika Anda mengubah email, pastikan untuk memverifikasi email baru Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
