@extends('layouts.admin')

@section('title', 'Chat Management - ARDFYA Admin')

@section('header', 'Chat Management')

@section('content')
<div class="max-w-6xl mx-auto w-full">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex flex-col md:flex-row h-[70vh]">
            <!-- Sidebar: Daftar Customer Chat -->
            <div class="w-full md:w-80 border-r bg-gray-50 flex-shrink-0 flex flex-col">
                <div class="p-4 border-b">
                    <h2 class="font-medium text-lg">Customer Chats</h2>
                    <input type="text" id="search-customers" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-brand-green mt-2" placeholder="Cari customer...">
                </div>
                <div class="overflow-y-auto flex-1 pb-20" id="customers-list">
                    <p class="text-sm text-gray-500 px-3 py-2">Loading customers...</p>
                </div>
            </div>
            <!-- Main Area: Room Chat -->
            <div class="flex-1 flex flex-col min-w-0">
                <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                    <div>
                        <h2 class="font-medium text-lg" id="chat-title">Pilih customer</h2>
                        <p class="text-sm text-gray-500" id="chat-customer">Tidak ada customer dipilih</p>
                    </div>
                </div>
                <div class="flex-1 overflow-y-auto p-4 flex flex-col gap-2 min-h-0" id="messages-container">
                    <div class="flex items-center justify-center h-full text-gray-500">
                        <p>Pilih customer untuk mulai chat</p>
                    </div>
                </div>
                <div class="border-t p-4" id="message-input-container" style="display: none;">
                    <form id="send-message-form" class="flex items-center gap-2">
                        <input type="file" id="admin-chat-file" class="hidden" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar">
                        <label for="admin-chat-file" class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-200 hover:bg-green-100 cursor-pointer transition">
                            <i class="fas fa-paperclip text-green-700"></i>
                        </label>
                        <input type="text" id="message-input" class="flex-1 border border-gray-300 rounded-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-green" placeholder="Ketik pesan...">
                        <button type="submit" class="bg-brand-green hover:bg-brand-green-dark text-white rounded-full px-5 py-2 font-semibold transition">Kirim</button>
                    </form>
                    <!-- Tambahkan div preview dengan tombol close -->
                    <div id="admin-chat-preview" class="px-2 pt-2 hidden">
                        <div class="flex items-center gap-2 bg-gray-100 p-2 rounded-lg">
                            <div id="preview-content" class="flex-1"></div>
                            <button id="remove-file-admin" class="text-red-500 hover:text-red-700 p-1">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar: Load customer chat list
    const customersList = document.getElementById('customers-list');
    const searchInput = document.getElementById('search-customers');
    let allCustomers = [];
    
    // Load initial customer list and set up refresh
    loadCustomers();
    setInterval(loadCustomers, 30000); // Refresh every 30 seconds

    function loadCustomers() {
        fetch('/admin/customers/json', { credentials: 'include' })
            .then(res => {
                if (!res.ok) {
                    res.text().then(text => {
                        console.error('Error loading customers:', res.status, text);
                    });
                    throw new Error('Network response was not ok');
                }
                return res.json();
            })
            .then(data => {
                allCustomers = data;
                renderCustomers(data);
            })
            .catch((error) => {
                console.error('Error loading customers:', error);
                customersList.innerHTML = '<p class="text-sm text-red-500 px-3 py-2">Gagal load daftar customer</p>';
            });
    }
    
    function renderCustomers(customers) {
        if (!customers.length) {
            customersList.innerHTML = '<p class="text-sm text-gray-500 px-3 py-2">Tidak ada customer yang terdaftar</p>';
            return;
        }
        let html = '';
        customers.forEach(c => {
            html += `<div class='flex items-center gap-3 px-3 py-2 hover:bg-green-50 rounded cursor-pointer customer-item' data-id='${c.id}' data-name='${c.name}'>
                <div class='w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-lg font-bold text-brand-green'>${c.avatar || c.name[0]}</div>
                <div class='flex-1'>
                    <div class='font-semibold text-gray-800'>${c.name}</div>
                    <div class='text-xs text-gray-500 truncate'>${c.last_message || 'Belum ada pesan'}</div>
                </div>
                ${c.unread ? `<span class='bg-red-500 text-white text-xs rounded-full px-2 py-0.5'>${c.unread}</span>` : ''}
            </div>`;
        });
        customersList.innerHTML = html;
        document.querySelectorAll('.customer-item').forEach(item => {
            item.addEventListener('click', function() {
                selectCustomer(this.dataset.id, this.dataset.name);
            });
        });
    }
    searchInput.addEventListener('input', function() {
        const val = this.value.toLowerCase();
        renderCustomers(allCustomers.filter(c => c.name.toLowerCase().includes(val)));
    });
    // Main area: Room chat
    let selectedCustomerId = null;
    const chatTitle = document.getElementById('chat-title');
    const chatCustomer = document.getElementById('chat-customer');
    const messagesContainer = document.getElementById('messages-container');
    const messageInputContainer = document.getElementById('message-input-container');
    const sendMessageForm = document.getElementById('send-message-form');
    const messageInput = document.getElementById('message-input');
    const chatFile = document.getElementById('admin-chat-file');
    const chatPreview = document.getElementById('admin-chat-preview');
    let fileData = null;
    function selectCustomer(id, name) {
        selectedCustomerId = id;
        chatTitle.textContent = name;
        chatCustomer.textContent = 'Chat dengan ' + name;
        messageInputContainer.style.display = '';
        loadMessages(id);
    }
    function loadMessages(customerId) {
        messagesContainer.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500"><p>Loading messages...</p></div>';
        
        fetch(`/admin/chat/messages?customer_id=${customerId}`, { credentials: 'include' })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'error') {
                    throw new Error(data.message);
                }
                renderMessages(data);
            })
            .catch(error => {
                console.error('Error loading messages:', error);
                messagesContainer.innerHTML = '<div class="flex items-center justify-center h-full text-red-500"><p>Failed to load messages. Please try again.</p></div>';
            });
    }
    // ...existing code...
