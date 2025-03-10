/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{html,js}",
    "./admin/**/*.{html,js,ts,jsx,tsx}",
    "./templates/**/*.html",
  ],
  theme: {
    extend: {
      screens: {
        'zoomOut': '1300px', 
        'phone': '480px', // Example phone size
        'sm': '640px',
        'md': '768px',
        'laptop': '1024px', // Example laptop size
        'xl': '1280px',
        '2xl': '1536px',
      },
      fontFamily: {
        'russo': ['Russo One', 'sans-serif'], 
        'montserrat': ['Montserrat', 'sans-serif'], 
      },
      colors: {
        'white-50': '#fafafa', // A slightly off-white
        'white-100': '#f5f5f5', // Another variation
        'white-200': '#eeeeee',
        'white-300': '#e0e0e0',
        'off-white-100': '#f8f8ff', // Ghost White
        'off-white-200': '#f5f5f5', // Anti-white
        'off-white-300': '#fafafa', // Light Gray
        'eggshell': '#f5f0e8', // Eggshell
        'dark-blue': '#1E3A8A', // Replace with your desired hex code
        'deep-dark-blue': '#0F172A',
        'another-dark-blue' : '#29467F',
        blue: {
          500: '#2196f3',
          600: '#1e88e5',
          700: '#1976d2',
        },
        orange: {
          50: '#fff3e0',
          100: '#ffe0b3',
          200: '#ffd180',
          300: '#ffc24d',
          400: '#ffb31a',
          500: '#ff9800',
          600: '#f57c00',
          700: '#e65100',
          800: '#d84315',
          900: '#bf360c',
          950: '#FF4D16', // Added 950 for deeper shades
        },
        amber: { // You can create a whole amber palette if you want
          50: '#fef3c7', // Lighter amber (optional)
          100: '#fde047', // Slightly lighter amber (optional)
          200: '#fcd34d', // Another variation
          300: '#facc15', // Another variation
          400: '#fbbf24', // Your specific amber color
          500: '#f59e0b', // A darker amber (optional)
          600: '#eab308', // Even darker (optional)
          700: '#ca8a04', // Even darker (optional)
          800: '#a16207', // Even darker (optional)
          900: '#713f12', // Even darker (optional)
        },
        red: {
          50: '#ffebee',
          100: '#ffcdd2',
          200: '#ef9a9a',
          300: '#e57373',
          400: '#ef5350',
          500: '#f44336',
          600: '#e53935',
          700: '#d32f2f',
          800: '#c62828',
          900: '#b71c1c',
          950: '#671311', // Added 950 for deeper shades
        },
        yellow: {
          50: '#fffde7',
          100: '#fff9c4',
          200: '#fff59d',
          300: '#fff176',
          400: '#ffee58',
          500: '#ffeb3b',
          600: '#fdd835',
          700: '#f9a61a',
          800: '#f57f17',
          900: '#e64a19',
          950: '#9d340f', // Added 950 for deeper shades
        },
        gray: {
          50: '#fafafa',
          100: '#f5f5f5',
          200: '#eeeeee',
          300: '#e0e0e0',
          400: '#bdbdbd',
          500: '#9e9e9e',
          600: '#757575',
          700: '#616161',
          800: '#424242',
          900: '#212121',
          950: '#141414', // Added 950 for deeper shades
        },
      },
      spacing: {
        '0.5': '2px',
        '1.5': '6px',
        '2.5': '10px',
        '3.5': '14px',
        '7': '28px',
        '9': '36px',
        '11': '44px',
        '14': '56px',
        '18': '72px',
        '22': '88px',
        '28': '112px',
        '36': '144px',
        '44': '176px',
        '52': '208px',
        '60': '240px',
        '68': '272px',
        '76': '304px',
        '84': '336px',
        '92': '368px',
      },
    },
  },
  plugins: [],
}
