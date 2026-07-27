/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#3B82F6',
                accent: '#8B5CF6',
                amber: '#F59E0B',
                surface: '#F4F4F5',
                background: '#FFFFFF',
                text: '#18181B',
            },
            boxShadow: {
                bento: '0 4px 24px -4px rgba(0, 0, 0, 0.08), 0 8px 16px -8px rgba(0, 0, 0, 0.06)',
                'bento-lg': '0 8px 32px -8px rgba(0, 0, 0, 0.1), 0 16px 24px -16px rgba(0, 0, 0, 0.08)',
                'bento-hover': '0 12px 40px -12px rgba(0, 0, 0, 0.12), 0 20px 32px -20px rgba(0, 0, 0, 0.1)',
            },
            borderRadius: {
                '3xl': '24px',
                '4xl': '32px',
            }
        },
    },
    plugins: [],
};