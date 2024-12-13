<?php
if (!isset($tradeace_opt)) {
    global $tradeace_opt;
}

$slideHoz = false;
if (isset($tradeace_opt['product_detail_layout']) && $tradeace_opt['product_detail_layout'] === 'classic' && isset($tradeace_opt['product_thumbs_style']) && $tradeace_opt['product_thumbs_style'] === 'hoz') {
    $slideHoz = true; 
}

$class_image = 'large-6 small-12 columns product-gallery rtl-right';
$class_info = 'large-6 small-12 columns product-info summary entry-summary left rtl-left';

$dots = isset($tradeace_opt['product_slide_dot']) && $tradeace_opt['product_slide_dot'] ? 'true' : 'false';

if ($slideHoz) {
    $class_image = 'large-6 small-12 columns product-gallery rtl-right desktop-padding-right-20 rtl-desktop-padding-right-10 rtl-desktop-padding-left-20';
    $class_info = 'large-6 small-12 columns product-info summary entry-summary left rtl-left';
    
    $dots = 'false';
}
?>

<div id="product-<?php echo (int) $product->get_id(); ?>" <?php post_class(); ?>>
    <?php if ($tradeace_actsidebar && $tradeace_sidebar != 'no') : ?>
        <div class="div-toggle-sidebar center">
            <a class="toggle-sidebar" href="javascript:void(0);" rel="nofollow">
                <i class="tradeace-icon pe7-icon pe-7s-menu"></i>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="row tradeace-product-details-page">
        <div class="<?php echo esc_attr($main_class); ?>" data-num_main="1" data-num_thumb="6" data-speed="300" data-dots="<?php echo $dots; ?>">
            <div class="row">
                <div class="<?php echo $class_image; ?>"> 
                    <?php do_action('woocommerce_before_single_product_summary'); ?>
                </div>
                
                <div class="<?php echo $class_info; ?>">
                    <?php do_action('woocommerce_single_product_summary'); ?>
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
</div>