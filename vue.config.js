const { defineConfig } = require('@vue/cli-service');
module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    proxy: 'https://admin.d4.by/',
    port: 8083,
  },
  lintOnSave: true,
  publicPath: '/',
});
