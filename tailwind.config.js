module.exports = {
  purge: [
    './resources/views/**/*.blade.php',
    './resources/css/**/*.css',
  ],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['Nunito', 'sans-serif'],
      },
      maxHeight: {
        '400': '400px',
      },
    },
  },
  variants: {},
  plugins: [],
}
