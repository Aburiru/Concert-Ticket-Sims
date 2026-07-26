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
                yellow: '#FFD43B',
                cyan: '#4CC9F0',
                pink: '#FF4D8D',
                success: '#6BCB77',
                warning: '#FF922B',
                danger: '#FF6B6B',
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
                xl: '16px',
                '2xl': '20px',
                '3xl': '24px',
            },
            borderWidth: {
                3: '3px',
                4: '4px',
            },
        },
    },
    plugins: [],
};