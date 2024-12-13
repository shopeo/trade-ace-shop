<?php
/**
 * Carousel slide for gift products
 */
$id_sc = rand(0, 9999999);
$_delay = 0;
$_delay_item = (isset($tradeace_opt['delay_overlay']) && (int) $tradeace_opt['delay_overlay']) ? (int) $tradeace_opt['delay_overlay'] : 100;
$file_content = TRADEACE_CHILD_PATH . '/includes/tradeace-content-product-gift.php';
$file_content = is_file($file_content) ? $file_content : TRADEACE_THEME_PATH . '/includes/tradeace-content-product-gift.php';

?>
<div class="row tradeace-slider-wrap tradeace-warp-slide-nav-side tradeace-slider-wrap-combo">
    <div class="large-12 columns">
        <div
            class="tradeace-slider-items-margin tradeace-slick-slider tradeace-slick-nav tradeace-combo-slider"
            data-columns="4"
            data-columns-small="2"
            data-columns-tablet="3"
            data-switch-tablet="<?php echo tradeace_switch_tablet(); ?>"
            data-switch-desktop="<?php echo tradeace_switch_desktop(); ?>">
            <?php
            foreach ($combo as $bundle_item) :
                include $file_content;
                $_delay += $_delay_item;
            endforeach;
            ?>
        </div>
    </div>
</div>
