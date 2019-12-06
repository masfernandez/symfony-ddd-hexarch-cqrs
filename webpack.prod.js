/*
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

const merge = require("webpack-merge");
const common = require("./webpack.common.js");

module.exports = merge(common, {
  plugins: []
});