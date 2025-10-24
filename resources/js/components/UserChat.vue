<template>
  <div class="chat-container flex flex-col h-full max-w-4xl mx-auto p-4 border rounded shadow">
    <div class="chat-messages flex-1 overflow-y-auto mb-4 p-2 bg-gray-100 rounded">
      <div v-for="message in messages" :key="message.id" :class="['message', message.is_from_admin ? 'admin' : 'user']">
        <div class="message-content">{{ message.message }}</div>
        <div class="message-time text-xs text-gray-500">{{ formatTime(message.created_at) }}</div>
      </div>
    </div>
    <form @submit.prevent="sendMessage" class="flex gap-2">
      <input v-model="newMessage" type="text" placeholder="Ketik pesan..." class="flex-1 border rounded px-3 py-2" />
      <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">Kirim</button>
    </form>
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
      polling: null,
    };
  },
  methods: {
    async fetchMessages() {
      try {
        const response = await axios.get('/chat/messages');
        this.messages = response.data;
        this.scrollToBottom();
      } catch (error) {
        console.error('Error fetching messages:', error);
      }
    },
    async sendMessage() {
      if (!this.newMessage.trim() || this.sending) return;
      this.sending = true;
      try {
        const response = await axios.post('/chat/send', {
          message: this.newMessage,
        });
        this.messages.push(response.data.data || response.data);
        this.newMessage = '';
        this.scrollToBottom();
      } catch (error) {
        alert('Gagal mengirim pesan. Silakan coba lagi.');
      } finally {
        this.sending = false;
      }
    },
    scrollToBottom() {
      this.$nextTick(() => {
        const container = this.$el.querySelector('.chat-messages');
        if (container) {
          container.scrollTop = container.scrollHeight;
        }
      });
    },
    formatTime(timestamp) {
      return moment(timestamp).format('HH:mm');
    },
    startPolling() {
      this.polling = setInterval(this.fetchMessages, 3000);
    },
    stopPolling() {
      if (this.polling) {
        clearInterval(this.polling);
      }
    },
  },
  mounted() {
    this.fetchMessages();
    this.startPolling();
  },
  beforeUnmount() {
    this.stopPolling();
  },
};
</script>

<style scoped>
.message {
  max-width: 70%;
  margin-bottom: 0.5rem;
  padding: 0.5rem 1rem;
  border-radius: 1rem;
  word-wrap: break-word;
}
.message.user {
  background-color: #047857;
  color: white;
  margin-left: auto;
}
.message.admin {
  background-color: #e5e7eb;
  color: #111827;
  margin-right: auto;
}
</style>
