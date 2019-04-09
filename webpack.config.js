/**
 * Webpack Configuration File.
 */
const path = require( 'path' );

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


module.exports = {
	watch: true,
	mode: 'development',
	entry: {
		'./file-changes': './assets/js/custom/file-changes.js',
		'./settings': './assets/js/custom/settings.js'
	},
	output: {
		path: path.resolve( __dirname, 'assets/js/dist' ),
		filename: '[name].js'
	},
	devtool: 'cheap-eval-source-map',
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
			}
		]
	},
	externals: externals
};
