/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Livewire/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        // Youth-centric vibrant yellow palette
        'brand': {
          50: '#fff9e6',
          100: '#fff3cc',
          200: '#ffe799',
          300: '#ffdb66',
          400: '#ffcf33',
          500: '#ffc300',  // Main vibrant yellow
          600: '#cc9c00',
          700: '#997500',
          800: '#664e00',
          900: '#332700',
        },
        'accent': {
          50: '#fff5e6',
          100: '#ffeacc',
          200: '#ffd699',
          300: '#ffc166',
          400: '#ffad33',
          500: '#ff9800',  // Energetic orange
          600: '#cc7a00',
          700: '#995b00',
          800: '#663d00',
          900: '#331e00',
        },
        'electric': {
          50: '#e6f7ff',
          100: '#ccefff',
          200: '#99dfff',
          300: '#66cfff',
          400: '#33bfff',
          500: '#00afff',  // Electric blue
          600: '#008ccc',
          700: '#006999',
          800: '#004666',
          900: '#002333',
        },
      },
      animation: {
        'bounce-slow': 'bounce 3s infinite',
        'pulse-fast': 'pulse 1s cubic-bezier(0.4, 0, 0.6, 1) infinite',
        'wiggle': 'wiggle 1s ease-in-out infinite',
        'glow': 'glow 2s ease-in-out infinite',
      },
      keyframes: {
        wiggle: {
          '0%, 100%': { transform: 'rotate(-3deg)' },
          '50%': { transform: 'rotate(3deg)' },
        },
        glow: {
          '0%, 100%': { opacity: '1', boxShadow: '0 0 20px rgba(255, 195, 0, 0.5)' },
          '50%': { opacity: '0.8', boxShadow: '0 0 40px rgba(255, 195, 0, 0.8)' },
        },
      },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
        'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
        'gradient-vibrant': 'linear-gradient(135deg, #ffc300 0%, #ff9800 100%)',
        'gradient-electric': 'linear-gradient(135deg, #00afff 0%, #ffc300 100%)',
      },
      boxShadow: {
        'glow-yellow': '0 0 20px rgba(255, 195, 0, 0.5)',
        'glow-orange': '0 0 20px rgba(255, 152, 0, 0.5)',
        'glow-blue': '0 0 20px rgba(0, 175, 255, 0.5)',
      },
    },
  },
  plugins: [],
}
