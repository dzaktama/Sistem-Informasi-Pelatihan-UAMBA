/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./admin/**/*.php",
    "./mahasiswa/**/*.php",
    "./templat/**/*.php",
    "./*.php"
  ],
  theme: {
    extend: {
      colors: {
        'amba-hijau-tua': '#445535', 
        'amba-hijau-muda': '#a9b85a', 
        'amba-abu': '#a7aa9d', 
      },
      fontFamily: {
        'sans': ['Inter', 'sans-serif'], 
      }
    },
  },
  plugins: [],
}