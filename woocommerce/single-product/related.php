<?php
/**
 * Related Products
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author      TradeaceTheme
 * @package     Tradeace-theme/WooCommerce
 * @version     3.9.0
 */
if (!defined('ABSPATH')) :
    exit;
endif;

if ($related_products) :
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
    
    $class_slider = 'tradeace-slider-items-margin tradeace-slick-slider tradeace-slick-nav tradeace-nav-top tradeace-nav-top-radius products grid' . $layout_buttons_class;
    ?>
    <div class="row related-product tradeace-slider-wrap related products grid tradeace-relative margin-bottom-50">
        <div class="large-12 columns">
            <h3 class="tradeace-title-relate text-center">
                <?php echo apply_filters('woocommerce_product_related_products_heading', esc_html__('Related Products', 'tradeace-theme')); ?>
            </h3>

            <div class="<?php echo esc_attr($class_slider); ?>"<?php echo $attrs_str; ?>>
                <?php
                foreach ($related_products as $related_product) :
                    $post_object = get_post($related_product->get_id());
                    setup_postdata($GLOBALS['post'] = & $post_object);

                    // Product Item
                    wc_get_template('content-product.php', array(
                        '_delay' => $_delay,
                        'wrapper' => 'div',
                        'combo_show_type' => 'popup',
                        'disable_drag' => true
                    ));
                    // End Product Item

                    $_delay += $_delay_item;
                endforeach;
                ?>
            </div>
        </div>
    </div>
    <?php
endif;

wp_reset_postdata();
