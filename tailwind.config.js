import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
    './resources/views/**/*.php',
    './resources/views/**/*.blade.php',
    './resources/views/livewire/**/*.blade.php',
  ],
  theme: { extend: {} },
  plugins: [],
}
