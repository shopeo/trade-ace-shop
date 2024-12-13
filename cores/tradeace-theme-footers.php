<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Footer output
 * since 4.0
 */
add_action('tradeace_footer_layout_style', 'tradeace_footer_output');
if (!function_exists('tradeace_footer_output')) :
    function tradeace_footer_output() {
        global $tradeace_opt, $wp_query;
        
        $inMobile = isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile'] ? true : false;
        
        $footer_mode = isset($tradeace_opt['footer_mode']) ? $tradeace_opt['footer_mode'] : 'builder';
        
        $footer_builder = isset($tradeace_opt['footer-type']) ? $tradeace_opt['footer-type'] : false;
        $footer_builder_m = isset($tradeace_opt['footer-mobile']) ? $tradeace_opt['footer-mobile'] : false;
        
        $footer_buildin = isset($tradeace_opt['footer_build_in']) ? $tradeace_opt['footer_build_in'] : false;
        $footer_buildin_m = isset($tradeace_opt['footer_build_in_mobile']) ? $tradeace_opt['footer_build_in_mobile'] : false;
        $footer_buildin_m = $footer_buildin_m === '' ? $footer_buildin : $footer_buildin_m; // Ext-Desktop
        
        $footer_builder_e = isset($tradeace_opt['footer_elm']) ? $tradeace_opt['footer_elm'] : false;
        $footer_builder_e_m = isset($tradeace_opt['footer_elm_mobile']) ? $tradeace_opt['footer_elm_mobile'] : false;
        $footer_builder_e_m = $footer_builder_e_m ? $footer_builder_e_m : $footer_builder_e; // Ext-Desktop
        
        $footer = false;
        $footer_override = false;
        $footer_mode_override = false;
        
        if ($footer_mode == 'builder') {
            $footer = $inMobile ? $footer_builder_m : $footer_builder;
        }
        
        if ($footer_mode == 'build-in') {
            $footer = $inMobile ? $footer_buildin_m : $footer_buildin;
        }
        
        if ($footer_mode == 'builder-e') {
            $footer = $inMobile ? $footer_builder_e_m : $footer_builder_e;
        }
        
        $page_id = false;
        $root_term_id = tradeace_get_root_term_id();
        
        /*
         * For Page
         */
        if (!$root_term_id) {
            /*
             * Override Footer
             */
            $is_shop = $pageShop = $is_product_taxonomy = false;
            if (TRADEACE_WOO_ACTIVED) {
                $is_shop = is_shop();
                $is_product_taxonomy = is_product_taxonomy();
                $pageShop = wc_get_page_id('shop');
            }

            if (($is_shop || $is_product_taxonomy) && $pageShop > 0) {
                $page_id = $pageShop;
            }

            /**
             * Page
             */
            if (!$page_id) {
                $page_id = $wp_query->get_queried_object_id();
            }
            
            /**
             * Switch footer
             */
            if ($page_id) {
                $footer_mode_override = get_post_meta($page_id, '_tradeace_footer_mode', true);
                
                if ($inMobile) {
                    switch ($footer_mode_override) :
                        case 'builder' :
                            $footer_override = get_post_meta($page_id, '_tradeace_custom_footer_mobile', true);
                            break;
                        
                        case 'build-in' :
                            $footer_override = get_post_meta($page_id, '_tradeace_footer_build_in_mobile', true);
                            if ($footer_override == '') {
                                $footer_override = get_post_meta($page_id, '_tradeace_footer_build_in', true);
                            }
                            break;
                            
                        case 'builder-e' :
                            $footer_override = get_post_meta($page_id, '_tradeace_footer_builder_e_mobile', true);
                            if (!$footer_override) {
                                $footer_override = get_post_meta($page_id, '_tradeace_footer_builder_e', true);
                            }
                            break;
                        
                        default :
                            
                            break;
                    endswitch;
                }
                
                /* Desktop */
                else {
                    switch ($footer_mode_override) :
                        case 'builder' :
                            $footer_override = get_post_meta($page_id, '_tradeace_custom_footer', true);
                            break;
                        
                        case 'build-in' :
                            $footer_override = get_post_meta($page_id, '_tradeace_footer_build_in', true);
                            break;
                        
                        case 'builder-e' :
                            $footer_override = get_post_meta($page_id, '_tradeace_footer_builder_e', true);
                            break;
                        
                        default :
                            
                            break;
                    endswitch;
                }
            }
        }
        
        /**
         * For Root Category
         */
        else {
            $footer_mode_override = get_term_meta($root_term_id, 'cat_footer_mode', true);
            
            /**
             * Mobile
             */
            if ($inMobile) {
                switch ($footer_mode_override) :
                    case 'builder' :
                        $footer_override = get_term_meta($root_term_id, 'cat_footer_mobile', true);
                        break;

                    case 'build-in' :
                        $footer_override = get_term_meta($root_term_id, 'cat_footer_build_in_mobile', true);
                        if ($footer_override == '') {
                            $footer_override = get_term_meta($root_term_id, 'cat_footer_build_in', true);
                        }
                        break;
                        
                    case 'builder-e' :
                        $footer_override = get_term_meta($root_term_id, 'cat_footer_builder_e_mobile', true);
                        if (!$footer_override) {
                            $footer_override = get_term_meta($root_term_id, 'cat_footer_builder_e', true);
                        }
                        break;

                    default :

                        break;
                endswitch;
            }
            
            /**
             * Desktop
             */
            else {
                switch ($footer_mode_override) :
                    case 'builder' :
                        $footer_override = get_term_meta($root_term_id, 'cat_footer_type', true);
                        break;

                    case 'build-in' :
                        $footer_override = get_term_meta($root_term_id, 'cat_footer_build_in', true);
                        break;
                    
                    case 'builder-e' :
                        $footer_override = get_term_meta($root_term_id, 'cat_footer_builder_e', true);
                        break;

                    default :

                        break;
                endswitch;
            }
        }
        
        
        
        if ($footer_override) {
            $footer = $footer_override;
            $footer_mode = $footer_mode_override;
        }
        
        if (!$footer) {
            return;
        }
        
        do_action('tradeace_before_footer_output');
        
        if ($footer_mode == 'builder') {
            tradeace_footer_builder($footer);
        }

        if ($footer_mode == 'build-in') {
            tradeace_footer_build_in($footer);
        }
        
        if ($footer_mode == 'builder-e') {
            tradeace_footer_builder_elementor($footer);
        }
        
        do_action('tradeace_after_footer_output');
    }
