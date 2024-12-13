<?php
/**
 * Cross-sells
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  TradeaceTheme
 * @package Tradeace-theme/WooCommerce
 * @version 4.4.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if ($cross_sells) :
    global $tradeace_opt;

    $_delay = 0;
    $_delay_item = (isset($tradeace_opt['delay_overlay']) && (int) $tradeace_opt['delay_overlay']) ? (int) $tradeace_opt['delay_overlay'] : 100;
    
    $layout_buttons_class = '';
    if (isset($tradeace_opt['loop_layout_buttons']) && $tradeace_opt['loop_layout_buttons'] != '') {
        $layout_buttons_class = ' tradeace-' . $tradeace_opt['loop_layout_buttons'];
    }
    
    $columns_desk = !isset($tradeace_opt['relate_columns_desk']) || !(int) $tradeace_opt['relate_columns_desk'] ? 3 : (int) $tradeace_opt['relate_columns_desk'];
    $columns_tablet = !isset($tradeace_opt['relate_columns_tablet']) || !(int) $tradeace_opt['relate_columns_tablet'] ? 3 : (int) $tradeace_opt['relate_columns_tablet'];
    $columns_small = isset($tradeace_opt['relate_columns_small']) ? $tradeace_opt['relate_columns_small'] : 2;
    $columns_small_slide = $columns_small == '1.5-cols' ? 1 : (int) $columns_small;
    
    if (!$columns_small) {
        $columns_small_slide = 2;
    }
    
    $start_row = $end_row = '';
    $class_wrap = 'related related-product cross-sells products grid tradeace-slider-wrap margin-top-50';
    
    if (isset($_REQUEST['tradeace_action']) && $_REQUEST['tradeace_action'] === 'tradeace_after_add_to_cart') {
        $columns_desk = apply_filters('tradeace_columns_large_popup_cross_sells', '3');
        $columns_tablet = apply_filters('tradeace_columns_medium_popup_cross_sells', '3');
        $columns_small = apply_filters('tradeace_columns_small_popup_cross_sells', '2');
    } else {
        $start_row = '<div class="row">';
        $end_row = '</div>';
        $class_wrap .= ' larger-12 columns';
    }
    
    $data_attrs = array();
    $data_attrs[] = 'data-columns="' . esc_attr($columns_desk) . '"';
    $data_attrs[] = 'data-columns-small="' . esc_attr($columns_small_slide) . '"';
    $data_attrs[] = 'data-columns-tablet="' . esc_attr($columns_tablet) . '"';
    $data_attrs[] = 'data-switch-tablet="' . tradeace_switch_tablet() . '"';
    $data_attrs[] = 'data-switch-desktop="' . tradeace_switch_desktop() . '"';

    if ($columns_small == '1.5-cols') {
        $data_attrs[] = 'data-padding-small="20%"';
    }
    
    $attrs_str = !empty($data_attrs) ? ' ' . implode(' ', $data_attrs) : '';
    
    $heading = apply_filters('woocommerce_product_cross_sells_products_heading', esc_html__('You may be interested in&hellip;', 'tradeace-theme'));
    
    $class_slider = 'tradeace-slider-items-margin tradeace-slick-slider products grid' . $layout_buttons_class;
    $class_slider .= ' tradeace-slick-nav tradeace-nav-top tradeace-nav-top-radius';
    
    echo $start_row;
    ?>

    <div class="<?php echo esc_attr($class_wrap); ?>">
        <?php if ($heading) : ?>
            <div class="tradeace-slide-style-product-carousel tradeace-relative margin-bottom-20">
                <h3 class="tradeace-shortcode-title-slider text-center">
                    <?php echo $heading; ?>
                </h3>
            </div>
        <?php endif; ?>

        <div class="<?php echo esc_attr($class_slider); ?>"<?php echo $attrs_str; ?>>
            <?php
            foreach ($cross_sells as $cross_sell) :
                $post_object = get_post($cross_sell->get_id());
                setup_postdata($GLOBALS['post'] = & $post_object);
                
                // Product Item -->
                wc_get_template('content-product.php', array(
                    '_delay' => $_delay,
                    'wrapper' => 'div',
                    'combo_show_type' => 'popup',
                    'disable_drag' => true
                ));
                // End Product Item -->
                
                $_delay += $_delay_item;
            endforeach;
            ?>
        </div>
    </div>
    <?php
    
    echo $end_row;
endif;

wp_reset_postdata();
