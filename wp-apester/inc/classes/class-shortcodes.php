<?php
/**
 * Shortcodes Class
 *
 * @package wp-apester
 */

namespace ITZ_Me_Khokan\Apester\Inc;

use \ITZ_Me_Khokan\Apester\Inc\Traits\Singleton;

/**
 * Class Shortcodes
 */
class Shortcodes {

	use Singleton;

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
		$shortcodes = array(
			'wp_apester_media'		=> __CLASS__ . '::wp_apester_media',
			'wp_apester_playlist' 	=> __CLASS__ . '::wp_apester_playlist',
			'wp_apester_strip' 		=> __CLASS__ . '::wp_apester_strip',
		);

		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}
	}

	/**
	 * Display apester media template.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function wp_apester_media( $atts ) {

		if ( empty( $atts ) ) {
			return '';
		}

		$atts = shortcode_atts(
			array(
				'id'		=> '',
				'class'     => '',
			),
			$atts,
			'wp_apester_media'
		);

		$media_id = '';
		if ( ! empty( $atts['id'] ) ) {
			$media_id = esc_attr( $atts['id'] );
		}

		if ( ! $media_id ) {
			return '';
		}
		
		// Enqueue scripts.
		wp_enqueue_script( 'wp-apester-web-sdk-core' );

		ob_start();

		echo wp_kses_post( wp_apester_get_template( 
			'wp-apester-media',
			array( 
				'attr' => $atts 
			)
		) );

		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Display apester playlist template.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function wp_apester_playlist( $atts ) {

		$atts = shortcode_atts(
			array(
				'class'     => '',
				'context'	=> true,
				'fallback'	=> true,
				'tags'		=> '',
			),
			$atts,
			'wp_apester_playlist'
		);

		$token = wp_apester_get_options( 'channel_token' );

		if ( ! $token ) {
			return '';
		}

		// Add global playlist tags if have.
		$playlist_tags = wp_apester_get_options( 'playlist_tags' );
		if ( empty( $atts['tags'] ) && $playlist_tags ) {
			$atts['tags'] = $playlist_tags;
		}
		
		// Enqueue scripts.
		wp_enqueue_script( 'wp-apester-web-sdk-core' );

		ob_start();

		echo wp_kses_post( wp_apester_get_template( 
			'wp-apester-playlist',
			array( 
				'token'	=> $token,
				'attr' 	=> $atts 
			)
		) );

		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Display apester strip template.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function wp_apester_strip( $atts ) {

		$atts = shortcode_atts(
			array(
			),
			$atts,
			'wp_apester_strip'
		);

		$token = wp_apester_get_options( 'channel_token' );

		if ( ! $token ) {
			return '';
		}
		
		// Enqueue scripts.
		wp_enqueue_script( 'wp-apester-web-sdk-core' );

		ob_start();

		echo wp_kses_post( wp_apester_get_template( 
			'wp-apester-strip',
			array( 
				'token'	=> $token,
				'attr' 	=> $atts 
			)
		) );

		$html = ob_get_clean();

		return $html;
	}

}
