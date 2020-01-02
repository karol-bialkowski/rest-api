const path = require('path');

module.exports = {
    entry: './src/assets/js/index.js',
    output: {
        path: path.join(__dirname, '/public/js'),
        filename: 'index.js'
    },
    devServer: {
        port: 8080
    },
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
            },
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader']
            }
        ]
    }
}