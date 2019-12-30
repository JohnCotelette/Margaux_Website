var Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry("app", "./assets/js/app.js")
    .addEntry("homepage", "./assets/js/components/homepage/homepage.js")
    .addEntry("login", "./assets/js/components/others/login.js")
    .addEntry("forgotPassword", "./assets/js/components/others/forgotPassword.js")
    .addEntry("changePassword", "./assets/js/components/others/changePassword.js")
    .addEntry("projectsList", "./assets/js/components/others/projectsList.js")
    .addEntry("projectNew", "./assets/js/components/others/projectNew.js")
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
;

module.exports = Encore.getWebpackConfig();
