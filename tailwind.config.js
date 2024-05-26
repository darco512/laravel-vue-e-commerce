import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                background: {
                    light: "#FFF4DF",
                    dark: "#FFB4A3"
                },
                main: {
                    "DEFAULT" : "#FFA793",
                    light: "#FFCCC0",
                    dark: "#C56F54"
                },
                button: "#C76548"
            },
            borderRadius: {
                half: '50%',
                full: '9999px'
            },
            spacing: {
                '2%' : "2%",
                '3%' : "3%",
                '4%' : "4%",
                '5%' : "5%",
                '8%' : "8%",
                '10%' : "10%",
                '11%' : "11%",
                '15%' : "15%",
                '17%' : "17%",
                '20%' : "20%",
                '27%' : '27%',
                '30%' : "30%",
                '32%' : '32%',
                '40%' : "40%",
                '42%' : '42%',
                '43%' : '43%',
                '46%' : '46%',
                '90%' : '90%'
            },
            height: {
                rest: "calc(100vh - 65px)"
            },
        },
    },

    plugins: [forms],
};
