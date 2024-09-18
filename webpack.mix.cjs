const mix = require('laravel-mix');

// Compile JavaScript and CSS
mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       require('postcss-import'),
       require('postcss-nested'),
       require('autoprefixer'),
   ])
   .version();


