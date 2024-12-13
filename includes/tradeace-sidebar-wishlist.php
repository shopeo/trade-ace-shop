<div class="widget_shopping_wishlist_content wishlist_sidebar">
    <?php
    /**
     * Yith WooCommerce Wishlist
     */
    if (TRADEACE_WISHLIST_ENABLE) :
        echo shortcode_exists('tradeace_yith_wcwl_wishlist') ? do_shortcode('[tradeace_yith_wcwl_wishlist]') : '<p class="empty">' . esc_html__('Theme has not been installed or enabled Wishlist Feature.', 'tradeace-theme') . '</p>';
    
    /**
     * Tradeace Wishlist Sidebar Content
     */
    elseif (function_exists('tradeace_woo_wishlist')) :
        $tradeace_wishlist = tradeace_woo_wishlist();
        if ($tradeace_wishlist) :
            $tradeace_wishlist->wishlist_html();
        endif;
    endif;
    ?>
</div>
