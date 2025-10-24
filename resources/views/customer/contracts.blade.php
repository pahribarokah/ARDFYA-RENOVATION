@extends('layouts.customer')

@section('title', 'Kontrak Saya')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Kontrak Saya</h1>
        <p class="text-gray-600 mt-2">Kelola dan unduh dokumen kontrak Anda</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    @if($contracts->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($contracts as $contract)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <!-- Contract Header -->
                    <div class="bg-gradient-to-r from-brand-green to-green-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-white">
                                    {{ $contract->project->name ?? 'Kontrak #' . $contract->id }}
                                </h3>
                                <p class="text-green-100 text-sm">
                                    {{ $contract->project->service->name ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @switch($contract->contract_status)
                                        @case('draft') bg-gray-100 text-gray-800 @break
                                        @case('active') bg-green-100 text-green-800 @break
                                        @case('completed') bg-blue-100 text-blue-800 @break
                                        @case('terminated') bg-red-100 text-red-800 @break
                                        @default bg-gray-100 text-gray-800
                                    @endswitch">
                                    @switch($contract->contract_status)
                                        @case('draft') Draft @break
                                        @case('active') Aktif @break
                                        @case('completed') Selesai @break
                                        @case('terminated') Dihentikan @break
                                        @default {{ ucfirst($contract->contract_status) }}
                                    @endswitch
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Contract Details -->
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Contract Value -->
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Nilai Kontrak:</span>
                                <span class="text-xl font-bold text-brand-green">
                                    Rp {{ number_format($contract->amount, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Contract Period -->
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Mulai:</span>
                                    <div class="font-medium">{{ $contract->start_date->format('d M Y') }}</div>
                                </div>
                                <div>
                                    <span class="text-gray-600">Berakhir:</span>
                                    <div class="font-medium">
                                        {{ $contract->end_date ? $contract->end_date->format('d M Y') : 'Belum ditentukan' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Contract Number -->
                            @if($contract->contract_number)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Nomor Kontrak:</span>
                                    <span class="font-mono bg-gray-100 px-2 py-1 rounded">
                                        {{ $contract->contract_number }}
                                    </span>
                                </div>
                            @endif

                            <!-- Installments -->
                            @if($contract->installments && $contract->installments > 1)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Cicilan:</span>
                                    <span class="font-medium">{{ $contract->installments }}x pembayaran</span>
                                </div>
                            @endif

                            <!-- Notes -->
                            @if($contract->notes)
                                <div class="text-sm">
                                    <span class="text-gray-600">Catatan:</span>
                                    <p class="mt-1 text-gray-800">{{ Str::limit($contract->notes, 100) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Contract Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t">
                        <div class="flex items-center justify-between">
                            <div class="text-xs text-gray-500">
                                Dibuat: {{ $contract->created_at->format('d M Y') }}
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('customer.contracts.download', $contract) }}"
                                   class="bg-brand-green hover:bg-brand-green-dark text-white px-4 py-2 rounded text-sm transition-colors inline-flex items-center">
                                    <i class="fas fa-download mr-2"></i>
                                    Download Kontrak (PDF)
                                </a>
                                
                                @if($contract->project)
                                    <a href="{{ route('customer.projects.detail', $contract->project) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm transition-colors inline-flex items-center">
                                        <i class="fas fa-project-diagram mr-2"></i>
                                        Lihat Proyek
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $contracts->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <div class="mb-4">
                    <i class="fas fa-file-contract text-6xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-700 mb-2">Belum Ada Kontrak</h3>
                <p class="text-gray-500 mb-6">Anda belum memiliki kontrak. Kontrak akan dibuat setelah inquiry Anda disetujui dan menjadi proyek.</p>
                <a href="{{ route('inquiries.create') }}" 
                   class="bg-brand-green hover:bg-brand-green-dark text-white px-6 py-3 rounded-lg inline-flex items-center transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Inquiry Baru
                </a>
            </div>
        </div>
    @endif

    <!-- Info Box -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Informasi Kontrak</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>Draft:</strong> Kontrak sedang dalam tahap penyusunan</li>
                        <li><strong>Aktif:</strong> Kontrak telah ditandatangani dan berlaku</li>
                        <li><strong>Selesai:</strong> Kontrak telah selesai dilaksanakan</li>
                        <li><strong>Dihentikan:</strong> Kontrak dihentikan sebelum selesai</li>
                    </ul>
                    <p class="mt-2">
                        <strong>Catatan:</strong> Kontrak akan otomatis di-generate dalam format PDF yang profesional dengan template resmi perusahaan. Anda dapat mengunduh kontrak kapan saja setelah kontrak dibuat.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
