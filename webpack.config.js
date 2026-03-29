const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const { CleanWebpackPlugin } = require( 'clean-webpack-plugin' );

const entrypoints = {
	//
	'js/index': './assets/ts/index.ts',
	'js/editor': './assets/ts/index.ts',
	//
	'css/index': './assets/sass/index.scss',
	'css/editor-style': './assets/sass/editor-style.scss',
	//
	'customizer/live-preview': './assets/ts/customizer/live-preview.ts',
	'customizer/customize-controls':
		'./assets/ts/customizer/customize-controls.ts',
};

const rules = defaultConfig.module.rules.map( ( rule ) => {
	if ( ! Array.isArray( rule.use ) ) {
		return rule;
	}

	const use = rule.use.map( ( loaderConfig ) => {
		if (
			typeof loaderConfig === 'object' &&
			typeof loaderConfig.loader === 'string' &&
			loaderConfig.loader.includes( '/css-loader/' ) &&
			! loaderConfig.loader.includes( 'postcss-loader' )
		) {
			return {
				...loaderConfig,
				options: {
					...( loaderConfig.options || {} ),
					url: false,
				},
			};
		}

		return loaderConfig;
	} );

	return {
		...rule,
		use,
	};
} );

module.exports = {
	...defaultConfig,
	plugins: [
		...defaultConfig.plugins,
		new CleanWebpackPlugin( {
			cleanAfterEveryBuildPatterns: [
				path.resolve( __dirname, `./build/**/*.php` ),
				path.resolve( __dirname, `./build/css/*.js` ),
			],
		} ),
	],
	entry: entrypoints,
	module: {
		...defaultConfig.module,
		rules,
	},
	output: {
		...defaultConfig.output,
		path: path.resolve( process.cwd(), 'build' ),
	},
};
