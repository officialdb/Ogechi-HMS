import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50:  '#EFF6FF',
                    100: '#DBEAFE',
                    200: '#BFDBFE',
                    300: '#93C5FD',
                    400: '#60A5FA',
                    500: '#3B82F6',
                    600: '#0B5ED7',
                    700: '#1D4ED8',
                    800: '#1E40AF',
                    900: '#062C77',
                    950: '#031445',
                },
            },
            backgroundImage: {
                'hero-gradient':  'linear-gradient(135deg, #062C77 0%, #0B4DB5 55%, #1565C8 100%)',
                'stats-gradient': 'linear-gradient(135deg, #062C77 0%, #0B5ED7 60%, #1565C8 100%)',
                'cta-gradient':   'linear-gradient(135deg, #062C77 0%, #0B5ED7 60%, #1565C8 100%)',
            },
            animation: {
                'float':       'float 3s ease-in-out infinite',
                'float-delay': 'float 3s ease-in-out 1.5s infinite',
                'pulse-ring':  'pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite',
                'fade-in-up':  'fadeInUp 0.6s ease forwards',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%':      { transform: 'translateY(-8px)' },
                },
                'pulse-ring': {
                    '0%':   { boxShadow: '0 0 0 0 rgba(11, 94, 215, 0.45)' },
                    '70%':  { boxShadow: '0 0 0 12px rgba(11, 94, 215, 0)' },
                    '100%': { boxShadow: '0 0 0 0 rgba(11, 94, 215, 0)' },
                },
                fadeInUp: {
                    from: { opacity: '0', transform: 'translateY(28px)' },
                    to:   { opacity: '1', transform: 'translateY(0)' },
                },
            },
            boxShadow: {
                'brand-sm': '0 4px 14px rgba(11, 94, 215, 0.25)',
                'brand-md': '0 8px 30px rgba(11, 94, 215, 0.30)',
                'brand-lg': '0 16px 50px rgba(11, 94, 215, 0.35)',
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
                '4xl': '2rem',
            },
        },
    },

    plugins: [forms],
};
