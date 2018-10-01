let mix = require('laravel-mix')

mix.webpackConfig({
    plugins: [
        // Move all svgs in `icons` directory into sprite sheet
        new (require('svg-spritemap-webpack-plugin'))({
            src: 'resources/icons/**/*.svg',
            filename: 'img/icons.svg',
            prefix: 'icon-',
            svgo: {
                plugins: [
                    { removeUnknownsAndDefaults: true },
                    { removeAttrs: { attrs: '(stroke|fill)' } },
                ],
            },
        }),
    ],
})

mix.js('resources/js/app.js', 'public/js')
    .extract(['axios', 'vue'])
    .postCss('resources/css/app.css', 'public/css')
    .options({
        postCss: [
            require('postcss-import')(),
            require('tailwindcss')('./tailwind.js'),
            require('postcss-nesting')(),
        ],
    })

if (mix.inProduction()) {
    mix.version()
}
