<?php
/**
 * Apester Strip embedded template.
 *
 * @package wp-apester
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
if ( ! $token ) {
    return '';
}

?>
<!-- Put Strip embedded interaction media -->
<div className="apester-strip" data-channel-tokens="<?php echo esc_attr( $token ); ?>"></div>