const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    proxy: 'https://d4.by/',
    port: 8083,
  },
  lintOnSave: true,
  publicPath: process.env.NODE_ENV === 'production'
      ? '/'
      : '/'
})