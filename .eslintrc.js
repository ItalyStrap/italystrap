module.exports = {
	root: true,
	extends: [ 'plugin:@wordpress/eslint-plugin/recommended' ],
	env: {
		browser: true,
		jquery: true,
		node: true,
	},
	globals: {
		wp: 'readonly',
	},
	overrides: [
		{
			files: [ 'assets/ts/**/*.ts', 'webpack.config.js' ],
			rules: {
				camelcase: 'off',
				'jsdoc/check-line-alignment': 'off',
				'jsdoc/check-tag-names': 'off',
				'no-var': 'off',
				'prettier/prettier': 'off',
				'prefer-spread': 'off',
			},
		},
	],
};
