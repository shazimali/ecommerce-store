import forms from '@tailwindcss/forms';
import daisyui from 'daisyui';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                // sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'poppins':["Poppins","Poppins"]
            },
            colors: {
                'secondary': '#edf1ff',
                'primary':'#D19C97'
              },
            screens:{
                'xs': '320px',
                // => @media (min-width: 320px) { ... }
                
                'sm': '576px',
                // => @media (min-width: 576px) { ... }
          
                'md': '960px',
                // => @media (min-width: 960px) { ... }
          
                'lg': '1440px',
                // => @media (min-width: 1440px) { ... }
            },
            animation: {
                'infinite-scroll': 'infinite-scroll 25s linear infinite',
            },
            keyframes: {
                'infinite-scroll': {
                    from: { transform: 'translateX(0)' },
                    to: { transform: 'translateX(-100%)' },
                }
            }   
        },
    },

    plugins: [forms,daisyui]
};

