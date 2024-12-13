<?php
/**
 * Custom Product image
 *
 * @author  TradeaceTheme
 * @package Tradeace-theme/WooCommerce
 * @version 3.5.1
 */
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

global $product, $tradeace_opt;

$productId = $product->get_id();
$attachment_ids = $product->get_gallery_image_ids();
$data_rel = '';
$thumbNailId = get_post_thumbnail_id();
$image_title = esc_attr(get_the_title($thumbNailId));
$image_full = wp_get_attachment_image_src($thumbNailId, 'full');
$image_link = isset($image_full[0]) ? $image_full[0] : wp_get_attachment_url($thumbNailId);
$image_large = wp_get_attachment_image_src($thumbNailId, 'shop_single');
$src_large = isset($image_large[0]) ? $image_large[0] : $image_link;
$image = get_the_post_thumbnail($productId, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array('alt' => $image_title, 'class' => 'skip-lazy attachment-shop_single size-shop_single'));
$attachment_count = count($attachment_ids);

$slideHoz = false;
if (isset($tradeace_opt['product_detail_layout']) && $tradeace_opt['product_detail_layout'] === 'classic' && isset($tradeace_opt['product_thumbs_style']) && $tradeace_opt['product_thumbs_style'] === 'hoz') {
    $slideHoz = true; 
}

$imageMobilePadding = 'mobile-padding-left-5 mobile-padding-right-5';
if (isset($tradeace_opt['product_detail_layout']) && $tradeace_opt['product_detail_layout'] == 'new' && isset($tradeace_opt['product_image_style']) && $tradeace_opt['product_image_style'] == 'scroll') {
    $imageMobilePadding = 'mobile-padding-left-0 mobile-padding-right-0';
}

$class_wrapimg = 'row tradeace-mobile-row woocommerce-product-gallery__wrapper';
$show_thumbnail = true;
if (isset($tradeace_opt['product_detail_layout']) && $tradeace_opt['product_detail_layout'] == 'full') :
    $show_thumbnail = false;
    $class_wrapimg = 'tradeace-row tradeace-mobile-row tradeace-columns-padding-0';
    $imageMobilePadding = 'mobile-padding-left-0 mobile-padding-right-0';
endif;

$sliders_arrow = isset($tradeace_opt['product_slide_arrows']) && $tradeace_opt['product_slide_arrows'] && $tradeace_opt['product_image_style'] === 'slide' ? true : false;
?>

<div class="images woocommerce-product-gallery">
    <div class="<?php echo $class_wrapimg; ?>">
        <div class="large-12 columns <?php echo $imageMobilePadding; ?>">
            <?php if ($show_thumbnail && !$slideHoz && (!isset($tradeace_opt['tradeace_in_mobile']) || !$tradeace_opt['tradeace_in_mobile'])) : ?>
                <div class="tradeace-thumb-wrap rtl-right">
                    <?php do_action('woocommerce_product_thumbnails'); ?>
                </div>
            <?php endif; ?>
            
            <div class="tradeace-main-wrap rtl-left<?php echo $slideHoz ? ' tradeace-thumbnail-hoz' : ''; ?>">
                <div class="product-images-slider images-popups-gallery">
                    <div class="tradeace-main-image-default-wrap">
                        
                        <?php if ($sliders_arrow) : ?>
                            <div class="tradeace-single-slider-arrows">
                                <a class="tradeace-single-arrow tradeace-disabled" data-action="prev" href="javascript:void(0);" rel="nofollow"></a>
                                <a class="tradeace-single-arrow" data-action="next" href="javascript:void(0);" rel="nofollow"></a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="main-images tradeace-single-product-main-image tradeace-main-image-default">
                            <div class="item-wrap first">
                                <div class="tradeace-item-main-image-wrap" id="tradeace-main-image-0" data-key="0">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="easyzoom first">
                                            <?php echo apply_filters(
                                                'woocommerce_single_product_image_html',
                                                sprintf(
                                                    '<a href="%s" class="woocommerce-main-image product-image woocommerce-product-gallery__image" data-o_href="%s" data-full_href="%s" title="%s">%s</a>',
                                                    $image_link,
                                                    $src_large,
                                                    $image_link,
                                                    $image_title,
                                                    $image
                                                ),
                                                $productId
                                            ); ?>
                                        </div>
                                    <?php else :
                                        $noimage = wc_placeholder_img_src();
                                        ?>
                                        <div class="easyzoom">
                                            <?php echo apply_filters(
                                                'woocommerce_single_product_image_html',
                                                sprintf(
                                                    '<a href="%s" class="woocommerce-main-image product-image woocommerce-product-gallery__image" data-o_href="%s"><img src="%s" /></a>',
                                                        $noimage,
                                                        $noimage,
                                                        $noimage
                                                    ),
                                                $productId
                                            ); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php
                            $_i = 0;
                            if ($attachment_count > 0) :
                                foreach ($attachment_ids as $id) :
                                    $_i++;
                                    ?>
                                    <div class="item-wrap">
                                        <div class="tradeace-item-main-image-wrap" id="tradeace-main-image-<?php echo (int) $_i; ?>" data-key="<?php echo (int) $_i; ?>">
                                            <div class="easyzoom">
                                                <?php
                                                $image_title = esc_attr(get_the_title($id));
                                                
                                                $image_full = wp_get_attachment_image_src($id, 'full');
                                                $image_link = isset($image_full[0]) ?
                                                    $image_full[0] : wp_get_attachment_url($id);
                                                
                                                $image = wp_get_attachment_image($id, 'shop_single', false, array('alt' => $image_title, 'class' => 'skip-lazy attachment-shop_single size-shop_single'));
                                                $image = $image ? $image : wc_placeholder_img();
                                                echo sprintf(
                                                    '<a href="%s" class="woocommerce-additional-image product-image" title="%s">%s</a>',
                                                    $image_link,
                                                    $image_title,
                                                    $image
                                                );
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>

                    <div class="product-image-btn">
                        <?php do_action('tradeace_single_buttons'); ?>
                    </div>
                </div>
                
                <div class="tradeace-end-scroll"></div>
            </div>
            
            <?php if ($show_thumbnail && $slideHoz) : ?>
                <div class="tradeace-thumb-wrap tradeace-thumbnail-hoz">
                    <?php do_action('woocommerce_product_thumbnails'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
