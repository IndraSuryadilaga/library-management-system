/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
    ],
    theme: {
        extend: {
            colors: {
                // Base
                cream: {
                    50:  '#FDFAF4',
                    100: '#F7F0E0',
                    200: '#EDE0C8',
                },

                // Brown (Primary)
                bark: {
                    300: '#C4956A',
                    400: '#A67449',
                    500: '#7D5230',
                    600: '#5C3A1E',
                    700: '#3B2110',
                },

                // Teraccota (Accent)
                terra: {
                    300: '#E8A87C',
                    400: '#D4724A',
                    500: '#B85430',
                },

                // === Sage (Secondary Accent)
                sage: {
                    200: '#C8D5B9',
                    400: '#7A9E6E',
                    600: '#4A6741',
                },

                // Neutral
                parchment: '#F2E8D5',
                ink:       '#2C1A0E',
                dusty:     '#9E8A78',
            },

            fontFamily: {
                display: ['"Playfair Display"', 'Georgia', 'serif'],
                body:    ['"DM Sans"', 'system-ui', 'sans-serif'],
                mono:    ['"DM Mono"', 'monospace'],
            },

            borderRadius: {
                'card':  '1rem',
                'card-lg': '1.5rem',
                'pill':  '9999px',
                'btn':   '0.625rem',
            },

            spacing: {
                'bento-gap': '1rem',
                'bento-gap-lg': '1.5rem',
            },

            boxShadow: {
                'card':    '0 2px 8px -1px rgba(60, 33, 16, 0.08), 0 1px 3px -1px rgba(60, 33, 16, 0.04)',
                'card-hover': '0 8px 24px -4px rgba(60, 33, 16, 0.12), 0 2px 8px -2px rgba(60, 33, 16, 0.06)',
                'modal':   '0 24px 64px -8px rgba(60, 33, 16, 0.24)',
                'navbar':  '0 4px 8px 0px rgba(60, 33, 16, 0.08), 0 1px 3px -1px rgba(60, 33, 16, 0.04)',
            },

            transitionDuration: {
                DEFAULT: '150ms',
                'slow': '300ms',
            },

            transitionTimingFunction: {
                'book': 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
            },

            animation: {
                'slide-up': 'slideUp 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)',
                'fade-in':  'fadeIn 0.2s ease-out',
            },

            keyframes: {
                slideUp: {
                    '0%':   { opacity: '0', transform: 'translateY(12px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    '0%':   { opacity: '0' },
                    '100%': { opacity: '1' },
                },
            },
        },
    },
    plugins: [],
}
