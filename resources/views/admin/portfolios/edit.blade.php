@extends('layouts.admin')

@section('title', 'Edit Portfolio')
@section('header', 'Edit Portfolio')

@push('styles')
<style>
    .upload-area-hover {
        border-color: #059669 !important;
        background-color: #f0fdf4 !important;
    }

    .drag-active {
        border-color: #059669 !important;
        background-color: #dcfce7 !important;
        transform: scale(1.02);
    }

    #uploadArea {
        transition: all 0.3s ease;
    }

    #imagePreview {
        transition: all 0.3s ease;
    }

    .remove-btn {
        transition: all 0.2s ease;
    }

    .remove-btn:hover {
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.portfolios.index') }}" 
           class="text-gray-600 hover:text-gray-900 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <h2 class="text-xl font-semibold text-gray-800">Edit Portfolio: {{ $portfolio->title }}</h2>
    </div>

    <form action="{{ route('admin.portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Judul -->
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Portfolio <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{ old('title', $portfolio->title) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent @error('title') border-red-500 @enderror"
                       placeholder="Masukkan judul portfolio"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select name="category" 
                        id="category" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent @error('category') border-red-500 @enderror"
                        required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $key => $value)
                        <option value="{{ $key }}" {{ old('category', $portfolio->category) == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Klien -->
            <div>
                <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Klien
                </label>
                <input type="text" 
                       name="client_name" 
                       id="client_name" 
                       value="{{ old('client_name', $portfolio->client_name) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent @error('client_name') border-red-500 @enderror"
                       placeholder="Masukkan nama klien">
                @error('client_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lokasi -->
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                    Lokasi
                </label>
                <input type="text" 
                       name="location" 
                       id="location" 
                       value="{{ old('location', $portfolio->location) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent @error('location') border-red-500 @enderror"
                       placeholder="Masukkan lokasi proyek">
                @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Selesai -->
            <div>
                <label for="completion_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Selesai
                </label>
                <input type="date" 
                       name="completion_date" 
                       id="completion_date" 
                       value="{{ old('completion_date', $portfolio->completion_date?->format('Y-m-d')) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent @error('completion_date') border-red-500 @enderror">
                @error('completion_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nilai Proyek -->
            <div>
                <label for="project_value" class="block text-sm font-medium text-gray-700 mb-2">
                    Nilai Proyek (Rp)
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                    <input type="text"
                           name="project_value"
                           id="project_value"
                           value="{{ old('project_value', $portfolio->project_value) }}"
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent @error('project_value') border-red-500 @enderror"
                           placeholder="0"
                           data-currency="true">
                </div>
                <p class="mt-1 text-xs text-gray-500">Maksimal Rp 9.999.999.999.999 (9,9 Triliun)</p>
                @error('project_value')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Urutan -->
            <div>
                <label for="ordering" class="block text-sm font-medium text-gray-700 mb-2">
                    Urutan Tampilan
                </label>
                <input type="number" 
                       name="ordering" 
                       id="ordering" 
                       value="{{ old('ordering', $portfolio->ordering) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent @error('ordering') border-red-500 @enderror"
                       placeholder="0"
                       min="0">
                @error('ordering')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi <span class="text-red-500">*</span>
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent @error('description') border-red-500 @enderror"
                          placeholder="Masukkan deskripsi portfolio"
                          required>{{ old('description', $portfolio->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Image & Upload New -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Gambar Portfolio
                </label>

                <!-- Current Image -->
                @if($portfolio->image_path)
                    <div id="currentImageContainer" class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                        <div class="relative inline-block">
                            <div class="w-32 h-32 rounded-lg overflow-hidden bg-gray-100">
                                <img src="{{ asset('storage/' . $portfolio->image_path) }}"
                                     alt="{{ $portfolio->title }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <button type="button" id="removeCurrentImage" class="remove-btn absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors shadow-lg">
                                ×
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Klik × untuk menghapus gambar saat ini</p>
                    </div>
                @endif

                <!-- New Image Preview Container -->
                <div id="imagePreviewContainer" class="hidden mb-4">
                    <div class="relative inline-block">
                        <img id="imagePreview" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300">
                        <button type="button" id="removeImage" class="remove-btn absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors shadow-lg">
                            ×
                        </button>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Preview gambar baru yang akan diupload</p>
                </div>

                <!-- Upload Area -->
                <div id="uploadArea" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-brand-green transition-colors cursor-pointer">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-brand-green hover:text-brand-green-dark focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-green">
                                <span id="uploadText">{{ $portfolio->image_path ? 'Ganti gambar' : 'Upload gambar' }}</span>
                                <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, JPEG, WEBP hingga 5MB</p>
                    </div>
                </div>

                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="md:col-span-2">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               value="1"
                               {{ old('is_active', $portfolio->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-brand-green focus:ring-brand-green border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Portfolio Aktif
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_featured" 
                               id="is_featured" 
                               value="1"
                               {{ old('is_featured', $portfolio->is_featured) ? 'checked' : '' }}
                               class="h-4 w-4 text-brand-green focus:ring-brand-green border-gray-300 rounded">
                        <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                            Portfolio Unggulan
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.portfolios.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-brand-green text-white rounded-lg hover:bg-brand-green-dark transition duration-200">
                Update Portfolio
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const uploadArea = document.getElementById('uploadArea');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const removeImageBtn = document.getElementById('removeImage');
    const removeCurrentImageBtn = document.getElementById('removeCurrentImage');
    const currentImageContainer = document.getElementById('currentImageContainer');
    const uploadText = document.getElementById('uploadText');

    // File validation
    function validateFile(file) {
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!validTypes.includes(file.type)) {
            alert('Tipe file tidak didukung. Gunakan JPG, PNG, atau WEBP.');
            return false;
        }

        if (file.size > maxSize) {
            alert('Ukuran file terlalu besar. Maksimal 5MB.');
            return false;
        }

        return true;
    }

    // Show image preview
    function showImagePreview(file) {
        if (!validateFile(file)) {
            imageInput.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreviewContainer.classList.remove('hidden');
            uploadText.textContent = 'Ganti gambar';
        };
        reader.readAsDataURL(file);
    }

    // Remove image preview
    function removeImagePreview() {
        imageInput.value = '';
        imagePreview.src = '';
        imagePreviewContainer.classList.add('hidden');
        uploadText.textContent = currentImageContainer && !currentImageContainer.classList.contains('hidden') ? 'Ganti gambar' : 'Upload gambar';
    }

    // Remove current image
    function removeCurrentImage() {
        if (confirm('Apakah Anda yakin ingin menghapus gambar saat ini?')) {
            currentImageContainer.classList.add('hidden');
            uploadText.textContent = 'Upload gambar';
            // You might want to add a hidden input to mark image for deletion
        }
    }

    // Handle file input change
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            showImagePreview(file);
        }
    });

    // Handle remove image button
    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', removeImagePreview);
    }

    // Handle remove current image button
    if (removeCurrentImageBtn) {
        removeCurrentImageBtn.addEventListener('click', removeCurrentImage);
    }

    // Handle click on upload area
    uploadArea.addEventListener('click', function() {
        imageInput.click();
    });

    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.classList.add('drag-active');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        // Only remove if we're leaving the upload area completely
        if (!uploadArea.contains(e.relatedTarget)) {
            uploadArea.classList.remove('drag-active');
        }
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.classList.remove('drag-active');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            // Create a new FileList-like object
            const dt = new DataTransfer();
            dt.items.add(file);
            imageInput.files = dt.files;
            showImagePreview(file);
        }
    });

    // Prevent default drag behaviors on document
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        document.addEventListener(eventName, function(e) {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    // Currency formatting for project value
    const projectValueInput = document.getElementById('project_value');

    // Format number with thousand separators
    function formatCurrency(value) {
        // Remove all non-digit characters
        const numericValue = value.replace(/[^\d]/g, '');

        // Add thousand separators
        return numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Remove formatting and get numeric value
    function getNumericValue(value) {
        return value.replace(/[^\d]/g, '');
    }

    // Validate project value
    function validateProjectValue(value) {
        const numericValue = parseInt(getNumericValue(value));
        const maxValue = 9999999999999; // 9.999.999.999.999

        if (numericValue > maxValue) {
            return false;
        }
        return true;
    }

    if (projectValueInput) {
        // Format on input
        projectValueInput.addEventListener('input', function(e) {
            const cursorPosition = e.target.selectionStart;
            const oldValue = e.target.value;
            const oldLength = oldValue.length;

            // Format the value
            const formattedValue = formatCurrency(e.target.value);
            e.target.value = formattedValue;

            // Adjust cursor position
            const newLength = formattedValue.length;
            const lengthDiff = newLength - oldLength;
            e.target.setSelectionRange(cursorPosition + lengthDiff, cursorPosition + lengthDiff);

            // Validate
            if (!validateProjectValue(formattedValue)) {
                e.target.classList.add('border-red-500');
                // Show error message
                let errorMsg = e.target.parentNode.parentNode.querySelector('.currency-error');
                if (!errorMsg) {
                    errorMsg = document.createElement('p');
                    errorMsg.className = 'mt-1 text-sm text-red-600 currency-error';
                    errorMsg.textContent = 'Nilai proyek melebihi batas maksimum (Rp 9.999.999.999.999)';
                    e.target.parentNode.parentNode.appendChild(errorMsg);
                }
            } else {
                e.target.classList.remove('border-red-500');
                // Remove error message
                const errorMsg = e.target.parentNode.parentNode.querySelector('.currency-error');
                if (errorMsg) {
                    errorMsg.remove();
                }
            }
        });

        // Convert to numeric value before form submission
        const form = projectValueInput.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const formattedValue = projectValueInput.value;
                if (!validateProjectValue(formattedValue)) {
                    e.preventDefault();
                    alert('Nilai proyek melebihi batas maksimum (Rp 9.999.999.999.999)');
                    return false;
                }

                // Convert formatted value to numeric for submission
                const numericValue = getNumericValue(formattedValue);
                projectValueInput.value = numericValue;
            });
        }

        // Format initial value if exists
        if (projectValueInput.value) {
            projectValueInput.value = formatCurrency(projectValueInput.value);
        }
    }
});
</script>
@endsection
