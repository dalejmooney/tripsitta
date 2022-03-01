const mix = require('laravel-mix');
//require('laravel-mix-merge-manifest');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix
//     .js('resources/js/app.js', 'public/js').version()
//     .js('resources/js/helpers.js', 'public/js').version()
//     .js('resources/js/pages/home.js', 'public/js/pages/').version()
//     .js('resources/js/pages/search.js', 'public/js/pages/').version()
//     .js('resources/js/pages/search-babysitter.js', 'public/js/pages/').version()
//     .js('resources/js/pages/profile-experience.js', 'public/js/pages/').version()
//     .js('resources/js/pages/profile-about-me.js', 'public/js/pages/').version()
//     .js('resources/js/pages/babysitter-availability.js', 'public/js/pages/').version()
//     .js('resources/js/pages/parent-profile-children.js', 'public/js/pages/').version()
//     .js('resources/js/pages/profile-submit-application.js', 'public/js/pages/').version()
//     .js('resources/js/pages/book-now.js', 'public/js/pages/').version()
//     .js('resources/js/pages/book-now-payment.js', 'public/js/pages/').version()
//     .sass('resources/sass/app.scss', 'public/css').version()
//
//     .sass('resources/sass/app-admin.scss', 'public/assets/admin/css').version()
//     .js('resources/js/app-admin.js', 'public/assets/admin/js').version()
//     .mergeManifest();


let fs  = require('fs');

let getFiles = function (dir) {
    // get all 'files' in this directory
    // filter directories
    return fs.readdirSync(dir).filter(file => {
        return fs.statSync(`${dir}/${file}`).isFile();
    });
};

getFiles('resources/js/pages').forEach(function (JSpath) {
    mix.js('resources/js/pages/' + JSpath, 'public/js/pages').version();
});


mix
    .js('resources/js/app.js', 'public/js').version()
    .js('resources/js/helpers.js', 'public/js').version()
    .js('resources/js/rater.js', 'public/js').version()

    .sass('resources/sass/app.scss', 'public/css').version()
    .sass('resources/sass/app-admin.scss', 'public/assets/admin/css').version()
    .js('resources/js/app-admin.js', 'public/assets/admin/js').version();