endif;


/**
 * Open wrap Footer
 */
add_action('tradeace_before_footer_output', 'tradeace_before_footer_output');
if (!function_exists('tradeace_before_footer_output')) :
    function tradeace_before_footer_output() {
        echo '<!-- MAIN FOOTER --><footer id="tradeace-footer" class="footer-wrapper tradeace-clear-both">';
    }
endif;

/**
 * Close wrap Footer
 */
add_action('tradeace_after_footer_output', 'tradeace_after_footer_output');
if (!function_exists('tradeace_after_footer_output')) :
    function tradeace_after_footer_output() {
        echo '</footer><!-- END MAIN FOOTER -->';
    }
endif;

/**
 * Footer Builder
 */
if (!function_exists('tradeace_footer_builder')) :
    function tradeace_footer_builder($footer_slug) {
        if (!function_exists('tradeace_get_footer')) {
            return;
        }

        /**
         * get footer content
         */
        echo tradeace_get_footer($footer_slug);
    }
endif;

/**
 * Footer Builder Elementor
 */
if (!function_exists('tradeace_footer_builder_elementor')) :
    function tradeace_footer_builder_elementor($footer_id = 0) {
        if (!shortcode_exists('hfe_template') || !(int) $footer_id) {
            return;
        }

        /**
         * get footer content from Footer Builder By Elementor
         */
        echo do_shortcode('[hfe_template id="' . esc_attr($footer_id) . '"]');
    }
endif;

/**
 * Footer Build-in
 */
if (!function_exists('tradeace_footer_build_in')) :
    function tradeace_footer_build_in($footer) {
        $file = TRADEACE_CHILD_PATH . '/footers/footer-built-in-' . $footer . '.php';
        $real_file = is_file($file) ? $file : TRADEACE_THEME_PATH . '/footers/footer-built-in-' . $footer . '.php';
        
        if (is_file($real_file)) {
            include $real_file;
        }
    }
endif;

/**
 * Footer run static content
 */
