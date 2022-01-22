// Load the default @wordpress/scripts config object
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );


// Use the defaultConfig but replace the entry and output properties
module.exports = {
	...defaultConfig,
	entry: {
		'TailwindApp': path.resolve( __dirname, 'admin/src/TailwindApp.js' ),
	},
	resolve: {
		alias: {
			...defaultConfig.resolve.alias,
			'@Admin': path.resolve( __dirname, 'admin/src/' ),
		},
	},
	output: {
		filename: '[name].js',
		path: path.resolve( __dirname, 'admin/build' ),
	},
	plugins: [
		...defaultConfig.plugins.filter( function ( plugin ) {
			if ( plugin.constructor.name === 'LiveReloadPlugin' ) {
				return false;
			}

			return true;
		} ),
	],
};