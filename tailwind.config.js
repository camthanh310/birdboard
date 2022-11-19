const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            backgroundColor: {
                'page': 'var(--page-background-color)',
                'card': 'var(--card-background-color)',
                'button': 'var(--button-background-color)',
                'header': 'var(--header-background-color)',
            },
            textColor: {
                'default': 'var(--text-default-color)',
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
