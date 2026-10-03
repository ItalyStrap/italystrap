const wordpressConfig = require( '@wordpress/prettier-config' );

module.exports = {
	...wordpressConfig,
	overrides: [
		...( wordpressConfig.overrides || [] ),
		{
			files: 'assets/**/*.{css,scss,js,ts}',
			options: {
				useTabs: false,
				tabWidth: 4,
			},
		},
	],
};
