const defaultConfig = require( './node_modules/@wordpress/scripts/config/webpack.config.js' );
const path = require( 'path' );

// Set css-loader's "url" option to false.
// Silence sass-loader's @import deprecation warnings.
let rules = []
defaultConfig.module.rules.forEach(function(rule) {
	if (rule.test.toString().indexOf('.css') < 0 && !rule.test.test('.scss')) {
		rules.push(rule);
		return;
	}
	let usees = [];
	rule.use.forEach(function(use) {
		if (use.loader.indexOf('/sass-loader') > -1) {
			use.options.sassOptions = {
				...use.options.sassOptions,
				quietDeps: true,
				silenceDeprecations: [ 'import' ],
			};
			usees.push(use);
			return;
		}
		if (use.loader.indexOf('/css-loader') < 0) {
			usees.push(use);
			return;
		}
		use.options.url = false;
		usees.push(use);
	});
	rule.use = usees;
	rules.push(rule);
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