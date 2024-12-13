<div class="<?php echo esc_attr($header_classes); ?>">
    <div class="sticky-wrapper">
        <div id="masthead" class="site-header">
            <?php do_action('tradeace_mobile_header'); ?>
            
            <div class="row tradeace-hide-for-mobile">
                <div class="large-12 columns tradeace-wrap-event-search">
                    <div class="row tradeace-elements-wrap">
                        <!-- Group icon header -->
                        <div class="large-4 columns tradeace-min-height first-columns rtl-right">
                            <a class="tradeace-menu-off tradeace-icon fa fa-bars" href="javascript:void(0);" rel="nofollow"></a>
                            <a class="search-icon desk-search tradeace-icon tradeace-search icon-tradeace-search inline-block" href="javascript:void(0);" data-open="0" title="Search" rel="nofollow"></a>
                        </div>

                        <!-- Logo -->
                        <div class="large-4 columns tradeace-fixed-height text-center rtl-right">
                            <?php echo tradeace_logo(); ?>
                        </div>

                        <!-- Group icon header -->
                        <div class="large-4 columns rtl-right">
                            <?php echo $tradeace_header_icons; ?>
                        </div>
                    </div>
                    
                    <div class="tradeace-header-search-wrap">
                        <?php echo tradeace_search('icon'); ?>
                    </div>
                </div>
            </div>
            
            <!-- Main menu -->
            <div class="tradeace-off-canvas hidden-tag">
                <?php tradeace_get_main_menu(); ?>
                <?php do_action('tradeace_multi_lc'); ?>
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
