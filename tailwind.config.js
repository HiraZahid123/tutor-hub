/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    fontFamily: {
      Outfit: ["Outfit", "system-ui"],
    },
    extend: {
      colors: {
        primary: "#d3d3d3",
        "primary-light": "#f5f5f5",
        "primary-dark": "#a9a9a9",
        secondary: "#ff6700",
      },
      keyframes: {
        blink: {
          '0%, 100%': { backgroundColor: '#2563eb' },
          '50%': { backgroundColor: '#ff6700' },
        },
      },
      animation: {
        blink: 'blink 1s infinite',
      },
    },
  },
  plugins: [],
};
