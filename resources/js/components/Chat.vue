<template>
  <div class="chat-widget">
    <div class="chat-header">
      <h3>Live Chat</h3>
    </div>
    <div class="chat-messages" ref="messageContainer">
      <div v-for="message in messages" :key="message.id" 
           :class="['message', message.is_admin ? 'admin' : 'user']">
        <div class="message-content">{{ message.message }}</div>
        <div class="message-time">{{ formatTime(message.created_at) }}</div>
      </div>
    </div>
    <div class="chat-input">
      <input 
        v-model="newMessage" 
        @keyup.enter="sendMessage" 
        placeholder="Type your message..."
        :disabled="sending"
      >
      <button @click="sendMessage" :disabled="sending">
        {{ sending ? 'Sending...' : 'Send' }}
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';

export default {
  data() {
    return {
      messages: [],
      newMessage: '',
      sending: false,
      polling: null
    }
  },
  methods: {
    async sendMessage() {
      if (!this.newMessage.trim() || this.sending) return;
      
      this.sending = true;
      try {
        const response = await axios.post('/chat/send', {
          message: this.newMessage
        });
        this.messages.push(response.data);
        this.newMessage = '';
        this.scrollToBottom();
      } catch (error) {
        alert('Failed to send message. Please try again.');
      } finally {
        this.sending = false;
      }
    },
    scrollToBottom() {
      this.$nextTick(() => {
        if (this.$refs.messageContainer) {
          this.$refs.messageContainer.scrollTop = this.$refs.messageContainer.scrollHeight;
        }
      });
    },
    formatTime(timestamp) {
      return moment(timestamp).format('HH:mm');
    },
    async fetchMessages() {
      try {
        const response = await axios.get('/chat/messages');
        this.messages = response.data;
        this.scrollToBottom();
      } catch (error) {
        console.error('Error fetching messages:', error);
      }
    },
    startPolling() {
      this.polling = setInterval(this.fetchMessages, 3000);
    },
    stopPolling() {
      if (this.polling) {
        clearInterval(this.polling);
      }
    }
  },
  mounted() {
    this.fetchMessages();
    this.startPolling();
  },
  beforeDestroy() {
    this.stopPolling();
  }
}
</script>

<style scoped>
.chat-widget {
  width: 100%;
  height: 500px;
  border: 1px solid #ddd;
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  background: #fff;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.chat-header {
  padding: 15px;
  background: #007bff;
  color: white;
  border-radius: 8px 8px 0 0;
}

.chat-messages {
  flex: 1;
  overflow-y: auto;
  padding: 15px;
  background: #f8f9fa;
}

.message {
  max-width: 80%;
  margin: 8px;
  padding: 10px;
  border-radius: 15px;
  position: relative;
}

.message.user {
  margin-left: auto;
  background: #007bff;
  color: white;
}

.message.admin {
  margin-right: auto;
  background: #e9ecef;
  color: #212529;
}

.message-time {
  font-size: 0.75rem;
  opacity: 0.7;
  margin-top: 4px;
}

.chat-input {
  padding: 15px;
  display: flex;
  gap: 10px;
  background: white;
  border-top: 1px solid #ddd;
}

input {
  flex: 1;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 20px;
  outline: none;
}

button {
  padding: 10px 20px;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 20px;
  cursor: pointer;
  transition: background 0.3s;
}

button:hover {
  background: #0056b3;
}

button:disabled {
  background: #ccc;
  cursor: not-allowed;
}
</style>
