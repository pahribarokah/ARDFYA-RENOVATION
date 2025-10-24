@extends('layouts.customer')

@section('title', 'Profil Saya')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Profil Saya</h1>
            <p class="text-gray-600 mt-2">Kelola informasi profil dan pengaturan akun Anda</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Info -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Informasi Profil</h2>
                        <a href="{{ route('customer.profile.edit') }}" 
                           class="bg-brand-green hover:bg-brand-green-dark text-white px-4 py-2 rounded text-sm transition-colors">
                            <i class="fas fa-edit mr-2"></i>Edit Profil
                        </a>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                            <p class="text-gray-800 font-medium">{{ $user->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600">Email</label>
                            <p class="text-gray-800">{{ $user->email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600">Nomor Telepon</label>
                            <p class="text-gray-800">{{ $user->phone ?? 'Belum diisi' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600">Alamat</label>
                            <p class="text-gray-800">{{ $user->address ?? 'Belum diisi' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600">Bergabung Sejak</label>
                            <p class="text-gray-800">{{ $user->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Keamanan Akun</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 border rounded-lg">
                            <div>
                                <h3 class="font-medium text-gray-800">Password</h3>
                                <p class="text-sm text-gray-600">Terakhir diubah: {{ $user->updated_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('customer.profile.password') }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm transition-colors">
                                Ubah Password
                            </a>
                        </div>

                        <div class="flex items-center justify-between p-4 border rounded-lg">
                            <div>
                                <h3 class="font-medium text-gray-800">Email Verification</h3>
                                <p class="text-sm text-gray-600">
                                    @if($user->email_verified_at)
                                        <span class="text-green-600">✓ Email terverifikasi</span>
                                    @else
                                        <span class="text-red-600">✗ Email belum terverifikasi</span>
                                    @endif
                                </p>
                            </div>
                            @if(!$user->email_verified_at)
                                <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm transition-colors">
                                    Kirim Verifikasi
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="space-y-6">
                <!-- Profile Summary -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Akun</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Total Proyek</span>
                            <span class="font-medium text-blue-600">{{ Auth::user()->projects()->count() }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Total Inquiry</span>
                            <span class="font-medium text-yellow-600">{{ Auth::user()->inquiries()->count() }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Total Kontrak</span>
                            <span class="font-medium text-green-600">{{ Auth::user()->contracts()->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('customer.dashboard') }}" 
                           class="block w-full bg-brand-green hover:bg-brand-green-dark text-white text-center py-2 rounded transition-colors">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        
                        <a href="{{ route('customer.projects') }}" 
                           class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded transition-colors">
                            <i class="fas fa-project-diagram mr-2"></i>Proyek Saya
                        </a>
                        
                        <a href="{{ route('messages.customer') }}" 
                           class="block w-full bg-purple-500 hover:bg-purple-600 text-white text-center py-2 rounded transition-colors">
                            <i class="fas fa-comments mr-2"></i>Chat Admin
                        </a>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Akun</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-600">Akun Aktif</span>
                        </div>
                        
                        @if($user->email_verified_at)
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Email Terverifikasi</span>
                            </div>
                        @else
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Email Belum Terverifikasi</span>
                            </div>
                        @endif
                        
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-600">Customer Regular</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
