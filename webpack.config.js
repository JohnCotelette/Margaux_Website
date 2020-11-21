var Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry("app", "./assets/js/app.js")
    .addEntry("homepage", "./assets/js/components/homepage/homepage.js")
    .addEntry("about", "./assets/js/components/others/about.js")
    .addEntry("login", "./assets/js/components/others/login.js")
    .addEntry("forgotPassword", "./assets/js/components/others/forgotPassword.js")
    .addEntry("changePassword", "./assets/js/components/others/changePassword.js")
    .addEntry("projectsList", "./assets/js/components/others/projectsList.js")
    .addEntry("projectNew", "./assets/js/components/others/projectNew.js")
    .addEntry("404", "./assets/js/components/errors/404.js")
    .autoProvidejQuery()
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .copyFiles({
        from: "./assets/img",
        to: "images/[path][name].[hash:8].[ext]",
    })
;

module.exports = Encore.getWebpackConfig();
