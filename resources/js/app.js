import './bootstrap';

// Import Alpine.js
import Alpine from 'alpinejs';

// Make Alpine available globally
window.Alpine = Alpine;

// Initialize Alpine
document.addEventListener('DOMContentLoaded', () => {
    Alpine.start();
});
