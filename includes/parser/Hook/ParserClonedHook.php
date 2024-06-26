<?php

namespace MediaWiki\Hook;

use MediaWiki\Parser\Parser;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ParserCloned" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ParserClonedHook {
	/**
	 * This hook is called when the parser is cloned.
	 *
	 * @since 1.35
	 *
	 * @param Parser $parser Newly-cloned Parser object
	 * @return bool|void True or no return value to continue or false to abort
	 */
	public function onParserCloned( $parser );
}
