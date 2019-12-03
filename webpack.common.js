/*
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

const path = require("path");
const webpack = require("webpack");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const extractSass = new ExtractTextPlugin({
  filename: "css/[name].css",
  disable: process.env.NODE_ENV === "development"
});
const providePluginList = {
  $: "jquery",
  jQuery: "jquery",
  "window.jQuery": "jquery",
  Popper: ["popper.js", "default"],
  // Bootstrap scripts
  Alert: "exports-loader?Alert!bootstrap/js/src/alert",
  Button: "exports-loader?Button!bootstrap/js/src/button",
  Carousel: "exports-loader?Carousel!bootstrap/js/src/carousel",
  Collapse: "exports-loader?Collapse!bootstrap/js/src/collapse",
  Dropdown: "exports-loader?Dropdown!bootstrap/js/src/dropdown",
  Modal: "exports-loader?Modal!bootstrap/js/src/modal",
  Popover: "exports-loader?Popover!bootstrap/js/src/popover",
  Scrollspy: "exports-loader?Scrollspy!bootstrap/js/src/scrollspy",
  Tab: "exports-loader?Tab!bootstrap/js/src/tab",
  Tooltip: "exports-loader?Tooltip!bootstrap/js/src/tooltip",
  Util: "exports-loader?Util!bootstrap/js/src/util"
};
const source = "./src/Infrastructure/UserInterface/Web/resources/assets";
const dist = "./src/Infrastructure/UserInterface/Web/Public/assets";

module.exports = {
  entry: {
    base: source + "/base/base.js"
  },
  devtool: "source-map",
  output: {
    path: path.join(__dirname, dist),
    filename: "js/[name].js"
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        include: [
          __dirname + "/js/",
          __dirname + "/node_modules/bootstrap/js/"
        ],
        loader: "babel-loader"
      },
      {
        test: /\.(scss)$/,
        use: extractSass.extract({
          use: [
            {
              loader: "css-loader",
              options: {}
            },
            {
              loader: "postcss-loader"
            },
            {
              loader: "sass-loader"
            }
          ],
          fallback: "style-loader",
          allChunks: true
        })
      },
      {
        test: /\.(gif|png|jpe?g|svg)$/i,
        use: [
          {
            loader: "file-loader",
            options: {
              name: "[name].[ext]",
              outputPath: "images/"
            }
          }
        ]
      }
    ]
  },
  plugins: [
    new webpack.ProvidePlugin(providePluginList),
    new CleanWebpackPlugin(),
    extractSass
  ],
  optimization: {
    splitChunks: {
      cacheGroups: {
        index: {
          name: "index",
          test: "index",
          enforce: true
        },
        bootstrap: {
          name: "bootstrap",
          test: "bootstrap",
          enforce: true
        },
        fontawesome: {
          name: "fontawesome",
          test: "fontawesome",
          enforce: true
        },
        jquery: {
          test: new RegExp("node_modules" + "\\" + path.sep + "jquery.*"),
          chunks: "initial",
          name: "jquery",
          enforce: true
        },
        popper: {
          test: new RegExp("node_modules" + "\\" + path.sep + "popper.*"),
          chunks: "initial",
          name: "popper",
          enforce: true
        }
      }
    }
  }
};
