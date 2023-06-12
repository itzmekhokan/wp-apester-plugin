<?php
/**
 * WP Apester Custom Functions.
 *
 * @package wp-apester
 */

if ( ! function_exists( 'wp_apester_get_options' ) ) {

	/**
	 * Function is used to get settings of Apester plugin.
	 *
	 * @return string|array|false
	 */
	function wp_apester_get_options( $key = '' ) {
		$options = get_option( 'wp_apester_options' );
		if ( ! $options ) {
			return false;
		}

		if ( $key  ) {
			return isset( $options[ $key ] ) ? $options[ $key ] : '';
		} else {
			return $options;
		}
	}
}

/**
 * Get templates passing attributes and including the file.
 *
 * @param  string $slug file slug like you use in get_template_part without php extension.
 * @param  array  $args pass an array of attributes you want to use in array keys.
 *
 * @return void
 */
function wp_apester_get_template( $slug, $args = [] ) {
	$template_path 	  = WP_APESTER_PATH . '/templates/';
	$template         = sprintf( '%s.php', $slug );
	$located_template = $template_path . $template;

	if ( '' === $located_template ) {
		return;
	}

	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args, EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- Used as an exception as there is no better alternative.
	}

	ob_start();

	include $located_template; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable

	$html = ob_get_clean();

	return $html;
}