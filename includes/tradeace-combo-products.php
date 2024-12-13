<?php
/**
 * Carousel slide for gift products
 */
$id_sc = rand(0, 9999999);
$_delay = 0;
$_delay_item = (isset($tradeace_opt['delay_overlay']) && (int) $tradeace_opt['delay_overlay']) ? (int) $tradeace_opt['delay_overlay'] : 100;

?>
<div class="tradeace-slider-wrap tradeace-warp-slide-nav-side tradeace-slider-wrap-combo">
    <div class="large-2 medium-3 columns">
        <div class="tradeace-slide-left-info-wrap">
            <h4 class="tradeace-combo-gift"><?php echo esc_html__('Bundle product for', 'tradeace-theme'); ?></h4>
            <h3><?php echo ($product->get_name()); ?><span class="tradeace-count-items">(<?php echo count($combo) . ' ' . esc_html__('Items', 'tradeace-theme'); ?>)</span></h3>
            <div class="tradeace-nav-carousel-wrap tradeace-clear-both">
                <a class="tradeace-nav-icon-slider icon-tradeace-left-arrow" href="javascript:void(0);" data-do="prev" rel="nofollow"></a>
                <a class="tradeace-nav-icon-slider icon-tradeace-right-arrow" href="javascript:void(0);" data-do="next" rel="nofollow"></a>
            </div>

            <?php if (!isset($tradeace_viewmore) || $tradeace_viewmore == true) : ?>
                <a class="tradeace-view-more-slider" href="<?php echo esc_url($product->get_permalink()); ?>" title="<?php echo esc_attr__('View more', 'tradeace-theme'); ?>"><?php echo esc_html__('View more', 'tradeace-theme'); ?></a>
            <?php endif; ?>
        </div>
    </div>

    <div class="large-10 medium-9 columns">
        <div
            id="tradeace-slider-<?php echo esc_attr($id_sc); ?>"
            class="tradeace-slider-items-margin tradeace-slick-slider tradeace-combo-slider"
            data-columns="4"
            data-columns-small="2"
            data-columns-tablet="3" 
            data-switch-tablet="<?php echo tradeace_switch_tablet(); ?>"
            data-switch-desktop="<?php echo tradeace_switch_desktop(); ?>">
            <?php
            $file_content = TRADEACE_CHILD_PATH . '/includes/tradeace-content-product-gift.php';
            $file_content = is_file($file_content) ? $file_content : TRADEACE_THEME_PATH . '/includes/tradeace-content-product-gift.php';
            foreach ($combo as $bundle_item) :
                include $file_content;
                $_delay += $_delay_item;
            endforeach;
            ?>
        </div>
    </div>
</div>
