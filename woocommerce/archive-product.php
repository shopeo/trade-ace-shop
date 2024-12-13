<?php
/**
 * Archive Products Page
 *
 * @author  TradeaceTheme
 * @package Tradeace-theme/WooCommerce
 * @version 3.4.0
 */
if (!defined('ABSPATH')){
    exit; // Exit if accessed directly
}

global $tradeace_opt, $wp_query;

$tradeace_ajax_product = isset($tradeace_opt['disable_ajax_product']) && $tradeace_opt['disable_ajax_product'] ? false : true;
defined('TRADEACE_AJAX_SHOP') or define('TRADEACE_AJAX_SHOP', $tradeace_ajax_product);

/**
 * Override cat side-bar layout
 */
$rootCatId = tradeace_get_root_term_id();
if ($rootCatId) {
    $sidebar_style = get_term_meta($rootCatId, 'cat_sidebar_layout', true);
    if ($sidebar_style != '') {
        $tradeace_opt['category_sidebar'] = $sidebar_style;
    }
}

$typeView = !isset($tradeace_opt['products_type_view']) ?
    'grid' : ($tradeace_opt['products_type_view'] == 'list' ? 'list' : 'grid');

$tradeace_opt['products_per_row'] = isset($tradeace_opt['products_per_row']) && (int) $tradeace_opt['products_per_row'] ?
    (int) $tradeace_opt['products_per_row'] : 4;
$tradeace_opt['products_per_row'] = $tradeace_opt['products_per_row'] > 6 || $tradeace_opt['products_per_row'] < 2 ? 4 : $tradeace_opt['products_per_row'];

$tradeace_change_view = !isset($tradeace_opt['enable_change_view']) || $tradeace_opt['enable_change_view'] ? true : false;
$grid_cookie_name = 'archive_grid_view';
$siteurl = get_option('siteurl');
$grid_cookie_name .= $siteurl ? '_' . md5($siteurl) : '';
$typeShow = $typeView == 'grid' ? ($typeView . '-' . ((int) $tradeace_opt['products_per_row'])) : 'list';
$typeShow = $tradeace_change_view && isset($_COOKIE[$grid_cookie_name]) ? $_COOKIE[$grid_cookie_name] : $typeShow;

$tradeace_cat_obj = $wp_query->get_queried_object();
$tradeace_term_id = 0;
$tradeace_type_page = 'product_cat';
$tradeace_href_page = '';
if (isset($tradeace_cat_obj->term_id) && isset($tradeace_cat_obj->taxonomy)) {
    $tradeace_term_id = (int) $tradeace_cat_obj->term_id;
    $tradeace_type_page = $tradeace_cat_obj->taxonomy;
    $tradeace_href_page = esc_url(get_term_link($tradeace_cat_obj, $tradeace_type_page));
}

$tradeace_sidebar = isset($tradeace_opt['category_sidebar']) ? $tradeace_opt['category_sidebar'] : 'left-classic';
$tradeace_has_get_sidebar = false;

if (isset($_REQUEST['sidebar']) && defined('TRADEACETHEME_DEMO') && TRADEACETHEME_DEMO):
    $tradeace_has_get_sidebar = true;
endif;

$hasSidebar = true;
$topSidebar = false;
$topSidebar2 = false;
$topbarWrap_class = 'row filters-container tradeace-filter-wrap';
$attr = 'tradeace-products-page-wrap ';
$class_wrap_archive = 'row fullwidth category-page';
switch ($tradeace_sidebar):
    case 'right':
    case 'left':
        $attr .= 'large-12 columns has-sidebar';
        break;
    
    case 'right-classic':
        $attr .= 'large-9 columns left has-sidebar';
        $class_wrap_archive .= ' tradeace-with-sidebar-classic';
        break;
    
    case 'no':
        $hasSidebar = false;
        $attr .= 'large-12 columns no-sidebar';
        break;
    
    case 'top':
        $hasSidebar = false;
        $topSidebar = true;
        $topbarWrap_class .= ' top-bar-wrap-type-1';
        $attr .= 'large-12 columns no-sidebar top-sidebar';
        $class_wrap_archive .= ' tradeace-top-sidebar-style';
        break;
    
    case 'top-2':
        $hasSidebar = false;
        $topSidebar2 = true;
        $topbarWrap_class .= ' top-bar-wrap-type-2';
        $attr .= 'large-12 columns no-sidebar top-sidebar-2';
        break;
    
    case 'left-classic':
    default :
        $attr .= 'large-9 columns right has-sidebar';
        $class_wrap_archive .= ' tradeace-with-sidebar-classic';
        break;
