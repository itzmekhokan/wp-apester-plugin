<?php
/**
 * Settings Class
 *
 * @package wp-apester
 */

namespace ITZ_Me_Khokan\Apester\Inc;

use \ITZ_Me_Khokan\Apester\Inc\Traits\Singleton;

/**
 * Class Settings
 */
class Settings {

	use Singleton;

	/**
	 * Stores the plugins options
	 *
	 * @var array
	 */
	private $options;

	/**
	 * Construct method.
	 */
	protected function __construct() {
		$this->setup_hooks();
	}

	/**
	 * To setup action / filter hooks.
	 *
	 * @return void
	 */
	protected function setup_hooks() {

		$this->options = get_option( 'wp_apester_options' );
		add_filter( 'plugin_action_links_' . WP_APESTER_PLUGIN_BASENAME, array( $this, 'wp_apester_plugin_action_links' ) );
		add_action( 'admin_menu', array( $this, 'wp_apester_add_settings_menu' ) );
		add_action( 'admin_init', array( $this, 'wp_apester_register_settings' ) );
	}

	/**
	 * Apester Plugin Settings link action.
	 *
	 * @return array
	 */
	public function wp_apester_plugin_action_links( $links ) {
		if ( ! is_array( $links ) ) {
			return $links;
		}
		
		$links['settings'] = sprintf( '<a href="%s"> %s </a>',
			esc_url( admin_url( 'options-general.php?page=wp-apester' ) ),
			esc_attr( __( 'Settings', 'wp-apester' ) )
		);

		return $links;
	}

	/**
	 * Apester Configure Settings Menu.
	 *
	 * @return void
	 */
	public function wp_apester_add_settings_menu() {

		$wp_apester_settings_page = add_submenu_page(
			'options-general.php',
			__( 'WP Apester Settings', 'wp-apester' ),
			__( 'WP Apester', 'wp-apester' ),
			'manage_options',
			'wp-apester',
			array( $this, 'wp_apester_settings_callback' )
		);

		// Add help tab for shortcode referance.
		add_action( "load-$wp_apester_settings_page", array( $this, 'wp_apester_settings_add_help_tab' ) );
	}

	/**
	 * Apester Admin Settings Help tab.
	 *
	 * @return void
	 */
	public function wp_apester_settings_add_help_tab () {
		$screen = get_current_screen();

		$content_shortcodes = '<p>' . __( 'Create better engagement with &#8220;WP Apester shortcodes&#8221; in posts content with Apester content.', 'wp-apester' ) . '</p>' .
		'<p>' . __( ' For Apester media, use shortcode <code>[wp_apester_media id="ADD_APESTER_CONTENT_MEDIA_ID"]</code> where attribute <code>id</code> is mandatory for this shortcode.', 'wp-apester' ) . '</p>' .
		'<p>' . __( ' For Apester playlist, use shortcode <code>[wp_apester_playlist]</code> where you can add attribute <code>tags</code> also ( tags values should be in comma separated for multiple tags uses ) to get tags specific data.', 'wp-apester' ) . '</p>' .
		'<p>' . __( ' For Apester playlist with specific tags, use shortcode <code>[wp_apester_playlist tags="ie,fe"]</code>', 'wp-apester' ) . '</p>';

		$screen->add_help_tab( array(
			'id'		=> 'wp_apester_shortcode_help_tab',
			'title'		=> __( 'WP Apester Shortcodes', 'wp-apester' ),
			'content'	=> $content_shortcodes,
		) );
	}

	/**
	 * Apester Admin Settings Callback.
	 *
	 * @return void
	 */
	public function wp_apester_settings_callback() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_attr( __( 'You do not have sufficient permissions to access this page.', 'wp-apester' ) ) );
		}

		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Apester Settings', 'wp-apester' ); ?></h2>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'wp_apester_settings_group' );

					do_settings_sections( 'wp-apester-settings-section' );

					submit_button();
				?>
			</form>
		</div>
		<?php

	}

	/**
	 * Function is used to register the settings.
	 *
	 * @return void
	 */
	public function wp_apester_register_settings() {

		register_setting( 'wp_apester_settings_group', 'wp_apester_options' );

		// Enable Bottom Nav.
		add_settings_section(
			'wp_apester_config_section',
			__( 'Configure Apester', 'wp-apester' ),
			'',
			'wp-apester-settings-section'
		);

		add_settings_field(
			'enable_apester',
			__( 'Enable Apester', 'wp-apester' ),
			array( $this, 'settings_enable_apester_callback' ),
			'wp-apester-settings-section',
			'wp_apester_config_section'
		);

		add_settings_field(
			'channel_token',
			__( 'Add Apester Channel_token', 'wp-apester' ),
			array( $this, 'settings_channel_token_callback' ),
			'wp-apester-settings-section',
			'wp_apester_config_section'
		);

		add_settings_field(
			'playlist_tags',
			__( 'Add Playlist tags', 'wp-apester' ),
			array( $this, 'settings_playlist_tags_callback' ),
			'wp-apester-settings-section',
			'wp_apester_config_section'
		);
	}

	/**
	 * Enable Apester settings callback.
	 *
	 * @return void
	 */
	public function settings_enable_apester_callback() {

		$is_checked = ( isset( $this->options['enable_apester'] ) ) ? esc_attr( $this->options['enable_apester'] ) : 'no';

		printf(
			'<input type="checkbox" id="enable_apester" name="wp_apester_options[enable_apester]" value="yes" %s',
			checked( $is_checked, 'yes', false )
		);

	}

	/**
	 * Add Apester Channel token settings callback.
	 *
	 * @return void
	 */
	public function settings_channel_token_callback() {

		printf(
			'<input type="text" id="channel_token" name="wp_apester_options[channel_token]" value="%s"><p class="description">%s</p>',
			isset( $this->options['channel_token'] ) ? esc_attr( $this->options['channel_token'] ) : '',
			sprintf(
				/* translators: %s URL of Apester Dashboard. */
				__( 'To add Channel token, you have to login  <a href="%s" target="_blank">Apester dashboard</a> first. Then copy your channel token from Manage Channel section.', 'wp-apester' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				esc_url( 'https://console.apester.com/' ),
			)
		);
	}

	/**
	 * Add Apester playlist tags callback.
	 *
	 * @return void
	 */
	public function settings_playlist_tags_callback() {

		printf(
			'<input type="text" class="regular-text" id="playlist_tags" name="wp_apester_options[playlist_tags]" value="%s"><p class="description">%s</p>',
			isset( $this->options['playlist_tags'] ) ? esc_attr( $this->options['playlist_tags'] ) : '',
			esc_attr( __( 'You can add multiple tags separated by comma( , ). Also this settings can be overriden at shortcode level.', 'wp-apester' ) ),
		);
	}

}
