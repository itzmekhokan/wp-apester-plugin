<?php
/**
 * Assets Class
 *
 * @package wp-apester
 */

namespace ITZ_Me_Khokan\Apester\Inc;

use \ITZ_Me_Khokan\Apester\Inc\Traits\Singleton;

/**
 * Class Assets
 */
class Assets {

	use Singleton;

	/**
	 * Dependency used by enqued Assets
	 *
	 * @var array
	 */
	private $dependency;

	/**
	 * Version for assets.
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Construct method.
	 */
	protected function __construct() {
		$this->setup_hooks();
		$this->dependency = array( 'jquery' );
		$this->version    = '1.0.0';
	}

	/**
	 * To setup action / filter hooks.
	 *
	 * @return void
	 */
	protected function setup_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_apester_wp_enqueue_scripts' ) );
		add_filter( 'script_loader_tag', array( $this, 'wp_apester_script_loader_tag' ), 99, 2 );
	}

	/**
	 * Apester enqueue frontend scripts.
	 *
	 * @return void
	 */
	public function wp_apester_wp_enqueue_scripts() {
		wp_register_script(
			'wp-apester-web-sdk-core',
			WP_APESTER_URL . '/assets/js/web-sdk.core.legacy.min.js',
			$this->dependency,
			$this->version,
		);

	}

	/**
	 * Hijack the web-sdk-core script to render asyn attribute.
	 *
	 * @param string|mixed $tag    The `<script>` tag for the enqueued script.
	 * @param string       $handle The script's registered handle.
	 * @return string|mixed The filtered script tag.
	 */
	public function wp_apester_script_loader_tag( $tag, $handle ) {
		if ( 'wp-apester-web-sdk-core' !== $handle ) {
			return $tag;
		}
        
    	return str_replace( ' src', ' async="async" src', $tag ); // async the script.
	}

}
