/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                charcoal: '#1a1a1a',
                slate:    '#4a5568',
                parchment: '#f5f0e8',
                silver:   '#a0aec0',
            },
            fontFamily: {
                serif: ['Georgia', 'Cambria', 'serif'],
                sans:  ['Inter', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [],
}