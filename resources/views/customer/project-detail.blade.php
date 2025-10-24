@extends('layouts.customer')

@section('title', 'Detail Proyek - ' . $project->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $project->name }}</h1>
                <p class="text-gray-600 mt-2">{{ $project->service->name ?? 'N/A' }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    @if($project->status === 'completed') bg-green-100 text-green-800
                    @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800
                    @elseif($project->status === 'planning') bg-yellow-100 text-yellow-800
                    @elseif($project->status === 'on_hold') bg-orange-100 text-orange-800
                    @elseif($project->status === 'cancelled') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    @switch($project->status)
                        @case('planning') Perencanaan @break
                        @case('in_progress') Berlangsung @break
                        @case('on_hold') Ditunda @break
                        @case('completed') Selesai @break
                        @case('cancelled') Dibatalkan @break
                        @default {{ ucfirst($project->status) }}
                    @endswitch
                </span>
                <a href="{{ route('customer.projects') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Project Overview -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Proyek</h2>
                
                <!-- Progress Bar -->
                @if($project->progress_percentage !== null)
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Progress Keseluruhan</span>
                            <span class="font-medium">{{ $project->progress_percentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-brand-green h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ $project->progress_percentage }}%"></div>
                        </div>
                    </div>
                @endif

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Deskripsi</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $project->description }}</p>
                </div>

                <!-- Timeline Details -->
                @if($project->timeline_details)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Detail Timeline</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700">{{ $project->timeline_details }}</p>
                        </div>
                    </div>
                @endif

                <!-- Notes -->
                @if($project->notes)
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Catatan</h3>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <p class="text-blue-800">{{ $project->notes }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Project Photos -->
            @if($project->project_photos && count($project->project_photos) > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Foto Progress</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($project->project_photos as $photo)
                            <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden">
                                <img src="{{ Storage::url($photo) }}" 
                                     alt="Project Photo" 
                                     class="w-full h-full object-cover hover:scale-105 transition-transform cursor-pointer"
                                     onclick="openImageModal('{{ Storage::url($photo) }}')">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Team Assigned -->
            @if($project->team_assigned && count($project->team_assigned) > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Tim yang Ditugaskan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($project->team_assigned as $member)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-10 h-10 bg-brand-green rounded-full flex items-center justify-center text-white font-medium">
                                    {{ substr($member['name'] ?? 'N', 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-800">{{ $member['name'] ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">{{ $member['role'] ?? 'Team Member' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Project Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Proyek</h3>
                
                <div class="space-y-4">
                    @if($project->budget)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Budget:</span>
                            <span class="font-medium">Rp {{ number_format($project->budget, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    @if($project->budget_used)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Budget Terpakai:</span>
                            <span class="font-medium text-orange-600">Rp {{ number_format($project->budget_used, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    @if($project->start_date)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Mulai:</span>
                            <span class="font-medium">{{ $project->start_date->format('d M Y') }}</span>
                        </div>
                    @endif

                    @if($project->expected_end_date)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Target Selesai:</span>
                            <span class="font-medium">{{ $project->expected_end_date->format('d M Y') }}</span>
                        </div>
                    @endif

                    @if($project->actual_end_date)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Selesai Aktual:</span>
                            <span class="font-medium text-green-600">{{ $project->actual_end_date->format('d M Y') }}</span>
                        </div>
                    @endif

                    @if($project->address)
                        <div>
                            <span class="text-gray-600">Lokasi:</span>
                            <p class="font-medium mt-1">{{ $project->address }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Related Contract -->
            @if($project->contract)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Kontrak Terkait</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nilai Kontrak:</span>
                            <span class="font-medium text-brand-green">
                                Rp {{ number_format($project->contract->amount, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @switch($project->contract->contract_status)
                                    @case('draft') bg-gray-100 text-gray-800 @break
                                    @case('active') bg-green-100 text-green-800 @break
                                    @case('completed') bg-blue-100 text-blue-800 @break
                                    @case('terminated') bg-red-100 text-red-800 @break
                                @endswitch">
                                {{ ucfirst($project->contract->contract_status) }}
                            </span>
                        </div>
                        
                        <div class="pt-3 border-t">
                            <a href="{{ route('customer.contracts') }}" 
                               class="w-full bg-brand-green hover:bg-brand-green-dark text-white text-center py-2 rounded transition-colors block">
                                Lihat Detail Kontrak
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('messages.customer') }}" 
                       class="w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded transition-colors block">
                        <i class="fas fa-comments mr-2"></i>Chat dengan Admin
                    </a>
                    
                    @if($project->inquiry)
                        <a href="{{ route('customer.inquiries') }}" 
                           class="w-full bg-purple-500 hover:bg-purple-600 text-white text-center py-2 rounded transition-colors block">
                            <i class="fas fa-eye mr-2"></i>Lihat Inquiry Asal
                        </a>
                    @endif
                </div>
            </div>

            <!-- Last Updated -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-600">
                    <p><strong>Terakhir diperbarui:</strong></p>
                    <p>{{ $project->updated_at->format('d M Y, H:i') }}</p>
                    <p class="text-xs mt-1">{{ $project->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="Project Photo" class="max-w-full max-h-full object-contain">
        <button onclick="closeImageModal()" 
                class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<script>
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal when clicking outside the image
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>
@endsection
