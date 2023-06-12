<?php
/**
 * WP Apester Integration
 * 
 * @package   wp-apester
 * @author    Khokan Sardar <itzmekhokan@gmail.com>
 * @copyright 2023 itzmekhokan
 * @license   GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: WP Apester Integration
 * Description: A toolkit that helps to integrate Apester embed content and share interactive items into posts and articles
 * Version:     1.0.0
 * Plugin URI:  https://github.com/itzmekhokan
 * Author:      Khokan Sardar
 * Author URI:  https://github.com/itzmekhokan
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: wp-apester
 */

defined( 'ABSPATH' ) || exit;

define( 'WP_APESTER_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WP_APESTER_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'WP_APESTER_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// phpcs:disable WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
require_once WP_APESTER_PATH . '/inc/helpers/autoloader.php';
require_once WP_APESTER_PATH . '/inc/helpers/custom-functions.php';
// phpcs:enable WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

/**
 * To load plugin manifest class.
 *
 * @return void
 */
function wp_apester_loader() {
	\ITZ_Me_Khokan\Apester\Inc\Plugin::get_instance();
}

wp_apester_loader();
