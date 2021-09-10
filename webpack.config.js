const defaultConfig = require( './node_modules/@wordpress/scripts/config/webpack.config.js' );
const path = require( 'path' );

// Set css-loader's "url" option to false.
let rules = []
defaultConfig.module.rules.forEach(function(rule) {
	if (rule.test.toString().indexOf('.css') < 0) {
		rules.push(rule);
		return;
	}
	let usees = [];
	rule.use.forEach(function(use) {
		if (use.loader.indexOf('/css-loader') < 0) {
			usees.push(use);
			return;
		}
		use.options.url = false;
		usees.push(use);
	});
	rule.use = usees;
});
defaultConfig.module.rules  = rules;

module.exports = {
	...defaultConfig,
	/*
	resolve: { alias: { vue: 'vue/dist/vue.esm.js' } },
	externals: {
		...defaultConfig.externals,
		$: 'jQuery',
		jquery: 'jQuery'
	},
	*/

	entry: {
		//default_variables: path.resolve( process.cwd(), 'src', 'default_variables.scss' ),
		//global: path.resolve( process.cwd(), 'src', 'global.js' ),
		child_backend: path.resolve( process.cwd(), 'src', 'backend.js' ),
		child_frontend: path.resolve( process.cwd(), 'src', 'frontend.js' ),
	},
};