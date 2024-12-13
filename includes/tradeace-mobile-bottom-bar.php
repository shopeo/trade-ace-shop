<?php
$close = TRADEACE_WOO_ACTIVED ? is_product() : false;
$is_close = apply_filters('tradeace_close_mobile_bottom_bar', $close);
if ($is_close) :
    return;
endif;

$shopPageLink = TRADEACE_WOO_ACTIVED ? wc_get_page_permalink('shop') : home_url('/');

$icon_home = apply_filters('tradeace_bot_icon_home', '<i class="tradeace-icon pe-7s-home"></i>');
$icon_filter = apply_filters('tradeace_bot_icon_filter', '<i class="tradeace-icon pe-7s-filter"></i>');
$icon_cats = apply_filters('tradeace_bot_icon_filter_cats', '<i class="tradeace-icon pe-7s-keypad"></i>');
$icon_search = apply_filters('tradeace_bot_icon_search', '<i class="tradeace-icon pe-7s-search"></i>');
?>

<ul class="tradeace-bottom-bar-icons">
    <li class="tradeace-bot-item">
        <a class="tradeace-bot-icons tradeace-bot-icon-shop" href="<?php echo esc_url($shopPageLink); ?>" title="<?php echo esc_attr__('Shop', 'tradeace-theme'); ?>">
            <?php echo $icon_home; ?>
            <?php echo esc_html__('Shop', 'tradeace-theme'); ?>
        </a>
    </li>
    
    <li class="tradeace-bot-item tradeace-bot-item-sidebar hidden-tag">
        <a class="tradeace-bot-icons tradeace-bot-icon-sidebar" href="javascript:void(0);" title="<?php echo esc_attr__('Filters', 'tradeace-theme'); ?>" rel="nofollow">
            <?php echo $icon_filter; ?>
            <?php echo esc_html__('Filters', 'tradeace-theme'); ?>
        </a>
    </li>
    
    <li class="tradeace-bot-item">
        <a class="tradeace-bot-icons tradeace-bot-icon-categories filter-cat-icon-mobile" href="javascript:void(0);" title="<?php echo esc_attr__('Categories', 'tradeace-theme'); ?>" rel="nofollow">
            <?php echo $icon_cats; ?>
            <?php echo esc_html__('Categories', 'tradeace-theme'); ?>
        </a>
    </li>
    
    <li class="tradeace-bot-item tradeace-bot-item-search hidden-tag">
        <a class="tradeace-bot-icons tradeace-bot-icon-search botbar-mobile-search" href="javascript:void(0);" title="<?php echo esc_attr__('Search', 'tradeace-theme'); ?>" rel="nofollow">
            <?php echo $icon_search; ?>
            <?php echo esc_html__('Search', 'tradeace-theme'); ?>
        </a>
    </li>
    
    <?php
    /**
     * Wishlist bottom bar
     */
    $wishlist_icons = tradeace_icon_wishlist();
    if ($wishlist_icons) :
        ?>
        <li class="tradeace-bot-item">
            <a class="tradeace-bot-icons tradeace-bot-icon-wishlist botbar-wishlist-link" href="javascript:void(0);" title="<?php echo esc_attr__('Wishlist', 'tradeace-theme'); ?>" rel="nofollow">
                <i class="tradeace-icon wishlist-icon icon-tradeace-like"></i>
                <?php echo esc_html__('Wishlist', 'tradeace-theme'); ?>
            </a>
            <?php echo $wishlist_icons; ?>
        </li>
        
    <?php else:
        
        /**
         * Cart bottom bar If Has Not Wishlist Featured
         */
        $is_cart = true;
        if (!TRADEACE_WOO_ACTIVED || (isset($tradeace_opt['disable-cart']) && $tradeace_opt['disable-cart'])) :
            $is_cart = false;
        endif;
        if ($is_cart) :
            $icon_class = tradeace_mini_cart_icon();
            ?>
            <li class="tradeace-bot-item">
                <a class="tradeace-bot-icons tradeace-bot-icon-cart botbar-cart-link" href="javascript:void(0);" title="<?php echo esc_attr__('Cart', 'tradeace-theme'); ?>" rel="nofollow">
                    <i class="tradeace-icon <?php echo $icon_class; ?>"></i>
                    <?php echo esc_html__('Cart', 'tradeace-theme'); ?>
                </a>
            </li>
        <?php endif; ?>
    <?php endif; ?>
</ul>
