<div class="<?php echo esc_attr($header_classes); ?>">
    <?php
    /**
     * Hook - top bar header
     */
    do_action('tradeace_topbar_header_mobile');
    ?>
    <div class="sticky-wrapper">
        <div id="masthead" class="site-header">
            <div class="mini-icon-mobile left-icons elements-wrapper rtl-text-right">
                <a href="javascript:void(0);" class="tradeace-icon tradeace-mobile-menu_toggle mobile_toggle tradeace-mobile-menu-icon pe-7s-menu" rel="nofollow"></a>
                <a class="tradeace-icon icon pe-7s-search mobile-search" href="javascript:void(0);" rel="nofollow"></a>
            </div>

            <!-- Logo -->
            <div class="logo-wrapper elements-wrapper text-center">
                <?php echo tradeace_logo(); ?>
            </div>

            <div class="right-icons elements-wrapper text-right rtl-text-left">
                <?php
                /**
                 * product_cat: false
                 * cart: true
                 * compare: false
                 * wishlist: true
                 * search: false
                 */
                echo tradeace_header_icons(false, true, false, false, false); ?>
            </div>
            
            <div class="hidden-tag">
                <?php
                tradeace_get_main_menu();
                if ($vertical) :
                    tradeace_get_vertical_menu();
                endif;
                
                echo tradeace_get_all_categories(false, true);
                ?>
            </div>
        </div>
    </div>
</div>
