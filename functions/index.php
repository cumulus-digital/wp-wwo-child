<?php

namespace WWO_Child;

\defined( 'ABSPATH' ) || exit( 'No direct access allowed.' );

const PARENT_PREFIX = 'cmls_base';
const CHILD_PREFIX  = 'wwo_child';

// Import parent helpers
require \get_template_directory() . '/functions/helpers.php';

//require __DIR__ . '/libs/LeveledMenuWalker.php';

require __DIR__ . '/setup/index.php';
