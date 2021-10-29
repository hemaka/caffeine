const mix = require('laravel-mix');
const { VueLoaderPlugin } = require('vue-loader');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
 mix.js('resources/js/app.js', 'public/js').vue()
 .postCss('resources/css/app.css', 'public/css', [
     //
 ]);

module.exports = {
plugins: [
     new VueLoaderPlugin()
 ],
module: {
 rules: [
   {
     test: /\.s[ac]ss$/i,
     use: [
       // Creates `style` nodes from JS strings
       "style-loader",
       // Translates CSS into CommonJS
       "css-loader",
       // Compiles Sass to CSS
       "sass-loader",
     ],
   },
   { test: /\.vue$/, use: 'vue-loader' },
 ],
},
};