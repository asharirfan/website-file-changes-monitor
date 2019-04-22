/**
 * Webpack Configuration File.
 */
const path = require( 'path' );
const autoprefixer = require( 'autoprefixer' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const FixStyleOnlyEntriesPlugin = require( 'webpack-fix-style-only-entries' );

/**
 * Given a string, returns a new string with dash separators converted to
 * camel-case equivalent. This is not as aggressive as `_.camelCase`, which
 * which would also upper-case letters following numbers.
 *
 * @param {string} string Input dash-delimited string.
 *
 * @return {string} Camel-cased string.
 */
const camelCaseDash = string => string.replace( /-([a-z])/g, ( match, letter ) => letter.toUpperCase() );

/**
 * Define externals to load components through the wp global.
 */
const externals = [
	'components',
	'compose',
	'edit-post',
	'element',
	'plugins',
	'editor',
	'blocks',
	'hooks',
	'utils',
	'date',
	'data',
	'i18n'
].reduce(
	( externals, name ) => ({
		...externals,
		[ `@wordpress/${ name }` ]: `wp.${ camelCaseDash( name ) }`
	}),
	{
		wp: 'wp',
		react: 'React', // React itself is there in Gutenberg.
		'react-dom': 'ReactDOM',
		lodash: 'lodash' // Lodash is there in Gutenberg.
	}
);

const PluginStylesheetsConfig = ( mode ) => {
	return [
		MiniCssExtractPlugin.loader,
		'css-loader',
		{
			loader: 'postcss-loader',
			options: {
				ident: 'postcss',
				plugins: [
					autoprefixer({
						browsers: [
							'>1%',
							'last 4 versions',
							'Firefox ESR',
							'not ie < 9' // React doesn't support IE8 anyway
						],
						flexbox: 'no-2009'
					})
				]
			}
		},
		{
			loader: 'sass-loader',
			options: {
				outputStyle: 'production' === mode ? 'compressed' : 'nested'
			}
		}
	];
};

const recursiveIssuer = ( m ) => {
	if ( m.issuer ) {
		return recursiveIssuer( m.issuer );
	} else if ( m.name ) {
		return m.name;
	} else {
		return false;
	}
};

module.exports = ( env, options ) => {
	const mode = options.mode;
	const suffix = 'production' === mode ? '.min' : '';

	const config = {
		watch: 'development' === mode ? true : false,
		entry: {
			'file-changes': './assets/js/src/file-changes.js',
			'build.file-changes': './assets/css/src/file-changes.scss',
			'settings': './assets/js/src/settings.js',
			'build.settings': './assets/css/src/settings.scss',
			'common': './assets/js/src/common.js'
		},
		output: {
			path: path.resolve( __dirname, 'assets/js/dist' ),
			filename: `[name]${suffix}.js`
		},
		optimization: {
			splitChunks: {
				cacheGroups: {
					settingsStyles: {
						name: 'build.settings',
						test: ( m, c, entry = 'settings' ) => 'CssModule' === m.constructor.name && recursiveIssuer( m ) === entry,
						chunks: 'all',
						enforce: true
					},
					fileChangesStyles: {
						name: 'build.file-changes',
						test: ( m, c, entry = 'file-changes' ) => 'CssModule' === m.constructor.name && recursiveIssuer( m ) === entry,
						chunks: 'all',
						enforce: true
					}
				}
			}
		},
		devtool: 'development' === mode ? 'cheap-eval-source-map' : false,
		module: {
			rules: [
				{
					test: /\.(js|jsx|mjs)$/,
					exclude: /node_modules/,
					use: {
						loader: 'babel-loader',
						options: {
							babelrc: false,
							presets: [ '@babel/preset-env', '@babel/preset-react' ],
							cacheDirectory: true
						}
					}
				},
				{
					test: /\.s?css$/,
					use: PluginStylesheetsConfig( mode )
				}
			]
		},
		externals: externals,
		plugins: [
			new MiniCssExtractPlugin({
				filename: `../../css/dist/[name]${suffix}.css`
			}),
			new FixStyleOnlyEntriesPlugin()
		]
	};

	return config;
};
