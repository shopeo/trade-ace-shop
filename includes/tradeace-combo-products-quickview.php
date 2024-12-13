<?php
// Exit if accessed directly
if (!defined('ABSPATH')) :
    exit;
endif;

if (!$product->is_purchasable()) :
    return;
endif;

$bundled_items = $product->get_bundled_items();
if ($bundled_items) : ?>
    <hr class="tradeace-single-hr">
    <h3 class="tradeace-gift-label"><?php echo esc_html__('Bundle product for ', 'tradeace-theme'); ?><span class="tradeace-gift-count">(<?php echo count($bundled_items) . ' ' . esc_html__('items', 'tradeace-theme'); ?>)</span></h3>
    <div
        id="tradeace-slider-gifts-product-quickview"
        class="tradeace-slider-items-margin tradeace-slick-slider"
        data-columns="3"
        data-columns-small="2"
        data-columns-tablet="3"
        data-switch-tablet="<?php echo tradeace_switch_tablet(); ?>"
        data-switch-desktop="<?php echo tradeace_switch_desktop(); ?>">
        
        <?php foreach ($bundled_items as $bundled_item) :
            $bundled_product = $bundled_item->get_product();
            $bundled_post = get_post(yit_get_base_product_id($bundled_product));
            $quantity = $bundled_item->get_quantity();
            ?>
            <div class="tradeace-gift-product-quickview-item tradeace-slider-item">
                <a href="<?php echo esc_url($bundled_product->get_permalink()); ?>" title="<?php echo esc_attr($bundled_product->get_title()); ?>">
                    <div class="tradeace-bundled-item-image"><?php echo ($bundled_product->get_image()); ?></div>
                    <h5><?php echo ($quantity . ' x ' . $bundled_product->get_title()); ?></h5>
                </a>
                
                <?php
                if ($bundled_product->has_enough_stock($quantity) && $bundled_product->is_in_stock()) :
                    echo '<div class="tradeace-label-stock tradeace-item-instock">' . esc_html__('In stock', 'tradeace-theme') . '</div>';
                else :
                    echo '<div class="tradeace-label-stock tradeace-item-outofstock">' . esc_html__('Out of stock', 'tradeace-theme') . '</div>';
                endif;
                ?>
            </div>
        <?php endforeach; ?>
        
    </div>
<?php endif;