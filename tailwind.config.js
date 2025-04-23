import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {

            colors: {
                primary: '#3498DB',
                secondary: '#2ECC71',
                accent: '#FF9800',
                yellow: '#FFC312',
                teal: '#1ABC9C',
                orange: '#E67E22',
                dark: '#2C3E50',
                'dark-blue': '#1e3a8a',
                'light-blue': '#e0f2fe',
            },
            fontFamily: {
                sans: ['Nunito', 'sans-serif'],
                display: ['Fredoka One', 'cursive'],
            },
            boxShadow: {
                'soft': '0 10px 25px -5px rgba(0, 0, 0, 0.05)',
                'hover': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
            }
        },
    },

    plugins: [forms, typography],
};
