<?php
if (!isset($tradeace_opt)) {
    global $tradeace_opt;
}

$dots = isset($tradeace_opt['product_slide_dot']) && $tradeace_opt['product_slide_dot'] ? 'true' : 'false';
$num_main = apply_filters('tradeace_number_main_single_product_gallery_full', 3);
?>

<div id="product-<?php echo (int) $product->get_id(); ?>" <?php post_class(); ?>>
    <?php if ($tradeace_actsidebar && $tradeace_sidebar != 'no') : ?>
        <div class="tradeace-toggle-layout-side-sidebar tradeace-sidebar-single-product <?php echo esc_attr($tradeace_sidebar); ?>">
            <div class="li-toggle-sidebar">
                <a class="toggle-sidebar-shop" href="javascript:void(0);" rel="nofollow">
                    <i class="tradeace-icon pe7-icon pe-7s-menu"></i>
                </a>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="tradeace-product-details-page tradeace-layout-full padding-top-10">
        <div class="<?php echo esc_attr($main_class); ?> padding-left-0 padding-right-0" data-num_main="<?php echo (int) $num_main; ?>" data-num_thumb="0" data-speed="300" data-dots="<?php echo $dots; ?>">
            <div class="tradeace-row row-fullwidth">
                <div class="large-12 columns product-gallery tradeace-gallery-full">
                    <?php do_action('woocommerce_before_single_product_summary'); ?>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns summary entry-summary product-info text-center">
                    <div class="tradeace-product-info-wrap">
                        <?php do_action('woocommerce_single_product_summary'); ?>
                    </div>
                </div>
            </div>
            
            <?php do_action('woocommerce_after_single_product_summary'); ?>
        </div>

        <?php if ($tradeace_actsidebar && $tradeace_sidebar != 'no') : ?>
            <div class="<?php echo esc_attr($bar_class); ?>">     
                <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'tradeace-theme'); ?>" class="hidden-tag tradeace-close-sidebar" rel="nofollow">
                    <?php echo esc_html__('Close', 'tradeace-theme'); ?>
                </a>
                
                <div class="tradeace-sidebar-off-canvas">
                    <?php dynamic_sidebar('product-sidebar'); ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
    
    <div class="tradeace-clear-both"></div>
</div>
