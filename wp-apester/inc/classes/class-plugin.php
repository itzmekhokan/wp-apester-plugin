<?php
/**
 * Plugin manifest class.
 *
 * @package wp-apester
 */

namespace ITZ_Me_Khokan\Apester\Inc;

use \ITZ_Me_Khokan\Apester\Inc\Traits\Singleton;

/**
 * Class Plugin
 */
class Plugin {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		// Load plugin classes.
		Settings::get_instance();

		// Load functionable classes only if Apester settings is enabled.
		$enable_apester = wp_apester_get_options( 'enable_apester' );
		if ( $enable_apester ) {
			Assets::get_instance();
			Shortcodes::get_instance();
		}
		
	}
}