add_action('wp_footer', 'tradeace_run_static_content', 9);
if (!function_exists('tradeace_run_static_content')) :
    function tradeace_run_static_content() {
        do_action('tradeace_before_static_content');
        do_action('tradeace_static_content');
        do_action('tradeace_after_static_content');
    }
endif;

/**
 * Group static buttons
 */
add_action('tradeace_static_content', 'tradeace_static_group_btns', 10);
if (!function_exists('tradeace_static_group_btns')) :
    function tradeace_static_group_btns() {
        echo '<!-- Start static group buttons -->';
        echo '<div class="tradeace-static-group-btn">';
        
        do_action('tradeace_static_group_btns');
        
        echo '</div>';
        echo '<!-- End static group buttons -->';
    }
endif;

/**
 * Back to top buttons
 */
add_action('tradeace_static_group_btns', 'tradeace_static_back_to_top_btns');
if (!function_exists('tradeace_static_back_to_top_btns')) :
    function tradeace_static_back_to_top_btns() {
        $btns = '<a href="javascript:void(0);" id="tradeace-back-to-top" class="tradeace-tip tradeace-tip-left" data-tip="' . esc_attr__('Back To Top', 'tradeace-theme') . '" rel="nofollow"><i class="pe-7s-angle-up"></i></a>';
        
        echo apply_filters('tradeace_back_to_top_button', $btns);
    }
endif;

/**
 * static_content
 */
add_action('tradeace_static_content', 'tradeace_static_content_before', 10);
if (!function_exists('tradeace_static_content_before')) :
    function tradeace_static_content_before() {
        echo '<!-- Start static tags -->' .
            '<div class="tradeace-check-reponsive tradeace-desktop-check"></div>' .
            '<div class="tradeace-check-reponsive tradeace-taplet-check"></div>' .
            '<div class="tradeace-check-reponsive tradeace-mobile-check"></div>' .
            '<div class="tradeace-check-reponsive tradeace-switch-check"></div>' .
            '<div class="black-window hidden-tag"></div>' .
            '<div class="white-window hidden-tag"></div>' .
            '<div class="transparent-window hidden-tag"></div>' .
            '<div class="transparent-mobile hidden-tag"></div>' .
            '<div class="black-window-mobile"></div>';
    }
endif;

/**
 * Mobile static
 */
add_action('tradeace_static_content', 'tradeace_static_for_mobile', 12);
if (!function_exists('tradeace_static_for_mobile')) :
    function tradeace_static_for_mobile() {
        global $tradeace_opt;
        ?>
        <div class="warpper-mobile-search hidden-tag">
            <!-- for mobile -->
            <?php
            $search_form_file = TRADEACE_CHILD_PATH . '/includes/tradeace-mobile-product-searchform.php';
            include is_file($search_form_file) ? $search_form_file : TRADEACE_THEME_PATH . '/includes/tradeace-mobile-product-searchform.php';
            ?>
        </div>

        <div id="heading-menu-mobile" class="hidden-tag">
            <i class="fa fa-bars"></i><?php esc_html_e('Navigation','tradeace-theme'); ?>
        </div>
        
        <?php
        $inMobile = isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile'] ? true : false;
        $mainSreen = isset($tradeace_opt['main_screen_acc_mobile']) && !$tradeace_opt['main_screen_acc_mobile'] ? false : true;
        if (!$mainSreen || !$inMobile) :
            if (!isset($tradeace_opt['hide_tini_menu_acc']) || !$tradeace_opt['hide_tini_menu_acc']) : ?>
                <div id="mobile-account" class="hidden-tag">
                    <?php
                    $mobile_acc_file = TRADEACE_CHILD_PATH . '/includes/tradeace-mobile-account.php';
                    include is_file($mobile_acc_file) ? $mobile_acc_file : TRADEACE_THEME_PATH . '/includes/tradeace-mobile-account.php';
                    ?>
                </div>
        <?php
            endif;
        endif;
    }
endif;

/**
 * Static Cart sidebar
 */
