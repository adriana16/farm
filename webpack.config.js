var Encore = require('@symfony/webpack-encore');

Encore
// directory where compiled assets will be stored
    .setOutputPath('web/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './web/js/globals.js')
    .addEntry('box', './web/js/box.js')
    .addEntry('auction', './web/js/auction.js')
    //.addEntry('page2', './assets/js/page2.js')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .cleanupOutputBeforeBuild()
    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()
    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()
    //.disableSingleRuntimeChunk()
    // create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(false) //.enableVersioning(Encore.isProduction())
    .enableSourceMaps(true) //.enableSourceMaps(!Encore.isProduction())
    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()
    // show OS notifications when builds finish/fail
    .enableBuildNotifications()
    .configureBabel(() => {}, {
        useBuiltIns: false
    })
    .enableVueLoader()
;

module.exports = Encore.getWebpackConfig();
