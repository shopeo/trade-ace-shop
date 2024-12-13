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
            
            <div class="row tradeace-wrap-event-search tradeace-hide-for-mobile tradeace-elements-wrap">
                <!-- Logo -->
                <div class="large-3 columns tradeace-min-height rtl-right rtl-text-right">
                    <?php echo tradeace_logo(); ?>
                </div>

                <!-- Group icon search -->
                <div class="large-6 columns rtl-right">
                    <!-- Search form in header -->
                    <div class="tradeace-header-search-wrap tradeace-search-relative">
                        <?php echo tradeace_search('full'); ?>
                    </div>
                </div>

                <!-- Group icon header -->
                <div class="large-3 columns rtl-left rtl-text-left">
                    <?php echo $tradeace_header_icons; ?>
                </div>
            </div>
            
            <!-- Main menu -->
            <?php if (!$fullwidth_main_menu) : ?>
            <div class="row">
                <div class="large-12 columns">
            <?php endif; ?>
                    <div class="tradeace-elements-wrap tradeace-elements-wrap-main-menu tradeace-hide-for-mobile tradeace-bg-dark text-center">
                        <div class="row">
                            <div class="large-12 columns">
                                <div class="wide-nav tradeace-wrap-width-main-menu tradeace-bg-wrap<?php echo esc_attr($menu_warp_class); ?>">
                                    <div class="tradeace-menus-wrapper-reponsive" data-padding_y="<?php echo (int) $data_padding_y; ?>" data-padding_x="<?php echo (int) $data_padding_x; ?>">
                                        <?php tradeace_get_main_menu(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php if (!$fullwidth_main_menu) : ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (isset($show_cat_top_filter) && $show_cat_top_filter) : ?>
                <div class="tradeace-top-cat-filter-wrap">
                    <?php echo tradeace_get_all_categories(false, true); ?>
                    <a href="javascript:void(0);" title="<?php esc_attr_e('Close', 'tradeace-theme'); ?>" class="tradeace-close-filter-cat tradeace-stclose tradeace-transition" rel="nofollow"></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
