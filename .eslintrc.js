module.exports = {
	root: true,
	extends: 'eslint:recommended',
	globals: {
		wp: true,
	},
	env: {
		node: true,
		es6: true,
		amd: true,
		browser: true,
		jquery: true,
	},
	parserOptions: {
		ecmaFeatures: {
			globalReturn: true,
			generators: false,
			objectLiteralDuplicateProperties: false,
			experimentalObjectRestSpread: true,
		},
		ecmaVersion: 2017,
		sourceType: 'module',
	},
	plugins: ['import'],
	settings: {
		'import/core-modules': [],
		'import/ignore': [
			'node_modules',
			'\\.(coffee|scss|css|less|hbs|svg|json)$',
		],
	},
	rules: {},
};
