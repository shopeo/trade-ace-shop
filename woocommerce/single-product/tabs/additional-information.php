<?php
/**
 * Additional Information tab
 *
 * @author  TradeaceTheme
 * @package Tradeace-theme/WooCommerce
 * @version 3.0.0
 */
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;


global $product;
do_action('woocommerce_product_additional_information', $product);
