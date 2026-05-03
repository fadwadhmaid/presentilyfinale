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
        'presento': {
          'blue': '#2563EB',
          'violet': '#7C3AED',
          'dark': '#0F172A',
          'light': '#F8FAFC',
          'success': '#22C55E',
          'error': '#EF4444',
          'card': '#1E293B',
        }
      },
      fontFamily: {
        'sans': ['Inter', 'system-ui', 'sans-serif'],
        'heading': ['Poppins', 'system-ui', 'sans-serif'],
      },
      borderRadius: {
        'xl': '12px',
        '2xl': '16px',
      },
      animation: {
        'glow': 'glow 0.3s ease-in-out',
        'fade-slide': 'fadeSlide 0.5s ease-out',
      },
      keyframes: {
        glow: {
          '0%, 100%': { boxShadow: '0 0 5px rgba(37, 99, 235, 0.5)' },
          '50%': { boxShadow: '0 0 20px rgba(124, 58, 237, 0.8)' },
        },
        fadeSlide: {
          '0%': { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },
    },
  },
  plugins: [],
}