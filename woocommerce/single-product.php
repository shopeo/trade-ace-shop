<?php
/**
 * 
 * @author  TradeaceTheme
 * @package Tradeace-theme/WooCommerce
 * @version 1.6.4
 */
defined('ABSPATH') or exit;

get_header('shop'); ?>

<div class="product-page">
    <?php 
    do_action('woocommerce_before_main_content');
    while (have_posts()) :
        the_post();
        wc_get_template_part('content', 'single-product');
    endwhile;
    do_action('woocommerce_after_main_content');
    ?>
</div>

<?php
get_footer('shop');
