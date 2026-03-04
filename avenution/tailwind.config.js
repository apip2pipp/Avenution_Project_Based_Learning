import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#C62828',
                    dark: '#B71C1C',
                    light: '#EF5350',
                },
                accent: {
                    DEFAULT: '#16A34A',
                    dark: '#15803D',
                    light: '#22C55E',
                },
            },
            borderRadius: {
                'xl': '0.625rem',
            },
        },
    },

    plugins: [forms],
};
