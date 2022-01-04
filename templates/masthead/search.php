<?php
/**
 * Masthead Menu Search Form
 */

namespace WWO_Child;

\defined( 'ABSPATH' ) || exit( 'No direct access allowed.' );

?>
<ul role="search" class="search">
	<li>
		<form action="/" method="get" role="search">
			<input type="hidden" name="t" value="any">
			<input type="text" name="s" id="search" value="<?php \the_search_query(); ?>" aria-label="Search" role="searchbox" spellcheck="false">
			<input type="submit" value="Search">
		</form>
	</li>
</ul>