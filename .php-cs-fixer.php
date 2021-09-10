<?php
/*
* PHP-CS-Fixer project configuration
*/
$config = new PhpCsFixer\Config();
require_once __DIR__ . '/vendor/cumulus-digital/wp-php-cs-fixer/loader.php';

// Load WP core classes/functions/constants for qualifying
$wp_core      = \str_getcsv( \file_get_contents( __DIR__ . '/.php-cs-fixer/wp-core.csv' ) );
$NFI_includes = \array_filter( \array_merge(
	['@compiler_optimized'],
	['@internal'],
	$wp_core
) );

return $config
	->registerCustomFixers( [
		new WeDevs\Fixer\SpaceInsideParenthesisFixer(),
		new WeDevs\Fixer\BlankLineAfterClassOpeningFixer(),
	] )
	->setRiskyAllowed( true )
	->setIndent( "\t" )
	->setRules( \array_merge(
		WeDevs\Fixer\Fixer::rules(),
		[
			'@PSR2' => true,
			// Each element of an array must be indented exactly once.
			'array_indentation' => true,
			// Replace non multibyte-safe functions with corresponding mb function.
			'mb_str_functions' => true,
			// Add leading `\` before constant invocation of internal constant to speed up resolving. Constant name match is case-sensitive, except for `null`, `false` and `true`.
			'native_constant_invocation' => true,
			// Add leading `\` before function invocation to speed up resolving.
			'native_function_invocation' => ['strict' => false, 'include' => $NFI_includes],
			// Master language constructs shall be used instead of aliases.
			'no_alias_language_construct_call' => true,
			// PHP single-line arrays should not have trailing comma.
			'no_trailing_comma_in_singleline_array' => true,
			// Remove trailing whitespace at the end of blank lines.
			'no_whitespace_in_blank_line' => true,
			// Logical NOT operators (`!`) should have leading and trailing whitespaces.
			'not_operator_with_space' => true,
			// Standardize spaces around ternary operator.
			'ternary_operator_spaces' => true,
			// Multi-line arrays, arguments list and parameters list must have a trailing comma.
			'trailing_comma_in_multiline' => true,
			// Replace control structure alternative syntax to use braces.
			'no_alternative_syntax' => false,
		],
		/*
		[
			'WeDevs/space_inside_parenthesis' => true,
			'WeDevs/blank_line_after_class_opening' => true,
			'@PSR2' => true,
			// Each line of multi-line DocComments must have an asterisk [PSR-5] and must be aligned with the first one.
			'align_multiline_comment' => true,
			// PHP arrays should be declared using the configured syntax.
			'array_syntax' => ['syntax'=>'short'],
			// Binary operators should be surrounded by space as configured.
			'binary_operator_spaces' => ['default'=>'align_single_space_minimal','operators'=>['=>'=>'align_single_space_minimal']],
			// Ensure there is no code on the same line as the PHP open tag and it is followed by a blank line.
			'blank_line_after_opening_tag' => true,
			// An empty line feed must precede any configured statement.
			'blank_line_before_statement' => ['statements'=>['break','case','continue','declare','do','for','foreach','if','return','throw','try','while']],
			// The body of each structure MUST be enclosed by braces. Braces should be properly placed. Body of braces should be properly indented.
			'braces' => ['allow_single_line_closure'=>false,'position_after_functions_and_oop_constructs'=>'same'],
			// A single space or none should be between cast and variable.
			'cast_spaces' => true,
			// Class, trait and interface elements must be separated with one or none blank line.
			'class_attributes_separation' => true,
			// Whitespace around the keywords of a class, trait or interfaces definition should be one space.
			'class_definition' => ['single_line'=>true],
			// Concatenation should be spaced according configuration.
			'concat_space' => ['spacing'=>'one'],
			// Replaces short-echo `<?=` with long format `<?php echo`/`<?php print` syntax, or vice-versa.
			'echo_tag_syntax' => true,
			// Transforms imported FQCN parameters and return types in function arguments to short version.
			'fully_qualified_strict_types' => true,
			// Ensure single space between function's argument and its typehint.
			'function_typehint_space' => true,
			// Imports or fully qualifies global classes/functions/constants.
			'global_namespace_import' => true,
			// Include/Require and file path should be divided with a single space. File path should not be placed under brackets.
			'include' => true,
			// List (`array` destructuring) assignment should be declared using the configured syntax. Requires PHP >= 7.1.
			'list_syntax' => ['syntax'=>'long'],
			// Cast should be written in lower case.
			'lowercase_cast' => true,
			// Class static references `self`, `static` and `parent` MUST be in lower case.
			'lowercase_static_reference' => true,
			// Magic constants should be referred to using the correct casing.
			'magic_constant_casing' => true,
			// Magic method definitions and calls must be using the correct casing.
			'magic_method_casing' => true,
			// Method chaining MUST be properly indented. Method chaining with different levels of indentation is not supported.
			'method_chaining_indentation' => true,
			// Function defined by PHP should be called using the correct casing.
			'native_function_casing' => true,
			// Native type hints for functions should use the correct case.
			'native_function_type_declaration_casing' => true,
			// All instances created with new keyword must be followed by braces.
			'new_with_braces' => true,
			// There should not be blank lines between docblock and the documented element.
			'no_blank_lines_after_phpdoc' => true,
			// There should not be any empty comments.
			'no_empty_comment' => true,
			// There should not be empty PHPDoc blocks.
			'no_empty_phpdoc' => true,
			// Remove useless (semicolon) statements.
			'no_empty_statement' => true,
			// Removes extra blank lines and/or blank lines following configuration.
			'no_extra_blank_lines' => ['tokens'=>['extra','parenthesis_brace_block','square_brace_block','throw','use']],
			// Remove leading slashes in `use` clauses.
			'no_leading_import_slash' => true,
			// The namespace declaration line shouldn't contain leading whitespace.
			'no_leading_namespace_whitespace' => true,
			// Either language construct `print` or `echo` should be used.
			'no_mixed_echo_print' => true,
			// Operator `=>` should not be surrounded by multi-line whitespaces.
			'no_multiline_whitespace_around_double_arrow' => true,
			// Short cast `bool` using double exclamation mark should not be used.
			'no_short_bool_cast' => true,
			// Single-line whitespace before closing semicolon are prohibited.
			'no_singleline_whitespace_before_semicolons' => true,
			// There MUST NOT be spaces around offset braces.
			'no_spaces_around_offset' => ['positions' => ['outside']],
			// There MUST NOT be a space after the opening parenthesis. There MUST NOT be a space before the closing parenthesis.
			'no_spaces_inside_parenthesis' => false,
			// Removes `@param`, `@return` and `@var` tags that don't provide any useful information.
			'no_superfluous_phpdoc_tags' => ['allow_mixed'=>true,'allow_unused_params'=>true],
			// Remove trailing commas in list function calls.
			'no_trailing_comma_in_list_call' => true,
			// PHP single-line arrays should not have trailing comma.
			'no_trailing_comma_in_singleline_array' => true,
			// Removes unneeded parentheses around control statements.
			'no_unneeded_control_parentheses' => true,
			// Removes unneeded curly braces that are superfluous and aren't part of a control structure's body.
			'no_unneeded_curly_braces' => true,
			// A `final` class must not have `final` methods and `private` methods must not be `final`.
			'no_unneeded_final_method' => true,
			// Unused `use` statements must be removed.
			'no_unused_imports' => true,
			// In array declaration, there MUST NOT be a whitespace before each comma.
			'no_whitespace_before_comma_in_array' => true,
			// Remove trailing whitespace at the end of blank lines.
			'no_whitespace_in_blank_line' => true,
			// Array index should always be written by using square braces.
			'normalize_index_brace' => true,
			// There should not be space before or after object operators `->` and `?->`.
			'object_operator_without_whitespace' => true,
			// Ordering `use` statements.
			'ordered_imports' => true,
			// PHPUnit annotations should be a FQCNs including a root namespace.
			'php_unit_fqcn_annotation' => true,
			// All items of the given phpdoc tags must be either left-aligned or (by default) aligned vertically.
			'phpdoc_align' => true,
			// PHPDoc annotation descriptions should not be a sentence.
			'phpdoc_annotation_without_dot' => true,
			// Docblocks should have the same indentation as the documented subject.
			'phpdoc_indent' => true,
			// Fixes PHPDoc inline tags.
			'phpdoc_inline_tag_normalizer' => true,
			// `@access` annotations should be omitted from PHPDoc.
			'phpdoc_no_access' => true,
			// No alias PHPDoc tags should be used.
			'phpdoc_no_alias_tag' => true,
			// `@package` and `@subpackage` annotations should be omitted from PHPDoc.
			'phpdoc_no_package' => true,
			// Classy that does not inherit must not have `@inheritdoc` tags.
			'phpdoc_no_useless_inheritdoc' => true,
			// The type of `@return` annotations of methods returning a reference to itself must the configured one.
			'phpdoc_return_self_reference' => true,
			// Scalar types should always be written in the same form. `int` not `integer`, `bool` not `boolean`, `float` not `real` or `double`.
			'phpdoc_scalar' => true,
			// Annotations in PHPDoc should be grouped together so that annotations of the same type immediately follow each other, and annotations of a different type are separated by a single blank line.
			'phpdoc_separation' => true,
			// Single line `@var` PHPDoc should have proper spacing.
			'phpdoc_single_line_var_spacing' => true,
			// Docblocks should only be used on structural elements.
			'phpdoc_to_comment' => true,
			// PHPDoc should start and end with content, excluding the very first and last line of the docblocks.
			'phpdoc_trim' => true,
			// Removes extra blank lines after summary and after description in PHPDoc.
			'phpdoc_trim_consecutive_blank_line_separation' => true,
			// The correct case must be used for standard PHP types in PHPDoc.
			'phpdoc_types' => true,
			// Sorts PHPDoc types.
			'phpdoc_types_order' => ['null_adjustment'=>'always_last','sort_algorithm'=>'none'],
			// `@var` and `@type` annotations of classy properties should not contain the name.
			'phpdoc_var_without_name' => true,
			// There should be one or no space before colon, and one space after it in return type declarations, according to configuration.
			'return_type_declaration' => true,
			// Instructions must be terminated with a semicolon.
			'semicolon_after_instruction' => true,
			// Cast `(boolean)` and `(integer)` should be written as `(bool)` and `(int)`, `(double)` and `(real)` as `(float)`, `(binary)` as `(string)`.
			'short_scalar_cast' => true,
			// There should be exactly one blank line before a namespace declaration.
			'single_blank_line_before_namespace' => true,
			// Single-line comments and multi-line comments with only one line of actual content should use the `//` syntax.
			'single_line_comment_style' => ['comment_types'=>['hash']],
			// Throwing exception must be done in single line.
			'single_line_throw' => true,
			// Convert double quotes to single quotes for simple strings.
			'single_quote' => true,
			// Ensures a single space after language constructs.
			'single_space_after_construct' => true,
			// Each trait `use` must be done as single statement.
			'single_trait_insert_per_statement' => true,
			// Fix whitespace after a semicolon.
			'space_after_semicolon' => ['remove_in_empty_for_expressions'=>true],
			// Increment and decrement operators should be used if possible.
			'standardize_increment' => true,
			// Replace all `<>` with `!=`.
			'standardize_not_equals' => true,
			// Standardize spaces around ternary operator.
			'ternary_operator_spaces' => true,
			// Multi-line arrays, arguments list and parameters list must have a trailing comma.
			'trailing_comma_in_multiline' => ['after_heredoc'=>true],
			// In array declaration, there MUST be a whitespace after each comma.
			'whitespace_after_comma_in_array' => true,
		]
		*/
	) )
	->setFinder(
		PhpCsFixer\Finder::create()
			->exclude( 'vendor' )
			->in( __DIR__ )
	);