endswitch;

$tradeace_recom_pos = isset($tradeace_opt['recommend_product_position']) ? $tradeace_opt['recommend_product_position'] : 'bot';

$layout_style = '';
if (isset($tradeace_opt['products_layout_style']) && $tradeace_opt['products_layout_style'] == 'masonry-isotope') :
    $layout_style = ' tradeace-products-masonry-isotope';
    $layout_style .= isset($tradeace_opt['products_masonry_mode']) ? ' tradeace-mode-' . $tradeace_opt['products_masonry_mode'] : '';
endif;

/**
 * Header Shop
 */
get_header('shop');

do_action('woocommerce_before_main_content');
?>
<div class="<?php echo esc_attr($class_wrap_archive); ?>">
    <div class="tradeace_shop_description-wrap large-12 columns">
        <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
            <h1 class="woocommerce-products-header__title page-title text-center margin-top-50 hidden-tag">
                <?php woocommerce_page_title(); ?>
            </h1>
	<?php endif; ?>
        
        <?php
        /**
         * Hook: woocommerce_archive_description.
         *
         * @hooked woocommerce_taxonomy_archive_description - 10
         * @hooked woocommerce_product_archive_description - 10
         */
        do_action('woocommerce_archive_description');
        ?>
    </div>
    
    <?php
    /**
     * Hook: tradeace_before_archive_products.
     */
    do_action('tradeace_before_archive_products');
    ?>
    
    <div class="large-12 columns">
        <div class="<?php echo esc_attr($topbarWrap_class); ?>">
            <?php
            /**
             * Top Side bar Type 1
             */
            if ($topSidebar) :
                $topSidebar_wrap = $tradeace_change_view ? 'large-10 medium-12 ' : 'large-12 ';

                if (!isset($tradeace_opt['showing_info_top']) || $tradeace_opt['showing_info_top']) :
                    echo '<div class="showing_info_top hidden-tag">';
                    do_action('tradeace_shop_category_count');
                    echo '</div>';
                endif;
                ?>

                <div class="<?php echo esc_attr($topSidebar_wrap); ?>columns tradeace-topbar-filter-wrap">
                    <div class="row">
                        <div class="large-10 medium-10 columns tradeace-filter-action">
                            <div class="tradeace-labels-filter-top">
                                <input name="tradeace-labels-filter-text" type="hidden" value="<?php echo (!isset($tradeace_opt['top_bar_archive_label']) || $tradeace_opt['top_bar_archive_label'] == 'Filter by:') ? esc_attr__('Filter by:', 'tradeace-theme') : esc_attr($tradeace_opt['top_bar_archive_label']); ?>" />
                                <input name="tradeace-widget-show-more-text" type="hidden" value="<?php echo esc_attr__('More +', 'tradeace-theme'); ?>" />
                                <input name="tradeace-widget-show-less-text" type="hidden" value="<?php echo esc_attr__('Less -', 'tradeace-theme'); ?>" />
                                <input name="tradeace-limit-widgets-show-more" type="hidden" value="<?php echo (!isset($tradeace_opt['limit_widgets_show_more']) || (int) $tradeace_opt['limit_widgets_show_more'] < 0) ? '2' : (int) $tradeace_opt['limit_widgets_show_more']; ?>" />
                                <a class="toggle-topbar-shop-mobile hidden-tag" href="javascript:void(0);" rel="nofollow">
                                    <i class="pe-7s-filter"></i><?php echo esc_attr__('&nbsp;Filters', 'tradeace-theme'); ?>
                                </a>
                                <span class="tradeace-labels-filter-accordion"></span>
                            </div>
                        </div>
                        
                        <div class="large-2 medium-2 columns tradeace-sort-by-action right rtl-left">
                            <ul class="sort-bar tradeace-float-none margin-top-0">
                                <li class="sort-bar-text tradeace-order-label hidden-tag">
                                    <?php esc_html_e('Sort by', 'tradeace-theme'); ?>
                                </li>
                                <li class="tradeace-filter-order filter-order">
                                    <?php woocommerce_catalog_ordering(); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <?php if ($tradeace_change_view) : ?>
                    <div class="large-2 hide-for-medium columns tradeace-topbar-change-view-wrap">
                        <?php
                        /**
                         * Change view ICONS
                         */
                        $type_sidebar = (!isset($tradeace_opt['top_bar_cat_pos']) || $tradeace_opt['top_bar_cat_pos'] == 'left-bar') ? 'top-push-cat' : 'no';
                        do_action('tradeace_change_view', $tradeace_change_view, $typeShow, $type_sidebar); ?>
                    </div>
                <?php endif; ?>

                <?php
                /**
                 * Sidebar TOP
                 */
                do_action('tradeace_top_sidebar_shop');
                
            /**
             * Top Side bar type 2
             */
            elseif ($topSidebar2) :
                ?>
                <div class="large-12 columns">
                    <div class="row">
                        <div class="large-4 medium-6 small-6 columns tradeace-toggle-top-bar rtl-right">
                            <a class="tradeace-toggle-top-bar-click" href="javascript:void(0);" rel="nofollow">
                                <?php esc_html_e('Filters', 'tradeace-theme'); ?>
                            </a>
                        </div>
                        
                        <div class="large-4 columns tradeace-topbar-change-view-wrap hide-for-medium hide-for-small text-center rtl-right">
                            <?php if ($tradeace_change_view) : ?>
                                <?php
                                /**
                                 * Change view ICONS
                                 */
                                do_action('tradeace_change_view', $tradeace_change_view, $typeShow); ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="large-4 medium-6 small-6 columns tradeace-sort-by-action tradeace-clear-none text-right rtl-text-left">
                            <ul class="sort-bar tradeace-float-none margin-top-0">
                                <li class="tradeace-filter-order filter-order">
                                    <?php woocommerce_catalog_ordering(); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="large-12 columns tradeace-top-bar-2-content hidden-tag">
                    <?php do_action('tradeace_top_sidebar_shop', '2'); ?>
                </div>
            
            <?php
            /**
             * TOGGLE Side bar in side (Off-Canvas)
             */
            elseif ($hasSidebar && in_array($tradeace_sidebar, array('left', 'right'))) : ?>
                <div class="large-4 medium-6 small-6 columns tradeace-toggle-layout-side-sidebar">
                    <div class="li-toggle-sidebar">
                        <a class="toggle-sidebar-shop" href="javascript:void(0);" rel="nofollow">
                            <i class="pe-7s-filter"></i><?php esc_html_e('&nbsp;Filters', 'tradeace-theme'); ?>
                        </a>
                    </div>
                </div>
                
                <div class="large-4 columns hide-for-medium hide-for-small tradeace-change-view-layout-side-sidebar tradeace-min-height">
                    <?php
                    /**
                     * Change view ICONS
                     */
                    do_action('tradeace_change_view', $tradeace_change_view, $typeShow); ?>
                </div>
            
                <div class="large-4 medium-6 small-6 columns tradeace-sort-bar-layout-side-sidebar tradeace-clear-none tradeace-min-height">
                    <ul class="sort-bar">
                        <li class="sort-bar-text tradeace-order-label hidden-tag">
                            <?php esc_html_e('Sort by: ', 'tradeace-theme'); ?>
                        </li>
                        <li class="tradeace-filter-order filter-order">
                            <?php woocommerce_catalog_ordering(); ?>
                        </li>
                    </ul>
                </div>
            <?php
            
            /**
             * No | left-classic | right-classic side bar
             */
            else : ?>
                <div class="large-4 medium-6 columns hide-for-small text-left">
                    <?php
                        $toggle_sidebar = !isset($tradeace_opt['toggle_sidebar_classic']) || $tradeace_opt['toggle_sidebar_classic'] ? true : false;
                        if (!$toggle_sidebar) :
                            if (!isset($tradeace_opt['showing_info_top']) || $tradeace_opt['showing_info_top']) :
                                echo '<div class="showing_info_top">';
                                do_action('tradeace_shop_category_count');
                                echo '</div>';
                            else :
                                echo '&nbsp;';
                            endif;
                        else :
                            echo '<a href="javascript:void(0);" class="tradeace-toogle-sidebar-classic tradeace-hide-in-mobile rtl-text-right" rel="nofollow">' . esc_html__('Filters', 'tradeace-theme') . '</a>';
                        endif;
                    ?>
                </div>
                
                <div class="large-4 columns hide-for-medium hide-for-small tradeace-change-view-layout-side-sidebar tradeace-min-height">
                    <?php
                    /**
                     * Change view ICONS
                     */
                    do_action('tradeace_change_view', $tradeace_change_view, $typeShow, $tradeace_sidebar);
                    ?>
                </div>
            
                <div class="large-4 medium-6 small-12 columns tradeace-clear-none tradeace-sort-bar-layout-side-sidebar">
                    <ul class="sort-bar">
                        <?php if ($hasSidebar): ?>
                            <li class="li-toggle-sidebar">
                                <a class="toggle-sidebar" href="javascript:void(0);" rel="nofollow">
                                    <i class="pe-7s-filter"></i> <?php esc_html_e('Filters', 'tradeace-theme'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <li class="sort-bar-text tradeace-order-label hidden-tag">
                            <?php esc_html_e('Sort by: ', 'tradeace-theme'); ?>
                        </li>
                        <li class="tradeace-filter-order filter-order">
                            <?php woocommerce_catalog_ordering(); ?>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="tradeace-archive-product-content">
        <?php if ($topSidebar && (!isset($tradeace_opt['top_bar_cat_pos']) || $tradeace_opt['top_bar_cat_pos'] == 'left-bar')) :
            $attr .= ' tradeace-has-push-cat';
            $class_cat_top = 'tradeace-push-cat-filter';
            if (isset($_REQUEST['categories-filter-show']) && $_REQUEST['categories-filter-show']) :
                $class_cat_top .= ' tradeace-push-cat-show';
                $attr .= ' tradeace-push-cat-show';
            endif; ?>
            
            <div class="<?php echo esc_attr($class_cat_top); ?>"></div>
        <?php endif; ?>
        
        <div class="<?php echo esc_attr($attr); ?>">

            <?php if ($tradeace_recom_pos !== 'bot' && defined('TRADEACE_CORE_ACTIVED') && TRADEACE_CORE_ACTIVED) : ?>
                <?php do_action('tradeace_recommend_product', $tradeace_term_id); ?>
            <?php endif; ?>

            <div class="tradeace-archive-product-warp<?php echo esc_attr($layout_style); ?>">
                <?php
                if (woocommerce_product_loop()) :
                    /**
                     * Before Shop Loop
                     */
                    do_action('woocommerce_before_shop_loop');
                    
                    /**
                     * Content products in shop
                     */
                    if (TRADEACE_WOO_ACTIVED && version_compare(WC()->version, '3.3.0', "<")) :
                        do_action('tradeace_archive_get_sub_categories');
                    endif;
                    
                    woocommerce_product_loop_start();
                    do_action('tradeace_get_content_products', $tradeace_sidebar);
                    woocommerce_product_loop_end();
                    
                    /**
                     * Hook: woocommerce_after_shop_loop.
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action('woocommerce_after_shop_loop');
                else :
                    echo '<div class="row"><div class="large-12 columns tradeace-archive-no-result">';
                    do_action('woocommerce_no_products_found');
                    echo '</div></div>';
                endif;
                ?>
            </div>

            <?php if ($tradeace_recom_pos == 'bot' && defined('TRADEACE_CORE_ACTIVED') && TRADEACE_CORE_ACTIVED) :?>
                <?php do_action('tradeace_recommend_product', $tradeace_term_id); ?>
            <?php endif; ?>
        </div>

        <?php
        /**
         * Sidebar LEFT | RIGHT
         */
        if ($hasSidebar && !$topSidebar && !$topSidebar2) :
            do_action('tradeace_sidebar_shop', $tradeace_sidebar);
        endif;
        
        ?>
    </div>
    
    <?php
    /**
     * Ajax enable
     */
    if ($tradeace_ajax_product) :
        ?>
        <div class="tradeace-has-filter-ajax hidden-tag">
            <div class="current-tax-item hidden-tag">
                <a data-id="<?php echo (int) $tradeace_term_id; ?>" href="<?php echo esc_url($tradeace_href_page); ?>" class="tradeace-filter-by-tax" id="tradeace-hidden-current-tax" data-taxonomy="<?php echo esc_attr($tradeace_type_page); ?>" data-sidebar="<?php echo esc_attr($tradeace_sidebar); ?>"></a>
            </div>
            <p><?php esc_html_e('No products were found matching your selection.', 'tradeace-theme'); ?></p>
            <?php if ($s = get_search_query()): ?>
                <input type="hidden" name="tradeace_hasSearch" id="tradeace_hasSearch" value="<?php echo esc_attr($s); ?>" />
            <?php endif; ?>
            <?php if ($tradeace_has_get_sidebar) : ?>
                <input type="hidden" name="tradeace_getSidebar" id="tradeace_getSidebar" value="<?php echo esc_attr($tradeace_sidebar); ?>" />
            <?php endif; ?>

            <?php
            // <!-- Current URL -->
            $slug_nopaging = tradeace_nopaging_url();
            echo $slug_nopaging ? '<input type="hidden" name="tradeace_current-slug" id="tradeace_current-slug" value="' . esc_url($slug_nopaging) . '" />' : '';

            /**
             * Default Sorting
             */
            $default_sort = get_option('woocommerce_default_catalog_orderby', 'menu_order');
            echo '<input type="hidden" name="tradeace_default_sort" id="tradeace_default_sort" value="' . esc_attr($default_sort) . '" />';
            
            /**
             * Links
             */
            $shop_url   = wc_get_page_permalink('shop');
            $base_url   = home_url('/');
            $friendly   = preg_match('/\?post_type\=/', $shop_url) ? '0' : '1';
            if (preg_match('/\?page_id\=/', $shop_url)){
                $friendly = '0';
                $shop_url = $base_url . '?post_type=product';
            }

            echo '<input type="hidden" name="tradeace-shop-page-url" value="' . esc_url($shop_url) . '" />';
            echo '<input type="hidden" name="tradeace-base-url" value="' . esc_url($base_url) . '" />';
            echo '<input type="hidden" name="tradeace-friendly-url" value="' . esc_attr($friendly) . '" />';

            if (isset($_GET) && !empty($_GET)) {
                echo '<div class="hidden-tag tradeace-value-gets">';
                foreach ($_GET as $key => $value) {
                    if (!in_array($key, array('add-to-cart'))) {
                        echo '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
                    }
                }
                echo '</div>';
            }
            ?>
        </div>
        <?php
    endif;
    ?>
</div>

<?php
do_action('woocommerce_after_main_content');

/**
 * Footer Shop
 */
get_footer('shop');
