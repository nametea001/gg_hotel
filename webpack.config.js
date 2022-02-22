const path = require('path');
const webpack = require('webpack');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');

module.exports = {
  entry: {
    'layout/layout': './templates/layout/layout.js',
    'layout/datatables': './templates/layout/datatables.js',
    'web/payment': './templates/web/payment.js',
    'web/room': './templates/web/room.js',
    'web/booking': './templates/web/booking.js',
    
  },
  output: {
    path: path.resolve(__dirname, 'public/assets'),
    publicPath: 'assets/',
  },
  optimization: {
    minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})],
  },
  performance: {
    maxEntrypointSize: 1024000,
    maxAssetSize: 1024000
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [MiniCssExtractPlugin.loader, 'css-loader']
      },
      {
        test: /\.(ttf|eot|svg|woff|woff2)(\?[\s\S]+)?$/,
        include: path.resolve(__dirname, './node_modules/@fortawesome/fontawesome-free/webfonts'),
        use: {
          loader: 'file-loader',
          options: {
            name: '[name].[ext]',
            outputPath: 'webfonts',
            publicPath: '../webfonts',
          },
        }
      },
      {
        test: /\.js$/,
        exclude: path.resolve('node_modules'),
        use: [{
          loader: 'babel-loader',
          options: {
            presets: [
              ['@babel/preset-env']
            ]
          }
        }]
      },
    ],
  },
  plugins: [
    new CleanWebpackPlugin(),
    new ManifestPlugin(),
    new MiniCssExtractPlugin({
      ignoreOrder: false
    }),
  ],
  watchOptions: {
    ignored: ['./node_modules/']
  },
  mode: "development"
};