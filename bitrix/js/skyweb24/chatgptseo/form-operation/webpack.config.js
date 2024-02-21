const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const webpack = require('webpack');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const { VueLoaderPlugin } = require("vue-loader");

module.exports = {
    mode: "development",
    entry: {
        index: path.resolve(__dirname, './src/app.js')
    },
    output: {
        path: path.resolve(__dirname, './dist'),
        filename: '[name].bundle.js',
        library: 'Skyweb24ChatGPTAdmin',
        libraryTarget: 'window',
        libraryExport: 'default',
    },
    plugins: [
        new CleanWebpackPlugin(),
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_DEVTOOLS__: true,
        }),
        new MiniCssExtractPlugin({
            filename: '[name].bundle.css'
        }),
        new VueLoaderPlugin(),
    ],
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.css$/i,
                use: [MiniCssExtractPlugin.loader, "css-loader"],
            },
            {
                test: /\.(png|jpe?g|gif)$/i,
                loader: 'file-loader'
            },
        ],
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        }
    }
}