function renderMessages(messages) {
    messagesContainer.innerHTML = '';
    if (!messages.length) {
        messagesContainer.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500"><p>Belum ada pesan</p></div>';
        return;
    }
    messages.forEach(msg => {
        let messageContent = '';
        
        // Handle file/image
        if (msg.file_url) {
            if (msg.file_type && msg.file_type.startsWith('image/')) {
                messageContent = `
                    <div class='max-w-sm'>
                        <a href='${msg.file_url}' target='_blank'>
                            <img src='${msg.file_url}' alt='${msg.file_name}' 
                                class='max-w-full rounded-lg shadow-md hover:opacity-90 transition'
                                style='max-height: 200px; object-fit: contain;'>
                        </a>
                        <div class='mt-1 text-xs opacity-75'>${msg.file_name}</div>
                    </div>`;
            } else {
                const fileIcon = getFileIcon(msg.file_type);
                messageContent = `
                    <div class='flex items-center gap-2 bg-white/10 rounded p-2'>
                        <i class='fas ${fileIcon}'></i>
                        <a href='${msg.file_url}' class='text-sm underline' target='_blank' download>${msg.file_name}</a>
                    </div>`;
            }
        }

        // Add text message if exists
        if (msg.message && msg.message.trim()) {
            messageContent += `<div class='mt-1'>${msg.message}</div>`;
        }

        const bubble = `
            <div class='${msg.is_from_admin ? 'self-end max-w-[70%]' : 'self-start max-w-[70%]'}'>
                <div class='rounded-2xl px-4 py-2 mb-2 ${msg.is_from_admin ? 'bg-brand-green text-white' : 'bg-gray-200 text-gray-800'}'>
                    ${messageContent}
                </div>
            </div>`;

        messagesContainer.innerHTML += bubble;
    });
    
    // Scroll to bottom after images load
    const images = messagesContainer.getElementsByTagName('img');
    let loadedImages = 0;
    
    if (images.length > 0) {
        Array.from(images).forEach(img => {
            img.onload = () => {
                loadedImages++;
                if (loadedImages === images.length) {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            };
        });
    } else {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
}
// Tambahkan helper function untuk icon file
function getFileIcon(fileType) {
    if (!fileType) return 'fa-file';
    if (fileType.startsWith('image/')) return 'fa-file-image';
    if (fileType.includes('pdf')) return 'fa-file-pdf';
    if (fileType.includes('word') || fileType.includes('doc')) return 'fa-file-word';
    if (fileType.includes('excel') || fileType.includes('sheet')) return 'fa-file-excel';
    if (fileType.includes('zip') || fileType.includes('rar')) return 'fa-file-archive';
    return 'fa-file';
}
// ...existing code...

const previewContainer = document.getElementById('admin-chat-preview');
const previewContent = document.getElementById('preview-content');
const removeFileBtn = document.getElementById('remove-file-admin');

   // Update event listener file input
chatFile.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        fileData = file;
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                previewContent.innerHTML = `
                    <div class="flex items-center gap-2">
                        <img src="${ev.target.result}" alt="preview" class="max-h-32 rounded-lg shadow">
                        <span class="text-xs text-gray-600">${file.name}</span>
                    </div>`;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            const fileIcon = getFileIcon(file.type);
            previewContent.innerHTML = `
                <div class="flex items-center gap-2">
                    <i class="fas ${fileIcon} text-green-700"></i>
                    <span class="text-xs text-gray-600">${file.name}</span>
                </div>`;
            previewContainer.classList.remove('hidden');
        }
    }
});

// Tambahkan event listener untuk tombol hapus file
removeFileBtn.addEventListener('click', function() {
    chatFile.value = '';
    fileData = null;
    previewContainer.classList.add('hidden');
    previewContent.innerHTML = '';
});

// Update submit handler untuk membersihkan preview setelah kirim
sendMessageForm.addEventListener('submit', function(e) {
    e.preventDefault();
    if (!selectedCustomerId) return;
    
    const message = messageInput.value.trim();
    if (!message && !fileData) return;
    
    const formData = new FormData();
    if (message) formData.append('message', message);
    if (fileData) formData.append('file', fileData);
    
    fetch(`/admin/chat/reply/${selectedCustomerId}`, {
        method: 'POST',
        headers: { 
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData,
        credentials: 'include'
    })
    .then(res => res.json())
    .then(() => {
        messageInput.value = '';
        chatFile.value = '';
        fileData = null;
        previewContainer.classList.add('hidden');
        previewContent.innerHTML = '';
        loadMessages(selectedCustomerId);
    })
    .catch(error => {
        console.error('Error sending message:', error);
        alert('Gagal mengirim pesan. Silakan coba lagi.');
    });
});

});
</script>
@endsection