add_action('tradeace_static_content', 'tradeace_static_cart_sidebar', 13);
if (!function_exists('tradeace_static_cart_sidebar')) :
    function tradeace_static_cart_sidebar() {
        global $tradeace_opt;
        if (!TRADEACE_WOO_ACTIVED || (isset($tradeace_opt['disable-cart']) && $tradeace_opt['disable-cart'])) {
            return;
        }
        $tradeace_cart_style = isset($tradeace_opt['style-cart']) ? esc_attr($tradeace_opt['style-cart']) : 'style-1';
        ?>
        <div id="cart-sidebar" class="tradeace-static-sidebar <?php echo esc_attr($tradeace_cart_style); ?>">
            <div class="cart-close tradeace-sidebar-close">
                <a href="javascript:void(0);" title="<?php esc_attr_e('Close', 'tradeace-theme'); ?>" rel="nofollow"><?php esc_html_e('Close','tradeace-theme'); ?></a>
                
                <h3 class="tradeace-tit-mycart tradeace-sidebar-tit text-center">
                    <?php echo esc_html__('My Cart', 'tradeace-theme'); ?>
                </h3>
            </div>
            
            <div class="widget_shopping_cart_content">
                <input type="hidden" name="tradeace-mini-cart-empty-content" />
            </div>
            
            <?php if (isset($_REQUEST['tradeace_cart_sidebar']) && $_REQUEST['tradeace_cart_sidebar'] == 1) : ?>
                <input type="hidden" name="tradeace_cart_sidebar_show" value="1" />
            <?php endif; ?>
        </div>
        <?php
    }
endif;

/**
 * Static Wishlist sidebar
 */
add_action('tradeace_static_content', 'tradeace_static_wishlist_sidebar', 14);
if (!function_exists('tradeace_static_wishlist_sidebar')) :
    function tradeace_static_wishlist_sidebar() {
        if (!TRADEACE_WOO_ACTIVED) {
            return;
        }
        
        global $tradeace_opt;
        
        if (TRADEACE_WISHLIST_ENABLE) {
            echo '<input type="hidden" name="tradeace_yith_wishlist_actived" value="1" />';
        }
        
        if (!TRADEACE_WISHLIST_ENABLE) {
            if (isset($tradeace_opt['enable_tradeace_wishlist']) && !$tradeace_opt['enable_tradeace_wishlist']) {
                return;
            }
            
            $tradeace_wishlist = function_exists('tradeace_woo_wishlist') ? tradeace_woo_wishlist() : null;
            if ($tradeace_wishlist) {
                echo '<input type="hidden" name="tradeace_wishlist_cookie_name" value="' . $tradeace_wishlist->get_cookie_name() . '" />';
            }
        }
        
        $tradeace_wishlist_style = isset($tradeace_opt['style-wishlist']) ? esc_attr($tradeace_opt['style-wishlist']) : 'style-1';
        ?>
        <div id="tradeace-wishlist-sidebar" class="tradeace-static-sidebar <?php echo esc_attr($tradeace_wishlist_style); ?>">
            <div class="wishlist-close tradeace-sidebar-close">
                <a href="javascript:void(0);" title="<?php esc_attr_e('Close', 'tradeace-theme'); ?>" rel="nofollow">
                    <?php esc_html_e('Close', 'tradeace-theme'); ?>
                </a>
                
                <h3 class="tradeace-tit-wishlist tradeace-sidebar-tit text-center">
                    <?php echo esc_html__('Wishlist', 'tradeace-theme'); ?>
                </h3>
            </div>
            
            <?php echo tradeace_loader_html('tradeace-wishlist-sidebar-content'); ?>
        </div>
        <?php
    }
endif;

/**
 * Static Login / Register
 */
add_action('tradeace_static_content', 'tradeace_static_login_register', 15);
if (!function_exists('tradeace_static_login_register')) :
    function tradeace_static_login_register() {
        global $tradeace_opt;
        
        if (did_action('tradeace_init_login_register_form')) {
            return;
        }
        
        if (!TRADEACE_CORE_USER_LOGGED && shortcode_exists('woocommerce_my_account') && (!isset($tradeace_opt['login_ajax']) || $tradeace_opt['login_ajax'] == 1)) : ?>
            <div class="tradeace-login-register-warper">
                <div id="tradeace-login-register-form">
                    <div class="tradeace-form-logo-log tradeace-no-fix-size-retina">
                        <?php echo tradeace_logo(); ?>
                        
                        <a class="login-register-close" href="javascript:void(0);" title="<?php esc_attr_e('Close', 'tradeace-theme'); ?>" rel="nofollow"><i class="pe-7s-angle-up"></i></a>
                    </div>
                    
                    <div class="tradeace-message margin-top-20"></div>
                    <div class="tradeace-form-content">
                        <?php do_action('tradeace_login_register_form', true); ?>
                    </div>
                </div>
            </div>
        <?php
        endif;
    }
