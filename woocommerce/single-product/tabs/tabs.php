<?php
/**
 * Single Product tabs / and sections
 *
 * @author  TradeaceTheme
 * @package Tradeace-theme/WooCommerce
 * @version 3.8.0
 */
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($tabs)) :
    global $tradeace_opt, $product;

    $tab_style = apply_filters('tradeace_single_product_tabs_style', '2d-no-border');
    $off_canvas_mobile = $tab_style != 'scroll-down' && isset($tradeace_opt['woo_tabs_off_canvas']) && $tradeace_opt['woo_tabs_off_canvas'] ? true : false;
    
    $class_wrap = 'tradeace-tabs-content woocommerce-tabs';
    $class_ul = 'tradeace-tabs';
    
    switch ($tab_style) :
        case 'accordion':
            $class_wrap = 'tradeace-accordions-content woocommerce-tabs tradeace-no-global';
            break;

        case '2d':
            $class_ul .= ' tradeace-classic-style tradeace-classic-2d';
            break;

        case '2d-radius':
            $class_ul .= ' tradeace-classic-style tradeace-classic-2d tradeace-tabs-no-border tradeace-tabs-radius';
            break;
        
        case '2d-radius-dashed':
            $class_ul .= ' tradeace-classic-style tradeace-classic-2d tradeace-tabs-radius-dashed';
            break;

        case '3d':
            $class_ul .= ' tradeace-classic-style';
            break;

        case 'slide':
            $class_ul .= ' tradeace-slide-style';
            break;
        
        case 'scroll-down':
            $class_wrap = 'tradeace-scroll-content woocommerce-tabs';
            break;

        case '2d-no-border':
        default:
            $class_ul .= ' tradeace-classic-style tradeace-classic-2d tradeace-tabs-no-border';
            break;
    endswitch;
    
    $class_wrap .= $off_canvas_mobile ? ' mobile-tabs-off-canvas tradeace-transition-800' : '';

    ?>
    <div class="product-details" id="tradeace-single-product-tabs">
        
        <?php echo $off_canvas_mobile ? '<a href="javascript:void(0)" class="tradeace-toggle-woo-tabs hidden-tag">' . esc_html__('View Product Information') . '</a>' : ''; ?>
        
        <div class="<?php echo esc_attr($class_wrap); ?>">
            <?php
            echo $off_canvas_mobile ? '<a href="javascript:void(0)" class="tradeace-toggle-woo-tabs tradeace-stclose hidden-tag"></a>' : '';
            
            /**
             * Accordion layout style
             */
            if ($tab_style === 'accordion') :
                $file = TRADEACE_CHILD_PATH . '/includes/tradeace-single-product-tabs_accordion_layout.php';
                if(!is_file($file)) :
                    $file = TRADEACE_THEME_PATH . '/includes/tradeace-single-product-tabs_accordion_layout.php';
                endif;
                
            /**
             * Scroll Down layout style
             */
            elseif ($tab_style === 'scroll-down') :
                $file = TRADEACE_CHILD_PATH . '/includes/tradeace-single-product-tabs_scroll_layout.php';
                if(!is_file($file)) :
                    $file = TRADEACE_THEME_PATH . '/includes/tradeace-single-product-tabs_scroll_layout.php';
                endif;

            /**
             * Tabs layout style
             */
            else:
                $file = TRADEACE_CHILD_PATH . '/includes/tradeace-single-product-tabs_tab_layout.php';
                if(!is_file($file)) :
                    $file = TRADEACE_THEME_PATH . '/includes/tradeace-single-product-tabs_tab_layout.php';
                endif;
            endif;
            
            /**
             * Content WooCommerce Tabs
             */
            include $file;
            ?>
        </div>
    </div>
<?php
endif;
