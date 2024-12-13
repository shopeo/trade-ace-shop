<div class="<?php echo esc_attr($header_classes); ?>">
    <?php
    /**
     * Hook - top bar header
     */
    do_action('tradeace_topbar_header');
    ?>
    <div class="sticky-wrapper">
        <div id="masthead" class="site-header">
            <?php do_action('tradeace_mobile_header'); ?>
            
            <div class="row tradeace-hide-for-mobile">
                <div class="large-12 columns tradeace-wrap-event-search">
                    <div class="tradeace-header-flex tradeace-elements-wrap">
                        <!-- Logo -->
                        <div class="tradeace-flex-item logo-wrapper">
                            <?php echo tradeace_logo(); ?>
                        </div>

                        <!-- Search form in header -->
                        <div class="tradeace-flex-item fgr-1 tradeace-header-search-wrap tradeace-search-relative">
                            <?php echo tradeace_search('full'); ?>
                        </div>
                        
                        <!-- Group icon header -->
                        <div class="tradeace-flex-item icons-wrapper">
                            <?php echo $tradeace_header_icons; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main menu -->
            <div class="tradeace-elements-wrap tradeace-elements-wrap-main-menu tradeace-hide-for-mobile tradeace-elements-wrap-bg">
                <div class="row">
                    <div class="large-12 columns">
                        <div class="wide-nav tradeace-wrap-width-main-menu tradeace-bg-wrap<?php echo esc_attr($menu_warp_class); ?>">
                            <div class="tradeace-menus-wrapper-reponsive" data-padding_y="<?php echo (int) $data_padding_y; ?>" data-padding_x="<?php echo (int) $data_padding_x; ?>">
                                <div id="tradeace-menu-vertical-header" class="tradeace-menu-vertical-header rtl-right">
                                    <?php tradeace_get_vertical_menu(); ?>
                                </div>
                                
                                <?php tradeace_get_main_menu(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if (isset($show_cat_top_filter) && $show_cat_top_filter) : ?>
                <div class="tradeace-top-cat-filter-wrap">
                    <?php echo tradeace_get_all_categories(false, true); ?>
                    <a href="javascript:void(0);" title="<?php esc_attr_e('Close', 'tradeace-theme'); ?>" class="tradeace-close-filter-cat tradeace-stclose tradeace-transition" rel="nofollow"></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
