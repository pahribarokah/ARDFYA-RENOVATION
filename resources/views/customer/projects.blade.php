@extends('layouts.customer')

@section('title', 'Proyek Saya')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Proyek Saya</h1>
    <p class="text-gray-600 mt-2">Kelola dan pantau progress proyek Anda</p>
</div>

    @if($projects->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($projects as $project)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <!-- Project Header -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $project->name }}</h3>
                            <span class="text-xs px-2 py-1 rounded-full 
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
                        </div>

                        <!-- Service -->
                        <div class="mb-3">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-cog mr-2"></i>
                                {{ $project->service->name ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-700 text-sm mb-4">{{ Str::limit($project->description, 100) }}</p>

                        <!-- Progress Bar -->
                        @if($project->progress_percentage !== null)
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>Progress</span>
                                    <span>{{ $project->progress_percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                                </div>
                            </div>
                        @endif

                        <!-- Project Info -->
                        <div class="space-y-2 text-sm text-gray-600">
                            @if($project->budget)
                                <div class="flex items-center">
                                    <i class="fas fa-money-bill-wave mr-2 w-4"></i>
                                    <span>Budget: Rp {{ number_format($project->budget, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            
                            @if($project->start_date)
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-start mr-2 w-4"></i>
                                    <span>Mulai: {{ $project->start_date->format('d M Y') }}</span>
                                </div>
                            @endif
                            
                            @if($project->expected_end_date)
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-check mr-2 w-4"></i>
                                    <span>Target: {{ $project->expected_end_date->format('d M Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Project Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">
                                Update: {{ $project->updated_at->diffForHumans() }}
                            </span>
                            <a href="{{ route('customer.projects.detail', $project) }}"
                               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm transition-colors">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $projects->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <div class="mb-4">
                    <i class="fas fa-project-diagram text-6xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-700 mb-2">Belum Ada Proyek</h3>
                <p class="text-gray-500 mb-6">Anda belum memiliki proyek. Mulai dengan membuat inquiry terlebih dahulu.</p>
                <a href="{{ route('inquiries.create') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg inline-flex items-center transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Inquiry Baru
                </a>
            </div>
        </div>
    @endif
@endsection
