<?php
/**
 * @package WordPress
 * @subpackage YIW Themes
 * 
 * Here the first hentry of theme, when all theme will be loaded.
 * On new update of theme, you can not replace this file.
 * You will write here all your custom functions, they remain after upgrade.
 */                                                                               

// include all framework
require_once dirname(__FILE__) . '/core/core.php';

// include the library for the layers slider
require_once dirname(__FILE__) . '/inc/LayerSlider/layerslider.php';

/*-----------------------------------------------------------------------------------*/
/* End Theme Load Functions - You can add custom functions below */
/*-----------------------------------------------------------------------------------*/

add_filter( 'woocommerce_currencies', 'add_my_currency' );

function add_my_currency( $currencies ) {
    $currencies['BS'] = __( 'Bolivares', 'woocommerce' );
    return $currencies;
}

add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);

function add_my_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        case 'BS': $currency_symbol = 'bs '; break;
    }
    return $currency_symbol;
}