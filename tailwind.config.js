import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Livewire/**/*.php',
        './app/Filament/**/*.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#3D5FEA',
                    50: '#f0f3ff',
                    100: '#e1e7ff',
                    200: '#c8d2ff',
                    300: '#a1b2ff',
                    400: '#7088ff',
                    500: '#3d5fea',
                    600: '#2a46d6',
                    700: '#2034b7',
                    800: '#1d2a94',
                    900: '#1b2476',
                    950: '#101449',
                },
                secondary: {
                    DEFAULT: '#64748B',
                }
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                outfit: ['Outfit', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02)',
                'soft-lg': '0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04)',
                'soft-xl': '0 20px 35px -5px rgba(0, 0, 0, 0.05), 0 10px 15px -8px rgba(0, 0, 0, 0.05)',
            },
            borderRadius: {
                'xl': '1rem',
                '2xl': '1.5rem',
            }
        },
    },

    plugins: [forms],
};
