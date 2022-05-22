const mix = require("laravel-mix");
var LiveReloadPlugin = require("webpack-livereload-plugin");

mix.webpackConfig({
  plugins: [new LiveReloadPlugin()],
});

mix
  .setPublicPath("public/dist")
  .js("src/js/app.js", "public/dist")
  .sass("src/css/style.scss", "public/dist")
  .postCss("src/css/theme.css", "public/dist", [
    require("tailwindcss"),
    require("postcss-nested"),
  ]);
