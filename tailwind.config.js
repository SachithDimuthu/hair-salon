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
                // Primary brand colors
                primary: {
                    50: '#F3E5F5',
                    100: '#E1BEE7',
                    200: '#CE93D8',
                    300: '#BA68C8',
                    400: '#AB47BC',
                    500: '#9C27B0',
                    600: '#8E24AA',
                    700: '#7B1FA2',
                    800: '#6A1B9A',
                    900: '#4A148C',
                },
                secondary: {
                    50: '#FCE4EC',
                    100: '#F8BBD9',
                    200: '#F48FB1',
                    300: '#F06292',
                    400: '#EC407A',
                    500: '#E91E63',
                    600: '#D81B60',
                    700: '#C2185B',
                    800: '#AD1457',
                    900: '#880E4F',
                },
                // Legacy colors (keep for compatibility)
                luxePurple: '#6A1B9A',
                luxePink: '#E91E63',
                luxeWhite: '#FFFFFF',
                // Neutral palette
                neutral: {
                    50: '#FAFAFA',
                    100: '#F5F5F5',
                    200: '#EEEEEE',
                    300: '#E0E0E0',
                    400: '#BDBDBD',
                    500: '#9E9E9E',
                    600: '#757575',
                    700: '#616161',
                    800: '#424242',
                    900: '#212121',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
                heading: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '128': '32rem',
            },
            boxShadow: {
                'luxe': '0 10px 25px rgba(106, 27, 154, 0.1)',
                'luxe-lg': '0 20px 40px rgba(106, 27, 154, 0.15)',
                'card': '0 4px 6px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1)',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-up': 'slideUp 0.3s ease-out',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(10px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
            },
        },
    },

    plugins: [forms, typography],
};
