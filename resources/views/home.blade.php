@extends('layouts.app')

@section('title', 'Dashboard - ARDFYA')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-green-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">{{ __('Dashboard') }}</h2>
            </div>

            <div class="p-6">
                @if (session('status'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                        <p>{{ session('status') }}</p>
                    </div>
                @endif

                <div class="mb-8">
                    <p class="mb-4">{{ __('You are logged in!') }}</p>
                    <p class="text-gray-600">Welcome to your account dashboard. From here you can manage your account and access all features of ARDFYA.</p>
                </div>

                <h3 class="text-lg font-medium text-gray-800 mb-4">Quick Access</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('messages.customer') }}" class="block bg-white border border-gray-200 rounded-lg p-4 hover:bg-green-50 transition-colors">
                        <div class="flex items-start">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <i class="fas fa-comments text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium mb-1">Messages</h4>
                                <p class="text-sm text-gray-600">Chat with our team</p>
                            </div>
                        </div>
                    </a>
                    
                    @if(Auth::user()->role === 'customer')
                        <a href="{{ route('customer.profile') }}" class="block bg-white border border-gray-200 rounded-lg p-4 hover:bg-green-50 transition-colors">
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-user text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium mb-1">Profile</h4>
                                    <p class="text-sm text-gray-600">Update your information</p>
                                </div>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="block bg-white border border-gray-200 rounded-lg p-4 hover:bg-green-50 transition-colors">
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-tachometer-alt text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium mb-1">Admin Dashboard</h4>
                                    <p class="text-sm text-gray-600">Manage your system</p>
                                </div>
                            </div>
                        </a>
                    @endif
                    
                    <a href="{{ route('inquiries.create') }}" class="block bg-white border border-gray-200 rounded-lg p-4 hover:bg-green-50 transition-colors">
                        <div class="flex items-start">
                            <div class="bg-purple-100 p-3 rounded-full mr-4">
                                <i class="fas fa-clipboard-list text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium mb-1">New Inquiry</h4>
                                <p class="text-sm text-gray-600">Submit a new request</p>
                            </div>
                        </div>
                    </a>
                </div>

                @if(Auth::user()->inquiries->count() > 0 || Auth::user()->projects->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Your Activity</h3>
                    
                    @if(Auth::user()->projects->count() > 0)
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-2">Recent Projects</h4>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg overflow-hidden">
                            <table class="min-w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach(Auth::user()->projects->take(3) as $project)
                                    <tr>
                                        <td class="px-4 py-3">{{ $project->title }}</td>
                                        <td class="px-4 py-3">{{ ucfirst($project->status) }}</td>
                                        <td class="px-4 py-3">
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    
                    @if(Auth::user()->inquiries->count() > 0)
                    <div>
                        <h4 class="text-md font-medium text-gray-700 mb-2">Recent Inquiries</h4>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg overflow-hidden">
                            <table class="min-w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach(Auth::user()->inquiries->take(3) as $inquiry)
                                    <tr>
                                        <td class="px-4 py-3">{{ $inquiry->service->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $inquiry->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-3">
                                            @if($inquiry->status == 'pending')
                                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                            @elseif($inquiry->status == 'approved')
                                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Approved</span>
                                            @elseif($inquiry->status == 'rejected')
                                                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Rejected</span>
                                            @else
                                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">{{ ucfirst($inquiry->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