endif;

/**
 * Static Quickview sidebar
 */
add_action('tradeace_static_content', 'tradeace_static_quickview_sidebar', 16);
if (!function_exists('tradeace_static_quickview_sidebar')) :
    function tradeace_static_quickview_sidebar() {
        global $tradeace_opt;
        
        $style_quickview = isset($tradeace_opt['style_quickview']) && in_array($tradeace_opt['style_quickview'], array('sidebar', 'popup')) ? $tradeace_opt['style_quickview'] : 'sidebar';
        
        if ($style_quickview == 'sidebar') : ?>
        <div id="tradeace-quickview-sidebar" class="tradeace-static-sidebar style-1">
            <div class="tradeace-quickview-fog hidden-tag"></div>
            <div class="quickview-close tradeace-sidebar-close">
                <a href="javascript:void(0);" title="<?php esc_attr_e('Close', 'tradeace-theme'); ?>" rel="nofollow"><?php esc_html_e('Close', 'tradeace-theme'); ?></a>
            </div>
            <?php echo tradeace_loader_html('tradeace-quickview-sidebar-content', false); ?>
        </div>
        <?php
        endif;
    }
endif;

/**
 * Static Compare sidebar
 */
add_action('tradeace_static_content', 'tradeace_static_compare_sidebar', 17);
if (!function_exists('tradeace_static_compare_sidebar')) :
    function tradeace_static_compare_sidebar() {
        global $yith_woocompare;
        
        if ($yith_woocompare) {
            $tradeace_compare = isset($yith_woocompare->obj) ?
                $yith_woocompare->obj : $yith_woocompare;
            
            if (isset($tradeace_compare->cookie_name)) {
                echo '<input type="hidden" name="tradeace_woocompare_cookie_name" value="' . $tradeace_compare->cookie_name . '" />';
            }
        }
        ?>
        <div class="tradeace-compare-list-bottom">
            <div id="tradeace-compare-sidebar-content" class="tradeace-relative">
                <div class="tradeace-loader"></div>
            </div>
            <p class="tradeace-compare-mess tradeace-compare-success hidden-tag"></p>
            <p class="tradeace-compare-mess tradeace-compare-exists hidden-tag"></p>
        </div>
        <?php
    }
endif;

/**
 * Mobile Menu
 */
add_action('tradeace_static_content', 'tradeace_static_menu_vertical_mobile', 19);
if (!function_exists('tradeace_static_menu_vertical_mobile')) :
    function tradeace_static_menu_vertical_mobile() {
        global $tradeace_opt;
        
        $class = isset($tradeace_opt['mobile_menu_layout']) ? 
            'tradeace-' . $tradeace_opt['mobile_menu_layout'] : 'tradeace-light-new'; ?>
        
        <div id="tradeace-menu-sidebar-content" class="<?php echo esc_attr($class); ?>">
            <a class="tradeace-close-menu-mobile" href="javascript:void(0);" title="<?php esc_attr_e('Close', 'tradeace-theme'); ?>" rel="nofollow">
                <?php esc_html_e('Close', 'tradeace-theme'); ?>
            </a>
            <div class="tradeace-mobile-nav-wrap">
                <div id="mobile-navigation"></div>
            </div>
        </div>
        <?php
    }
endif;

/**
 * Top Categories filter
 */
add_action('tradeace_static_content', 'tradeace_static_top_cat_filter', 20);
if (!function_exists('tradeace_static_top_cat_filter')) :
    function tradeace_static_top_cat_filter() {
        ?>
        <div class="tradeace-top-cat-filter-wrap-mobile">
            <h3 class="tradeace-tit-filter-cat"><?php echo esc_html__("Categories", 'tradeace-theme'); ?></h3>
            
            <div id="tradeace-mobile-cat-filter">
                <div class="tradeace-loader"></div>
            </div>
            
            <a href="javascript:void(0);" title="<?php esc_attr_e('Close', 'tradeace-theme'); ?>" class="tradeace-close-filter-cat" rel="nofollow"></a>
        </div>
        <?php
    }
endif;

/**
 * Static Configurations
 */
