@extends('layouts.main')

@section('title', 'Chat - ARDFYA')

@section('content')
<div class="px-2"> <!-- Kurangi padding -->
    <div class="bg-white shadow-lg overflow-hidden max-w-[98%] mx-auto"> <!-- Ubah max-width menjadi 98% -->
        <!-- Header -->
        <div class="bg-green-700 text-white px-6 py-4">
            <h1 class="text-xl font-semibold">Customer Support</h1>
        </div>

        <!-- Chat area dengan fixed height -->
        <div id="chat-messages" class="p-6 overflow-y-auto bg-gray-50" style="height: 550px"> <!-- Tinggi disesuaikan -->
            <div class="flex items-center justify-center h-full">
                <p class="text-gray-500">Loading messages...</p>
            </div>
        </div>

        <!-- Input area -->
        <div class="p-4 bg-white border-t">
            <!-- File preview -->
            <div id="file-preview" class="mb-3 hidden">
                <div class="flex items-center justify-between bg-gray-100 p-2 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-file text-green-700"></i>
                        <span id="file-name" class="text-sm text-gray-600"></span>
                    </div>
                    <button id="remove-file" class="text-red-500 hover:text-red-700 p-1">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Message form -->
            <form id="chat-form" class="flex items-center gap-3">
                <label for="file-input" class="cursor-pointer flex-shrink-0">
                    <i class="fas fa-paperclip text-gray-500 hover:text-green-700 text-xl p-2 rounded-full hover:bg-green-50 transition"></i>
                    <input type="file" id="file-input" class="hidden" accept="image/*,.pdf,.doc,.docx">
                </label>
                
                <input type="text" 
                    id="chat-input" 
                    class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" 
                    placeholder="Ketik pesan...">
                
                <button type="submit" 
                    class="bg-green-700 text-white rounded-full px-6 py-2 font-medium hover:bg-green-800 transition-colors">
                    Kirim
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    const fileInput = document.getElementById('file-input');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const removeFile = document.getElementById('remove-file');
    let selectedFile = null;

     fileInput.addEventListener('change', function(e) {
        selectedFile = e.target.files[0];
        if (selectedFile) {
            fileName.textContent = selectedFile.name;
            filePreview.classList.remove('hidden');
        }
    });

    removeFile.addEventListener('click', function() {
        fileInput.value = '';
        selectedFile = null;
        filePreview.classList.add('hidden');
    });
    // Load existing messages
    loadMessages();

    // Set up message polling
    // setInterval(loadMessages, 5000);

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        
        if (!message && !selectedFile) {
            return;
        }

        const formData = new FormData();
        if (message) formData.append('message', message);
        if (selectedFile) formData.append('file', selectedFile);

        sendMessage(formData);
        chatInput.value = '';
        fileInput.value = '';
        selectedFile = null;
        filePreview.classList.add('hidden');
    });

    function loadMessages() {
        fetch('/chat/messages', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(messages => {
            displayMessages(messages);

            // Auto mark messages from admin as read
            const unreadIds = messages
                .filter(msg => !msg.is_read && msg.is_from_admin)
                .map(msg => msg.id);

            if (unreadIds.length > 0) {
                markMessagesAsRead(unreadIds);
            }
        })
        .catch(error => {
            console.error('Error loading messages:', error);
            chatMessages.innerHTML = '<p class="text-red-500 text-center py-4">Error loading messages. Please try again.</p>';
        });
    }

        function sendMessage(formData) {
        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'sukses') {
                loadMessages();
            } else {
                throw new Error(data.pesan || 'Gagal mengirim pesan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengirim pesan. Silakan coba lagi.');
        });
    }

    function displayMessages(messages) {
    if (!messages.length) {
        chatMessages.innerHTML = '<p class="text-center text-gray-500 py-4">Belum ada pesan</p>';
        return;
    }

    let html = '';
    messages.forEach(msg => {
        const isFromMe = !msg.is_from_admin;
        let content = '';

        // Handle file content dengan ukuran gambar yang lebih sesuai
        if (msg.file_url) {
            if (msg.file_type && msg.file_type.startsWith('image/')) {
                content = `
                    <div class="max-w-[280px] mb-2"> <!-- Ubah ukuran maksimal -->
                        <a href="${msg.file_url}" target="_blank" class="block">
                            <img src="${msg.file_url}" 
                                alt="${msg.file_name}" 
                                class="w-full h-auto rounded-lg shadow-sm hover:opacity-90 transition"
                                style="max-height: 160px; object-fit: cover;"> <!-- Sesuaikan tinggi maksimal -->
                        </a>
                        <div class="text-xs opacity-75 mt-1">${msg.file_name}</div>
                    </div>`;
                } else {
                    const fileIcon = getFileIcon(msg.file_type);
                content = `
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas ${fileIcon}"></i>
                        <a href="${msg.file_url}" class="text-sm underline hover:text-green-700" 
                            target="_blank" download>${msg.file_name}</a>
                    </div>`;
                }
            }

            // Add message text if exists
           if (msg.message) {
            content += `<div class="break-words">${msg.message}</div>`; <!-- Tambah break-words -->
        }

        html += `
            <div class="${isFromMe ? 'text-right' : 'text-left'} mb-4">
                <div class="inline-block rounded-xl px-4 py-2 max-w-[85%] md:max-w-[70%] 
                    ${isFromMe ? 'bg-green-700 text-white' : 'bg-gray-200 text-gray-800'}">
                    ${content}
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    ${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                </div>
            </div>
        `;
    });

        chatMessages.innerHTML = html;
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function getFileIcon(fileType) {
        if (!fileType) return 'fa-file';
        if (fileType.startsWith('image/')) return 'fa-file-image';
        if (fileType.includes('pdf')) return 'fa-file-pdf';
        if (fileType.includes('word') || fileType.includes('doc')) return 'fa-file-word';
        if (fileType.includes('excel') || fileType.includes('sheet')) return 'fa-file-excel';
        return 'fa-file';
    }

    function markMessagesAsRead(messageIds) {
        fetch('/chat/read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                message_ids: messageIds
            })
        }).catch(error => {
            console.error('Error marking messages as read:', error);
        });
    }

    // Set up Echo for real-time updates
    if (window.Echo) {
        try {
            window.Echo.private(`chat.${document.querySelector('meta[name="user-id"]').getAttribute('content')}`)
                .listen('.new.chat.message', (e) => {
                    loadMessages();
                });
        } catch (e) {
            console.error('Echo setup error:', e);
        }
    }
});
</script>
@endsection