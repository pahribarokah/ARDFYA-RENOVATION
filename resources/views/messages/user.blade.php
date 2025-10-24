@extends('layouts.main')

@section('content')
<div class="container mx-auto p-4 max-w-4xl">
    <h1 class="text-2xl font-bold mb-4">Chat Messages</h1>

<div id="app">
    <user-chat></user-chat>
</div>
</div>

@push('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endpush
@endsection
