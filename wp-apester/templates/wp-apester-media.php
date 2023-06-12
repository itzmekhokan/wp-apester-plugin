<?php
/**
 * Apester Media embedded template.
 *
 * @package wp-apester
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
$media_id = ( isset( $attr['id'] ) ) ? esc_attr( $attr['id'] ) : '';
$classes  = ( isset( $attr['class'] ) ) ? sanitize_html_class( $attr['class'] ) : '';

?>
<!-- Put Media embedded interaction -->
<div class="apester-media <?php echo esc_attr( $classes ); ?>" data-media-id="<?php echo esc_attr( $media_id ); ?>"></div>
