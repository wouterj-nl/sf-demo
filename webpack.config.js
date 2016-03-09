var path = require('path');
var ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = {
    debug: true
    , context: path.join(__dirname, 'assets')
    , entry: {
        dashboard: path.join('.', 'app', 'dashboard.jsx')
    }
    , output: {
        filename: '[name].bundle.js'
        , path: path.join(__dirname, 'web', 'assets')
    }

    , module: {
        loaders: [
            { test: /\.jsx$/i, loader: 'babel', query: { presets: ['es2015', 'react'] } }
            , { test: /\.js$/i, loader: 'babel', query: { presets: ['es2015'] } }
            , { test: /\.scss$/i, loaders: ['style', 'css', 'sass'] }
        ]
    }
    , resolve: {
        root: path.join(__dirname, 'assets')
        , extensions: ['', '.js', '.jsx', '.scss', '.css']
        , alias: {
            masonry: path.join(__dirname, 'node_modules', 'masonry-layout', 'masonry.js')
        }
    }

    , plugins: [
        new ExtractTextPlugin('[name].css')
    ]
};