add_action('tradeace_static_content', 'tradeace_static_config_info', 21);
if (!function_exists('tradeace_static_config_info')) :
    function tradeace_static_config_info() {
        global $tradeace_opt, $tradeace_loadmore_style;
        
        $inMobile = isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile'] ? true : false;
        
        /**
         * Paging style in store
         */
        if (isset($_REQUEST['paging-style']) && in_array($_REQUEST['paging-style'], $tradeace_loadmore_style)) {
            echo '<input type="hidden" name="tradeace_loadmore_style" value="' . $_REQUEST['paging-style'] . '" />';
        }
        
        /**
         * Mobile Fixed add to cart in Desktop
         */
        if (!isset($tradeace_opt['enable_fixed_add_to_cart']) || $tradeace_opt['enable_fixed_add_to_cart']) {
            echo '<!-- Enable Fixed add to cart single product -->';
            echo '<input type="hidden" name="tradeace_fixed_single_add_to_cart" value="1" />';
        }
        
        /**
         * Mobile Fixed add to cart in mobile
         */
        if (!isset($tradeace_opt['mobile_fixed_add_to_cart'])) {
            $tradeace_opt['mobile_fixed_add_to_cart'] = 'no';
        }
        echo '<!-- Fixed add to cart single product in Mobile layout -->';
        echo '<input type="hidden" name="tradeace_fixed_mobile_single_add_to_cart_layout" value="' . esc_attr($tradeace_opt['mobile_fixed_add_to_cart']) . '" />';
        
        /**
         * Mobile Detect
         */
        if ($inMobile) {
            echo '<!-- In Mobile -->';
            echo '<input type="hidden" name="tradeace_mobile_layout" value="1" />';
        }
        
        /**
         * Event After add to cart
         */
        $after_add_to_cart = isset($tradeace_opt['event-after-add-to-cart']) ? $tradeace_opt['event-after-add-to-cart'] : 'sidebar';
        echo '<!-- Event After Add To Cart -->';
        echo '<input type="hidden" name="tradeace-event-after-add-to-cart" value="' . esc_attr($after_add_to_cart) . '" />';
        ?>
        
        <!-- Format currency -->
        <input type="hidden" name="tradeace_currency_pos" value="<?php echo get_option('woocommerce_currency_pos'); ?>" />
        
        <!-- URL Logout -->
        <input type="hidden" name="tradeace_logout_menu" value="<?php echo wp_logout_url(home_url('/')); ?>" />
        
        <!-- width toggle Add To Cart | Countdown -->
        <input type="hidden" name="tradeace-toggle-width-product-content" value="<?php echo apply_filters('tradeace_toggle_width_product_content', 180); ?>" />
        
        <!-- Enable focus main image -->
        <input type="hidden" name="tradeace-enable-focus-main-image" value="<?php echo (isset($tradeace_opt['enable_focus_main_image']) && $tradeace_opt['enable_focus_main_image'] == 1) ? '1' : '0'; ?>" />
        
        <!-- Select option to Quick-view -->
        <input type="hidden" name="tradeace-disable-quickview-ux" value="<?php echo (isset($tradeace_opt['disable-quickview']) && $tradeace_opt['disable-quickview'] == 1) ? '1' : '0'; ?>" />
        
        <!-- Close Pop-up string -->
        <input type="hidden" name="tradeace-close-string" value="<?php echo esc_attr__('Close (Esc)', 'tradeace-theme'); ?>" />

        <!-- Text no results in live search products -->
        <p class="hidden-tag" id="tradeace-empty-result-search"><?php esc_html_e('Sorry. No results match your search.', 'tradeace-theme'); ?></p>
        
        <!-- Toggle Select Options Sticky add to cart single product page -->
        <input type="hidden" name="tradeace_select_options_text" value="<?php echo esc_attr__('Select Options', 'tradeace-theme'); ?>" />
        
        <!-- Less Total Count items Wishlist - Compare - (9+) -->
        <input type="hidden" name="tradeace_less_total_items" value="<?php echo (!isset($tradeace_opt['compact_number']) || $tradeace_opt['compact_number']) ? '1' : '0'; ?>" />

        <?php
        echo (defined('TRADEACE_PLG_CACHE_ACTIVE') && TRADEACE_PLG_CACHE_ACTIVE) ? '<input type="hidden" name="tradeace-caching-enable" value="1" />' : '';
    }
