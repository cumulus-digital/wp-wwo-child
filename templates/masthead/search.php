<?php
/**
 * Masthead Menu Search Form
 */

namespace WWO_Child;

\defined( 'ABSPATH' ) || exit( 'No direct access allowed.' );

?>
<ul class="search">
	<li>
		<form action="/" method="get">
			<input type="hidden" name="t" value="any">
			<input type="text" name="s" id="search" value="<?php \the_search_query(); ?>">
			<input type="submit" value="Search">
		</form>
	</li>
</ul>