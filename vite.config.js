import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
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
                './resources/views/**/*.blade.php', // Explicitly add views directory
                './storage/framework/views/*.php',   // For cached views
            ],
            theme: {
                extend: {
                    colors: {
                        // Primary Colors
                        yellow: '#FFD43B',
                        cyan: '#4CC9F0',
                        pink: '#FF4D8D',
                        
                        // Semantic Colors
                        success: '#6BCB77',
                        warning: '#FF922B',
                        danger: '#FF6B6B',
                        
                        // Neutral Colors
                        surface: '#F8F9FA',
                        background: '#FFFFFF',
                        text: '#111111',
                        border: '#000000',
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                        inter: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'neobrutalism': '6px 6px 0px 0px #000000',
                    },
                    borderRadius: {
                        xl: '16px', // Buttons, Input
                        '2xl': '20px', // Cards
                        '3xl': '24px', // Modals
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
