@extends('layouts.customer')

@section('title', 'Inquiry Saya')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Permintaan Saya</h1>
        <p class="text-gray-600 mt-2">Kelola dan pantau status Permintaan Anda</p>
    </div>

    @if($inquiries->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Layanan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deskripsi
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Budget
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($inquiries as $inquiry)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-brand-green flex items-center justify-center">
                                                <i class="fas fa-cog text-white"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $inquiry->service->name ?? 'N/A' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                ID: #{{ $inquiry->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ Str::limit($inquiry->description, 80) }}
                                    </div>
                                    @if($inquiry->property_type)
                                        <div class="text-sm text-gray-500">
                                            {{ $inquiry->property_type }}
                                            @if($inquiry->area_size)
                                                • {{ $inquiry->area_size }} m²
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($inquiry->budget)
                                        Rp {{ number_format($inquiry->budget, 0, ',', '.') }}
                                    @else
                                        <span class="text-gray-400">Tidak disebutkan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @switch($inquiry->status)
                                            @case('new') bg-blue-100 text-blue-800 @break
                                            @case('contacted') bg-yellow-100 text-yellow-800 @break
                                            @case('in_progress') bg-purple-100 text-purple-800 @break
                                            @case('completed') bg-green-100 text-green-800 @break
                                            @case('cancelled') bg-red-100 text-red-800 @break
                                            @default bg-gray-100 text-gray-800
                                        @endswitch">
                                        @switch($inquiry->status)
                                            @case('new') Baru @break
                                            @case('contacted') Dihubungi @break
                                            @case('in_progress') Diproses @break
                                            @case('completed') Selesai @break
                                            @case('cancelled') Dibatalkan @break
                                            @default {{ ucfirst($inquiry->status) }}
                                        @endswitch
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>{{ $inquiry->created_at->format('d M Y') }}</div>
                                    <div class="text-xs">{{ $inquiry->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if($inquiry->status === 'completed' && !$inquiry->project)
                                            <span class="text-green-600 text-xs bg-green-50 px-2 py-1 rounded">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Selesai
                                            </span>
                                        @elseif($inquiry->project)
                                            <a href="{{ route('customer.projects.detail', $inquiry->project) }}" 
                                               class="text-brand-green hover:text-brand-green-dark text-xs bg-green-50 px-2 py-1 rounded">
                                                <i class="fas fa-arrow-right mr-1"></i>
                                                Lihat Proyek
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs">
                                                Menunggu proses
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $inquiries->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <div class="mb-4">
                    <i class="fas fa-question-circle text-6xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-700 mb-2">Belum Ada Inquiry</h3>
                <p class="text-gray-500 mb-6">Anda belum membuat inquiry. Mulai dengan membuat permintaan layanan.</p>
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
                <h3 class="text-sm font-medium text-blue-800">Informasi Status Inquiry</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>Baru:</strong> Inquiry baru diterima, menunggu review admin</li>
                        <li><strong>Dihubungi:</strong> Admin telah menghubungi Anda untuk diskusi lebih lanjut</li>
                        <li><strong>Diproses:</strong> Inquiry sedang diproses dan akan segera menjadi proyek</li>
                        <li><strong>Selesai:</strong> Inquiry telah dikonversi menjadi proyek atau diselesaikan</li>
                        <li><strong>Dibatalkan:</strong> Inquiry dibatalkan karena berbagai alasan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
