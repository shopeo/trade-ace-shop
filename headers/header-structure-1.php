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
            
            <div class="row">
                <div class="large-12 columns header-container">
                    <div class="tradeace-hide-for-mobile tradeace-wrap-event-search">
                        <div class="tradeace-relative tradeace-elements-wrap tradeace-wrap-width-main-menu">
                            <div class="tradeace-transition tradeace-left-main-header tradeace-float-left">
                                <!-- Logo -->
                                <?php echo tradeace_logo(); ?>

                                <!-- Main menu -->
                                <div class="wide-nav tradeace-float-right tradeace-bg-wrap<?php echo esc_attr($menu_warp_class); ?>">
                                    <div class="tradeace-menus-wrapper-reponsive" data-padding_y="<?php echo (int) $data_padding_y; ?>" data-padding_x="<?php echo (int) $data_padding_x; ?>">
                                        <?php tradeace_get_main_menu(); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Group icon header -->
                            <div class="tradeace-right-main-header tradeace-float-right">
                                <?php echo $tradeace_header_icons; ?>
                            </div>

                            <div class="tradeace-clear-both"></div>
                        </div>

                        <!-- Search form in header -->
                        <div class="tradeace-header-search-wrap tradeace-hide-for-mobile">
                            <?php echo tradeace_search('icon'); ?>
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