endif;
        
/**
 * Bottom Bar menu
 */
add_action('tradeace_static_content', 'tradeace_bottom_bar_menu', 22);
if (!function_exists('tradeace_bottom_bar_menu')):
    function tradeace_bottom_bar_menu() {
        global $tradeace_opt;
        
        if (isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile']) {
            $file = TRADEACE_CHILD_PATH . '/includes/tradeace-mobile-bottom-bar.php';
            include is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-mobile-bottom-bar.php';
        }
    }
endif;

/**
 * Global wishlist template
 */
add_action('tradeace_static_content', 'tradeace_global_wishlist', 25);
if (!function_exists('tradeace_global_wishlist')):
    function tradeace_global_wishlist() {
        global $tradeace_opt;
        
        if (TRADEACE_WISHLIST_ENABLE && 
            (!isset($tradeace_opt['optimize_wishlist_html']) || $tradeace_opt['optimize_wishlist_html'])
        ) {
            $file = TRADEACE_CHILD_PATH . '/includes/tradeace-global-wishlist.php';
            include is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-global-wishlist.php';
        }
    }
endif;

/**
 * Captcha template template
 */
add_action('tradeace_after_static_content', 'tradeace_tmpl_captcha_field_register');
if (!function_exists('tradeace_tmpl_captcha_field_register')):
    function tradeace_tmpl_captcha_field_register() {
        global $tradeace_opt;
        if (!isset($tradeace_opt['register_captcha']) || !$tradeace_opt['register_captcha']) {
            return;
        }
        
        $file = TRADEACE_CHILD_PATH . '/includes/tradeace-tmpl-captcha-field-register.php';
        include is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-tmpl-captcha-field-register.php';
    }
endif;

/**
 * GDPR Message
 */
add_action('tradeace_static_content', 'tradeace_gdpr_notice', 30);
if (!function_exists('tradeace_gdpr_notice')) :
    function tradeace_gdpr_notice() {
        global $tradeace_opt;
        if (!isset($tradeace_opt['tradeace_gdpr_notice']) || !$tradeace_opt['tradeace_gdpr_notice'])  {
            return;
        }

        $enable = !isset($_COOKIE['tradeace_gdpr_notice']) || !$_COOKIE['tradeace_gdpr_notice'] ? true : false;
        if (!$enable) {
            return;
        }
        
        $file = TRADEACE_CHILD_PATH . '/includes/tradeace-gdpr-notice.php';
        include is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-gdpr-notice.php';
    }
endif;

/**
 * Template variation for quick-view product variable
 */
add_action('tradeace_after_static_content', 'tradeace_script_template_variation_quickview');
if (!function_exists('tradeace_script_template_variation_quickview')) :
    function tradeace_script_template_variation_quickview() {
        global $tradeace_opt;
        
        if (isset($tradeace_opt['disable-quickview']) && $tradeace_opt['disable-quickview']) {
            return;
        }
        ?>
        <script type="text/template" id="tmpl-variation-template-tradeace">
            <div class="woocommerce-variation-description">{{{data.variation.variation_description}}}</div>
            <div class="woocommerce-variation-price">{{{data.variation.price_html}}}</div>
            <div class="woocommerce-variation-availability">{{{data.variation.availability_html}}}</div>
        </script>
        <script type="text/template" id="tmpl-unavailable-variation-template-tradeace">
            <p><?php echo esc_html__('Sorry, this product is unavailable. Please choose a different combination.', 'tradeace-theme'); ?></p>
        </script>
        <?php
    }
endif;

/**
 * Header Responsive
 */
add_action('tradeace_after_static_content', 'tradeace_script_template_responsive_header');
if (!function_exists('tradeace_script_template_responsive_header')) :
    function tradeace_script_template_responsive_header() {
        global $tradeace_opt;
        if (!isset($tradeace_opt['tradeace_in_mobile']) || !$tradeace_opt['tradeace_in_mobile']) {
        ?>
        <script type="text/template" id="tmpl-tradeace-responsive-header">
            <?php
            $file = TRADEACE_CHILD_PATH . '/headers/header-responsive.php';
            include is_file($file) ? $file : TRADEACE_THEME_PATH . '/headers/header-responsive.php';
            ?>
        </script>
        <?php
        }
    }
endif;
