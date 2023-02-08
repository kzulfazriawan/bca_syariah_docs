module.exports = (env, options) => {
    console.log(`This is the Webpack 5 'mode': ${options.mode}`);
    return {
        watch: true,
        module: {
            rules: [
                {
                    test: /\.css$/,
                    use: [
                      'style-loader',
                      'css-loader'
                    ]
                }, {
                    test: /\.less$/i,
                    use: [
                        {
                            loader: "style-loader",
                        },
                        {
                            loader: "css-loader",
                        },
                        {
                            loader: "less-loader",
                            options: {
                                lessOptions: {
                                strictMath: true,
                                },
                            },
                        },
                    ]
                }
            ]
        }
    };
}