@extends('layouts.admin')

@section('title', 'Admin Chat - ARDFYA Admin')

@section('header', 'Customer Chat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Customers</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group" id="customers-list">
                        <div class="list-group-item text-center py-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mb-0 mt-2">Loading customers...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0" id="chat-title">Select a customer to start chatting</h5>
                </div>
                <div class="card-body">
                    <div id="messages-container" style="height: 400px; overflow-y: auto;">
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-comments fa-3x mb-3"></i>
                            <p>Select a customer to view messages</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form id="message-form" class="d-flex">
                        <input type="hidden" id="customer-id" value="">
                        <input type="text" id="message-input" class="form-control me-2" placeholder="Type your message..." disabled>
                        <button type="submit" class="btn btn-primary" disabled>Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const customersListEl = document.getElementById('customers-list');
        const messagesContainerEl = document.getElementById('messages-container');
        const chatTitleEl = document.getElementById('chat-title');
        const messageFormEl = document.getElementById('message-form');
        const messageInputEl = document.getElementById('message-input');
        const customerIdEl = document.getElementById('customer-id');
        const sendButtonEl = messageFormEl.querySelector('button[type="submit"]');
        
        let selectedCustomerId = null;
        let customers = {};
        
        // Load all chats
        function loadAllChats() {
            fetch('/admin/chat/all')
                .then(response => response.json())
                .then(data => {
                    customers = data;
                    renderCustomersList();
                })
                .catch(error => {
                    console.error('Error loading chats:', error);
                    customersListEl.innerHTML = `
                        <div class="list-group-item text-center py-3 text-danger">
                            <p class="mb-0">Error loading customers. Please try again.</p>
                        </div>
                    `;
                });
        }
        
        // Render customers list
        function renderCustomersList() {
            if (Object.keys(customers).length === 0) {
                customersListEl.innerHTML = `
                    <div class="list-group-item text-center py-3">
                        <p class="mb-0">No active chats</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            
            Object.entries(customers).forEach(([customerId, chats]) => {
                if (chats.length > 0) {
                    const customer = chats[0].customer;
                    const lastMessage = chats[chats.length - 1];
                    const hasUnread = chats.some(chat => !chat.is_read && !chat.is_from_admin);
                    const isActive = selectedCustomerId === customerId;
                    
                    html += `
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ${isActive ? 'active' : ''} ${hasUnread ? 'fw-bold' : ''}" 
                                data-customer-id="${customerId}">
                            <div>
                                <div>${customer.name}</div>
                                <small class="text-muted">${lastMessage.message.substring(0, 30)}${lastMessage.message.length > 30 ? '...' : ''}</small>
                            </div>
                            ${hasUnread ? '<span class="badge bg-danger rounded-pill">New</span>' : ''}
                        </button>
                    `;
                }
            });
            
            customersListEl.innerHTML = html;
            
            // Add event listeners to customer buttons
            customersListEl.querySelectorAll('.list-group-item-action').forEach(button => {
                button.addEventListener('click', function() {
                    const customerId = this.getAttribute('data-customer-id');
                    selectCustomer(customerId);
                });
            });
        }
        
        // Select a customer
        function selectCustomer(customerId) {
            selectedCustomerId = customerId;
            customerIdEl.value = customerId;
            
            // Update UI
            customersListEl.querySelectorAll('.list-group-item-action').forEach(el => {
                el.classList.remove('active');
                if (el.getAttribute('data-customer-id') === customerId) {
                    el.classList.add('active');
                    chatTitleEl.textContent = `Chat with ${el.querySelector('div > div').textContent}`;
                }
            });
            
            // Enable message input
            messageInputEl.disabled = false;
            sendButtonEl.disabled = false;
            
            // Load messages
            loadMessages(customerId);
        }
        
        // Load messages for a customer
        function loadMessages(customerId) {
            messagesContainerEl.innerHTML = `
                <div class="text-center py-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mb-0 mt-2">Loading messages...</p>
                </div>
            `;
              fetch(`/admin/chat/messages?customer_id=${customerId}`)
                .then(response => response.json())
                .then(messages => {
                    renderMessages(messages);
                    
                    // Mark messages as read
                    const unreadIds = messages
                        .filter(msg => !msg.is_read && !msg.is_from_admin)
                        .map(msg => msg.id);
                        
                    if (unreadIds.length > 0) {
                        markMessagesAsRead(unreadIds);
                    }
                })
                .catch(error => {
                    console.error('Error loading messages:', error);
                    messagesContainerEl.innerHTML = `
                        <div class="text-center py-3 text-danger">
                            <p class="mb-0">Error loading messages. Please try again.</p>
                        </div>
                    `;
                });
        }
        
        // Render messages
        function renderMessages(messages) {
            if (messages.length === 0) {
                messagesContainerEl.innerHTML = `
                    <div class="text-center py-5 text-muted">
                        <p class="mb-0">No messages yet</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            
            messages.forEach(message => {
                const isFromAdmin = message.is_from_admin;
                const messageClass = isFromAdmin ? 'bg-primary text-white' : 'bg-light';
                const alignClass = isFromAdmin ? 'align-self-end' : 'align-self-start';
                
                html += `
                    <div class="d-flex flex-column mb-3 ${alignClass}" style="max-width: 75%;">
                        <div class="p-2 rounded ${messageClass}">
                            ${message.message}
                        </div>
                        <small class="text-muted mt-1">
                            ${new Date(message.created_at).toLocaleString()}
                        </small>
                    </div>
                `;
            });
            
            messagesContainerEl.innerHTML = html;
            messagesContainerEl.scrollTop = messagesContainerEl.scrollHeight;
        }
        
        // Mark messages as read
        function markMessagesAsRead(messageIds) {            fetch('/admin/chat/read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    message_ids: messageIds
                })
            })
            .then(() => {
                // Refresh the customers list to update unread indicators
                loadAllChats();
            })
            .catch(error => {
                console.error('Error marking messages as read:', error);
            });
        }
        
        // Send message
        messageFormEl.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const message = messageInputEl.value.trim();
            if (!message || !selectedCustomerId) return;
            
            // Disable form during send
            messageInputEl.disabled = true;
            sendButtonEl.disabled = true;
            
            fetch(`/admin/chat/reply/${selectedCustomerId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    message: message
                })
            })
            .then(response => response.json())
            .then(data => {
                // Clear input
                messageInputEl.value = '';
                
                // Re-enable form
                messageInputEl.disabled = false;
                sendButtonEl.disabled = false;
                messageInputEl.focus();
                
                // Reload messages
                loadMessages(selectedCustomerId);
            })
            .catch(error => {
                console.error('Error sending message:', error);
                alert('Failed to send message. Please try again.');
                
                // Re-enable form
                messageInputEl.disabled = false;
                sendButtonEl.disabled = false;
            });
        });
        
        // Initialize: load all chats
        loadAllChats();
        
        // Set up polling for new messages
        setInterval(() => {
            if (selectedCustomerId) {
                loadMessages(selectedCustomerId);
            }
            loadAllChats();
        }, 5000);
          // Set up Echo for real-time updates
        if (window.Echo) {
            try {
                window.Echo.private('admin.chat')
                    .listen('.new.chat.message', (e) => {
                        if (selectedCustomerId === e.customer_id.toString()) {
                            loadMessages(selectedCustomerId);
                        }
                        loadAllChats();
                    })
                    .error((error) => {
                        console.error('Echo connection error:', error);
                        // Fall back to polling if real-time fails
                        setInterval(() => {
                            if (selectedCustomerId) {
                                loadMessages(selectedCustomerId);
                            }
                            loadAllChats();
                        }, 5000);
                    });
                console.log('Admin chat channel subscribed');
            } catch (e) {
                console.error('Echo setup error:', e);
                // Fall back to polling if real-time setup fails
                setInterval(() => {
                    if (selectedCustomerId) {
                        loadMessages(selectedCustomerId);
                    }
                    loadAllChats();
                }, 5000);
            }
        } else {
            // If Echo is not available, fall back to polling
            console.warn('Real-time updates not available, falling back to polling');
            setInterval(() => {
                if (selectedCustomerId) {
                    loadMessages(selectedCustomerId);
                }
                loadAllChats();
            }, 5000);
        }
    });
</script>
@endsection 