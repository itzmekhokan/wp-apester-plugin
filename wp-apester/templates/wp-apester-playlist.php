<?php
/**
 * Apester Playlist embedded template.
 *
 * @package wp-apester
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
if ( ! $token ) {
    return '';
}
$classes  = ( isset( $attr['class'] ) ) ? sanitize_html_class( $attr['class'] ) : '';
$context  = ( isset( $attr['context'] ) ) ? true : false;
$fallback = ( isset( $attr['fallback'] ) ) ? true : false;
$tags     = ( isset( $attr['tags'] ) ) ? esc_attr( $attr['tags'] ) : '';

// Custom attributes.
$custom_attr = '';

if ( $context ) {
    $custom_attr .= "data-context=true ";
}

if ( $fallback ) {
    $custom_attr .= "data-fallback=true ";
}

if ( $tags ) {
    $custom_attr .= "data-tags=$tags ";
}

?>
<!-- Put Playlist embedded interaction media with custom attributes -->
<div class="apester-media <?php echo esc_attr( $classes ); ?>" data-token="<?php echo esc_attr( $token ); ?>" <?php echo esc_attr( $custom_attr ); ?>></div>