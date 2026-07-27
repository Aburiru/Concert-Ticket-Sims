import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    server: {
        host: '127.0.0.1',
        port: 5174,
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss({
            content: [
                './resources/**/*.blade.php',
                './resources/**/*.js',
                './resources/**/*.vue',
                './resources/views/**/*.blade.php',
                './storage/framework/views/*.php',
            ],
            theme: {
                extend: {
                    colors: {
                        yellow: '#FFD43B',
                        cyan: '#4CC9F0',
                        pink: '#FF4D8D',
                        success: '#6BCB77',
                        warning: '#FF922B',
                        danger: '#FF6B6B',
                        surface: '#F8F9FA',
                        background: '#FFFFFF',
                        text: '#111111',
                        border: '#E5E5E5',
                        'border-strong': '#000000',
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                        inter: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'bento': '0 4px 24px -4px rgba(0, 0, 0, 0.08), 0 8px 16px -8px rgba(0, 0, 0, 0.06)',
                        'bento-lg': '0 8px 32px -8px rgba(0, 0, 0, 0.1), 0 16px 24px -16px rgba(0, 0, 0, 0.08)',
                        'bento-hover': '0 12px 40px -12px rgba(0, 0, 0, 0.12), 0 20px 32px -20px rgba(0, 0, 0, 0.1)',
                    },
                    borderRadius: {
                        xl: '16px',
                        '2xl': '20px',
                        '3xl': '24px',
                        '4xl': '28px',
                    },
                    borderWidth: {
                        3: '3px',
                        4: '4px',
                    },
                },
            },
        }),
    ],
});
