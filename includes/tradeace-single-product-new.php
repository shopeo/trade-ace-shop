<?php
if (!isset($tradeace_opt)) {
    global $tradeace_opt;
}

$columnImage = '6';
$columnInfo = '6';

if ($tradeace_opt['product_image_layout'] != 'single') {
    if ($tradeace_opt['product_image_style'] === 'slide') {
        $columnImage = '8';
        $columnInfo = '4';
    } else {
        $columnImage = '7';
        $columnInfo = '5';
    }
}

$dots = isset($tradeace_opt['product_slide_dot']) && $tradeace_opt['product_slide_dot'] ? 'true' : 'false';
?>

<div id="product-<?php echo (int) $product->get_id(); ?>" <?php post_class(); ?>>
    <?php if ($tradeace_actsidebar && $tradeace_sidebar != 'no') : ?>
        <div class="tradeace-toggle-layout-side-sidebar tradeace-sidebar-single-product <?php echo esc_attr($tradeace_sidebar); ?>">
            <div class="li-toggle-sidebar">
                <a class="toggle-sidebar-shop tradeace-tip" data-tip="<?php echo esc_attr__('Filters', 'tradeace-theme'); ?>" href="javascript:void(0);" rel="nofollow">
                    <i class="tradeace-icon pe7-icon pe-7s-menu"></i>
                </a>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="tradeace-row tradeace-product-details-page">
        <div class="<?php echo esc_attr($main_class); ?>" data-num_main="<?php echo ($tradeace_opt['product_image_layout'] == 'double') ? '2' : '1'; ?>" data-num_thumb="<?php echo ($tradeace_opt['product_image_layout'] == 'double') ? '4' : '6'; ?>" data-speed="300" data-dots="<?php echo $dots; ?>">

            <div class="row">
                <div class="large-<?php echo esc_attr($columnImage); ?> small-12 columns product-gallery rtl-right"> 
                    <?php do_action('woocommerce_before_single_product_summary'); ?>
                </div>
                
                <div class="large-<?php echo esc_attr($columnInfo); ?> small-12 columns product-info summary entry-summary rtl-left">
                    <div class="tradeace-product-info-wrap">
                        <div class="tradeace-product-info-scroll">
                            <?php do_action('woocommerce_single_product_summary'); ?>
                        </div>
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
</div>
