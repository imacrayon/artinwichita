let mix = require('laravel-mix')
let tailwindcss = require('tailwindcss')
let cssImport = require('postcss-import')

mix.js('resources/js/app.js', 'public/js')
    .extract(['axios', 'vue'])
    .postCss('resources/css/app.css', 'public/css', [
        cssImport(),
        tailwindcss('./tailwind.js')
    ])
