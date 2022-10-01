const path = require("path");

module.exports = {
  runtimeCompiler: true,
  configureWebpack: {
    resolve: {
      alias: {
        '@components': path.resolve(__dirname, 'src/components'), 
        '@js': path.resolve(__dirname, 'src/js'), 
        '@assets': path.resolve(__dirname, 'src/assets'), 
        '@plugins': path.resolve(__dirname, 'src/plugins'), 
        '@pages': path.resolve(__dirname, 'src/views'), 
      }
    }
  },
  transpileDependencies: [
    'vuetify'
  ],
}
