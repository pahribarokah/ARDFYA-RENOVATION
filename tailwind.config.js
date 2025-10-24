/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'brand-green': '#4CAF50',
        'brand-green-light': '#8BC34A',
        'brand-green-dark': '#388E3C',
        'brand-green-lighter': '#C8E6C9',
        'brand-green-darker': '#1B5E20',
      },
      fontFamily: {
        'sans': ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      boxShadow: {
        'card': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
        'card-hover': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
      },
    },
  },
  safelist: [
    'bg-brand-green',
    'text-brand-green',
    'hover:bg-brand-green-dark',
    'hover:text-brand-green',
    'border-brand-green',
  ],
  plugins: [],
} 