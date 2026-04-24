/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        success: '#10b981',
        danger: '#ef4444',
        brand: '#3b82f6',
      }
    },
  },
  plugins: [],
}