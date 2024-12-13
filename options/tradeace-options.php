<?php

/* RTL Mode */
define('TRADEACE_RTL', apply_filters('tradeace_rtl_mode', (function_exists('is_rtl') && is_rtl())));

/* Check if WooCommerce active */
defined('TRADEACE_WOO_ACTIVED') or define('TRADEACE_WOO_ACTIVED', (bool) function_exists('WC'));

/* Check if Elementor active */
defined('TRADEACE_ELEMENTOR_ACTIVE') or define('TRADEACE_ELEMENTOR_ACTIVE', defined('ELEMENTOR_PATH') && ELEMENTOR_PATH);

/**
 * Check Header, Footers Builder support
 */
defined('TRADEACE_HF_BUILDER') or define('TRADEACE_HF_BUILDER', TRADEACE_ELEMENTOR_ACTIVE && function_exists('hfe_init'));

/* Check if DOKAN active */
defined('TRADEACE_DOKAN_ACTIVED') or define('TRADEACE_DOKAN_ACTIVED', (bool) function_exists('dokan'));

defined('TRADEACE_WISHLIST_ENABLE') or define('TRADEACE_WISHLIST_ENABLE', (bool) defined('YITH_WCWL'));

$wishlist_loop = TRADEACE_WISHLIST_ENABLE ? true : false;
$wishlist_new = false;
if (TRADEACE_WISHLIST_ENABLE && defined('YITH_WCWL_VERSION')) {
    if (version_compare(YITH_WCWL_VERSION, '3.0', ">=")) {
        $wishlist_loop = get_option('yith_wcwl_show_on_loop') !== 'yes' ? false : true;
        $wishlist_new = true;
    }
}
define('TRADEACE_WISHLIST_NEW_VER', $wishlist_new);
define('TRADEACE_WISHLIST_IN_LIST', $wishlist_loop);

/* Check if tradeace-core is active */
defined('TRADEACE_CORE_ACTIVED') or define('TRADEACE_CORE_ACTIVED', function_exists('tradeace_setup'));
defined('TRADEACE_CORE_IN_ADMIN') or define('TRADEACE_CORE_IN_ADMIN', is_admin());

/* user info */
defined('TRADEACE_CORE_USER_LOGGED') or define('TRADEACE_CORE_USER_LOGGED', is_user_logged_in());

/* bundle type product */
defined('TRADEACE_COMBO_TYPE') or define('TRADEACE_COMBO_TYPE', 'yith_bundle');

/* Tradeace theme prefix use for tradeace-core */
defined('TRADEACE_THEME_PREFIX') or define('TRADEACE_THEME_PREFIX', 'tradeace');

/* Time now */
defined('TRADEACE_TIME_NOW') or define('TRADEACE_TIME_NOW', time());

/**
 * $tradeace_loadmore_style 
 */
$GLOBALS['tradeace_loadmore_style'] = array('infinite', 'load-more');

/**
 * Cache plugin support
 */
function tradeace_plugins_cache_support() {
    /**
     * Check WP Super Cache active
     */
    global $super_cache_enabled;
    $super_cache_enabled = isset($super_cache_enabled) ? $super_cache_enabled : false;
    
    $plugin_cache_support = (
        /**
         * Check WP_ROCKET active
         */
        (defined('WP_ROCKET_SLUG') && WP_ROCKET_SLUG) ||
        
        /**
         * Check W3 Total Cache active
         */
        (defined('W3TC') && W3TC) ||
            
        /**
         * Check WP Fastest Cache
         */
        class_exists('WpFastestCache') ||
            
        /**
         * Check WP Super Cache active
         */
        (defined('WP_CACHE') && WP_CACHE && $super_cache_enabled) ||
        
        /**
         * Check SG_CachePress
         */
        class_exists('SG_CachePress') ||
        
        /**
         * Check LiteSpeed Cache
         */
        class_exists('LiteSpeed_Cache') ||
            
        /**
         * Check WP Optimize Cache
         */
        class_exists('WP_Optimize') ||

        /**
         * Check AutoptimizeCache active
         */
        class_exists('autoptimizeCache')
    );
    
    return apply_filters('tradeace_plugins_cache_support', $plugin_cache_support);
}

/**
 * init Theme Options - $tradeace_opt
 */
add_action('tradeace_set_options', 'tradeace_get_options');
function tradeace_get_options() {
    $options = get_theme_mods();
    
    if (!empty($options)) {
        foreach ($options as $key => $value) {
            if (is_string($value)) {
                $options[$key] = str_replace(
                    array(
                        '[site_url]', 
                        '[site_url_secure]',
                    ),
                    array(
                        site_url('', 'http'),
                        site_url('', 'https'),
                    ),
                    $value
                );
            }
        }
    }
    
    /**
     * Check Mobile Detect
     */
    $options['tradeace_in_mobile'] = false;
    if (defined('TRADEACE_IS_PHONE') && TRADEACE_IS_PHONE && (!isset($options['enable_tradeace_mobile']) || $options['enable_tradeace_mobile'])) {
        $options['tradeace_in_mobile'] = true;
        $options['showing_info_top'] = false;
        $options['enable_change_view'] = false;
        $options['breadcrumb_row'] = 'single';
    }
    
    /**
     * Check Cache plugin active
     */
    if (!defined('TRADEACE_PLG_CACHE_ACTIVE') && tradeace_plugins_cache_support()) {
        define('TRADEACE_PLG_CACHE_ACTIVE', true);
    }
    
    if (defined('TRADEACE_PLG_CACHE_ACTIVE') && TRADEACE_PLG_CACHE_ACTIVE) {
        /**
         * Disable optimized speed
         */
        $options['enable_optimized_speed'] = '0';
    }
    
    $GLOBALS['tradeace_opt'] = apply_filters('tradeace_theme_options', $options);
}

/**
 * @param $str
 * @return mixed
 */
function tradeace_remove_protocol($str = null) {
    return $str ? str_replace(array('https://', 'http://'), '//', $str) : $str;
}

/**
 * Convert css content
 * 
 * @param type $css
 * @return type
 */
function tradeace_convert_css($css) {
    $css = strip_tags($css);
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    $css = str_replace(': ', ':', $css);
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);

    return $css;
}
/**
 * Darken - Lighten color hex
 * 
 * @param type $hex
 * @param type $percent
 * @return type
 */
function tradeace_pattern_color($hex, $percent) {
    $hash = '';
    
    if (stristr($hex, '#')) {
        $hex = str_replace('#', '', $hex);
        $hash = '#';
    }
    
    // HEX TO RGB
    $rgb = array(
        hexdec(substr($hex, 0, 2)),
        hexdec(substr($hex, 2, 2)),
        hexdec(substr($hex, 4, 2))
    );
    
    // CALCULATE
    for ($i = 0; $i < 3; $i++) {
        // Lighter
        if ($percent > 0) {
            $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1 - $percent));
        }
        
        // Darker
        else {
            $positivePercent = $percent - ($percent * 2);
            $rgb[$i] = round($rgb[$i] * (1 - $positivePercent));
        }
        
        // In case rounding up causes us to go to 256
        if ($rgb[$i] > 255) {
            $rgb[$i] = 255;
        }
    }
    
    // RBG to Hex
    $hex_new = '';
    
    for ($i = 0; $i < 3; $i++) {
        // Convert the decimal digit to hex
        $hexDigit = dechex($rgb[$i]);
        
        // Add a leading zero if necessary
        if (strlen($hexDigit) == 1) {
            $hexDigit = "0" . $hexDigit;
        }
        
        // Append to the hex string
        $hex_new .= $hexDigit;
    }
    
    return $hash . $hex_new;
}

/**
 * wp-admin loading
 */
if (TRADEACE_CORE_IN_ADMIN){
    /**
     *
     * @global type $GLOBALS['tradeace_opt']
     * @name $tradeace_opt 
     */
    if (!did_action('tradeace_set_options')) {
        do_action('tradeace_set_options');
    }
    
    require TRADEACE_THEME_PATH . '/admin/theme-admin.php';
}

/**
 * Main Style and RTL Style
 */
add_action('wp_enqueue_scripts', 'tradeace_enqueue_style', 998);
function tradeace_enqueue_style() {
    global $tradeace_opt;
    
    $inMobile = isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile'] ? true : false;
    
    /**
     * MAIN CSS
     */
    wp_enqueue_style('tradeace-style', get_stylesheet_uri(),array(),null,'all');
    
    /**
     * CSS Animate
     */
    wp_enqueue_style('tradeace-animate', TRADEACE_THEME_URI . '/animate.min.css', array('tradeace-style'));
    
    /**
     * CSS ELEMENTOR
     */
    if (TRADEACE_ELEMENTOR_ACTIVE) {
        wp_enqueue_style('tradeace-style-elementor', TRADEACE_THEME_URI . '/style-elementor.css', array('tradeace-style'));
        
        if ($inMobile && isset($_REQUEST['elementor-preview']) && $_REQUEST['elementor-preview']) {
            wp_enqueue_style('tradeace-style-large', TRADEACE_THEME_URI . '/assets/css/style-large.css', array('tradeace-style'));
        }
    }
    
    /**
     * RTL CSS
     */
    if (TRADEACE_RTL) {
        wp_enqueue_style('tradeace-style-rtl', TRADEACE_THEME_URI . '/style-rtl.css', array('tradeace-style'));
    }
    
    /**
     * Style Large
     */
    if (!$inMobile) {
        wp_enqueue_style('tradeace-style-large', TRADEACE_THEME_URI . '/assets/css/style-large.css', array('tradeace-style'));
    }
    
    /**
     * WPBakery Frontend Editor
     */
    if (isset($_REQUEST['vc_editable']) && 'true' == $_REQUEST['vc_editable']) {
        wp_enqueue_style('tradeace-wpbakery-frontend-editor', TRADEACE_THEME_URI . '/wpbakery-frontend-editor.css', array('tradeace-style'));
    }
    
    /**
     * Compatible with Yith WC Product Bundle plugin
     */
    if (defined('YITH_WCPB')) {
        wp_enqueue_style('tradeace-style-yith_bundle', TRADEACE_THEME_URI . '/assets/css/style-yith_bundle.css', array('tradeace-style'));
    }
    
    /**
     * Posts
     */
    if (tradeace_check_blog_page()) {
        wp_enqueue_style('tradeace-style-posts', TRADEACE_THEME_URI . '/assets/css/style-posts.css', array('tradeace-style'));
    }
    
    /**
     * Store page and not mobile
     */
    if (TRADEACE_WOO_ACTIVED) {
        /**
         * Dokan
         */
        if (TRADEACE_DOKAN_ACTIVED) {
            wp_enqueue_style('tradeace-style-dokan-store', TRADEACE_THEME_URI . '/assets/css/style-dokan-store.css', array('tradeace-style'));
        }
        
        /**
         * Enqueue store CSS
         */
        if (is_shop() || is_product_taxonomy()) {
            if (!$inMobile) {
                wp_enqueue_style('tradeace-style-products-list', TRADEACE_THEME_URI . '/assets/css/style-products-list.css', array('tradeace-style'));
            }
            
            wp_enqueue_style('tradeace-style-archive-products', TRADEACE_THEME_URI . '/assets/css/style-archive-products.css', array('tradeace-style'));
        }
        
        /**
         * Enqueue Single Product CSS
         */
        if (is_product()) {
            wp_enqueue_style('tradeace-style-signle-product', TRADEACE_THEME_URI . '/assets/css/style-single-product.css', array('tradeace-style'));
        }
        
        /**
         * Shopping Cart - Checkout - Thank you pages
         */
        if (is_checkout() || is_cart() || (TRADEACE_CORE_USER_LOGGED && is_account_page())) {
            wp_enqueue_style('tradeace-style-woo-pages', TRADEACE_THEME_URI . '/assets/css/style-woo-pages.css', array('tradeace-style'));
        }
    }
}

/**
 * Font Tradeace Icons
 * Font Awesome
 * Font Pe-icon-7-stroke
 */
add_action('wp_enqueue_scripts', 'tradeace_add_fonts_style');
function tradeace_add_fonts_style() {
    global $tradeace_opt;
    
    /**
     * Minify
     * Include: Font Tradeace Icons, Font Awesome, Font Pe-icon-7-stroke
     */
    if (!isset($tradeace_opt['minify_font_icons']) || $tradeace_opt['minify_font_icons']) {
        wp_enqueue_style('tradeace-fonts-icons', TRADEACE_THEME_URI . '/assets/minify-font-icons/fonts.min.css');
    }
    
    /**
     * No Minify
     */
    else {
        /**
         * Add Tradeace Font
         */
        wp_enqueue_style('tradeace-fonts-icons', TRADEACE_THEME_URI . '/assets/font-tradeace/tradeace-font.css');

        /**
         * Add FontAwesome 4.7.0
         */
        wp_enqueue_style('tradeace-font-awesome-style', TRADEACE_THEME_URI . '/assets/font-awesome-4.7.0/css/font-awesome.min.css', array('tradeace-fonts-icons'));

        /**
         * Add Font Pe7s
         */
        wp_enqueue_style('tradeace-font-pe7s-style', TRADEACE_THEME_URI . '/assets/font-pe-icon-7-stroke/css/pe-icon-7-stroke.css', array('tradeace-fonts-icons'));
    }

    /**
     * Add Font Awesome 5.0.13
     */
    if (isset($tradeace_opt['include_font_awesome_new']) && $tradeace_opt['include_font_awesome_new']) {
        wp_enqueue_style('tradeace-font-awesome-5-free-style', TRADEACE_THEME_URI . '/assets/font-awesome-5.0.13/css/fontawesome-all.min.css', array('tradeace-fonts-icons'));
    }
}

/**
 * enqueue scripts
 */
add_action('wp_enqueue_scripts', 'tradeace_enqueue_scripts', 998);
function tradeace_enqueue_scripts() {
    global $tradeace_opt;
    
    $themeVersion = isset($tradeace_opt['js_theme_version']) && $tradeace_opt['js_theme_version'] ? TRADEACE_VERSION : null;
    
    wp_enqueue_script('jquery-cookie', TRADEACE_THEME_URI . '/assets/js/min/jquery.cookie.min.js', array('jquery'), null, true);
    
    /**
     * magnific popup
     */
    if (!wp_script_is('jquery-magnific-popup')) {
        wp_enqueue_script('jquery-magnific-popup', TRADEACE_THEME_URI . '/assets/js/min/jquery.magnific-popup.js', array('jquery'), null, true);
    }
    
    /**
     * Slick slider
     */
    if (!wp_script_is('jquery-slick')) {
        wp_enqueue_script('jquery-slick', TRADEACE_THEME_URI . '/assets/js/min/jquery.slick.min.js', array('jquery'), null, true);
    }
    
    /**
     * Wow js
     */
    if (!isset($tradeace_opt['disable_wow']) || !$tradeace_opt['disable_wow']) {
        wp_enqueue_script('wow', TRADEACE_THEME_URI . '/assets/js/min/wow.min.js', array('jquery'), null, true);
    }
    
    /**
     * Live search Products
     */
    $enable_live_search = isset($tradeace_opt['enable_live_search']) ? $tradeace_opt['enable_live_search'] : true;
    if ($enable_live_search && TRADEACE_WOO_ACTIVED) {
        wp_enqueue_script('tradeace-typeahead-js', TRADEACE_THEME_URI . '/assets/js/min/typeahead.bundle.min.js', array('jquery'), null, true);
        wp_enqueue_script('tradeace-handlebars', TRADEACE_THEME_URI . '/assets/js/min/handlebars.min.js', array('jquery'), null, true);
        
        $search_options = array(
            'template' =>
                '<div class="item-search">' .
                    '<a href="{{url}}" class="tradeace-link-item-search" title="{{title}}">' .
                        '{{{image}}}' .
                        '<div class="tradeace-item-title-search rtl-right">' .
                            '<p class="tradeace-title-item">{{title}}</p>' .
                            '<div class="price text-left rtl-text-right">{{{price}}}</div>' .
                        '</div>' .
                    '</a>' .
                '</div>',
            
            'limit' => (isset($tradeace_opt['limit_results_search']) && (int) $tradeace_opt['limit_results_search'] > 0) ? (int) $tradeace_opt['limit_results_search'] : 5,
            
            'url' => apply_filters('tradeace_live_search_url', WC_AJAX::get_endpoint('tradeace_search_products'))
        );

        $search_js_inline = 'var search_options=' . json_encode($search_options) . ';';
        wp_add_inline_script('tradeace-typeahead-js', $search_js_inline, 'before');
    }
    
    /**
     * Theme js
     */
    wp_enqueue_script('tradeace-functions-js', TRADEACE_THEME_URI . '/assets/js/min/functions.min.js', array('jquery'), $themeVersion, true);
    wp_enqueue_script('tradeace-js', TRADEACE_THEME_URI . '/assets/js/min/main.min.js', array('jquery'), $themeVersion, true);
    
    /**
     * Define ajax options
     */
    if (!defined('TRADEACE_AJAX_OPTIONS')) {
        define('TRADEACE_AJAX_OPTIONS', true);
        
        $ajax_params_options = array(
            'ajax_url' => esc_url(admin_url('admin-ajax.php'))
        );

        if (TRADEACE_WOO_ACTIVED) {
            $ajax_params_options['wc_ajax_url'] = WC_AJAX::get_endpoint('%%endpoint%%');
        }
        
        $ajax_params = 'var tradeace_ajax_params=' . json_encode($ajax_params_options) . ';';
        wp_add_inline_script('tradeace-functions-js', $ajax_params, 'before');
    }
    
    /**
     * Enqueue store ajax, single product js, quickview
     */
    if (TRADEACE_WOO_ACTIVED) {
        /**
         * For Quick view Product
         */
        if ((!isset($tradeace_opt['disable-quickview']) || !$tradeace_opt['disable-quickview'])) {
            wp_enqueue_script('tradeace-quickview', TRADEACE_THEME_URI . '/assets/js/min/tradeace-quickview.min.js', array('jquery'), null, true);

            $params_variations = array(
                'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
                'i18n_no_matching_variations_text' => esc_attr__('Sorry, no products matched your selection. Please choose a different combination.', 'tradeace-theme'),
                'i18n_make_a_selection_text' => esc_attr__('Please select some product options before adding this product to your cart.', 'tradeace-theme'),
                'i18n_unavailable_text' => esc_attr__('Sorry, this product is unavailable. Please choose a different combination.', 'tradeace-theme')
            );

            wp_add_inline_script('tradeace-quickview', 'var tradeace_params_quickview=' . json_encode($params_variations) . ';', 'before');
        }
        
        /**
         * Shopping Cart - Checkout - Thank you pages
         */
        if (is_checkout() || is_cart() || (TRADEACE_CORE_USER_LOGGED && is_account_page())) {
            wp_enqueue_script('tradeace-woo-pages', TRADEACE_THEME_URI . '/assets/js/min/woo-pages.min.js', array('jquery'), null, true);
        }
        
        /**
         * Enqueue store ajax js
         */
        if (is_shop() || is_product_taxonomy()) {
            wp_enqueue_script('tradeace-store-ajax', TRADEACE_THEME_URI . '/assets/js/min/store-ajax.min.js', array('jquery'), $themeVersion, true);
        }
        
        /**
         * Enqueue Easy zoom js - single product js
         */
        if (is_product()) {
            wp_enqueue_script('jquery-easyzoom', TRADEACE_THEME_URI . '/assets/js/min/jquery.easyzoom.min.js', array('jquery'), null, true);
            
            wp_enqueue_script('tradeace-single-product', TRADEACE_THEME_URI . '/assets/js/min/single-product.min.js', array('jquery'), $themeVersion, true);
        }
    }
    
    /**
     * Add css comment reply
     */
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    
    /**
     * Dokan
     */
    if (TRADEACE_DOKAN_ACTIVED) {
        if (!TRADEACE_CORE_USER_LOGGED) {
            dokan()->scripts->load_form_validate_script();
            wp_enqueue_script('dokan-form-validate');
        }
        
        wp_enqueue_script('tradeace-dokan-store', TRADEACE_THEME_URI . '/assets/js/min/dokan-store.min.js', array('jquery'), $themeVersion, true);
    }
    
    /**
     * ! TRADEACE_CORE_ACTIVED
     */
    if (!TRADEACE_CORE_ACTIVED) {
        wp_enqueue_script('tradeace-tradeace-core', TRADEACE_THEME_URI . '/assets/js/min/tradeace-core.min.js', array('jquery'), $themeVersion, true);
    }
}

/**
 * Dequeue scripts and styles
 */
add_action('wp_enqueue_scripts', 'tradeace_dequeue_scripts', 9999);
function tradeace_dequeue_scripts() {
    global $tradeace_opt;
    
    /**
     * Ignore css
     */
    if (TRADEACE_WOO_ACTIVED && !TRADEACE_CORE_IN_ADMIN) {
        wp_deregister_style('woocommerce-layout');
        wp_deregister_style('woocommerce-smallscreen');
        wp_deregister_style('woocommerce-general');
    }
    
    /**
     * Dequeue vc_woocommerce-add-to-cart
     */
    if (class_exists('Vc_Manager')) {
        wp_deregister_script('vc_woocommerce-add-to-cart-js');
        wp_dequeue_script('vc_woocommerce-add-to-cart-js');
    }
    
    /**
     * Dequeue contact-form-7 css
     */
    if (function_exists('wpcf7_style_is') && wpcf7_style_is()) {
        wp_dequeue_style('contact-form-7');
    }
    
    /**
     * Dequeue YITH WooCommerce Product Compare colorbox css
     */
    if (class_exists('YITH_Woocompare_Frontend') && (!isset($tradeace_opt['tradeace-product-compare']) || $tradeace_opt['tradeace-product-compare'])) {
        wp_dequeue_style('jquery-colorbox');
        wp_dequeue_script('jquery-colorbox');
    }
    
    /**
     * Dequeue YITH WooCommerce Product Wishlist css
     */
    if (TRADEACE_WISHLIST_ENABLE && !defined('YITH_WCWL_PREMIUM')) {
        wp_deregister_style('jquery-selectBox');
        wp_deregister_style('yith-wcwl-font-awesome');
        wp_deregister_style('yith-wcwl-font-awesome-ie7');
        wp_deregister_style('yith-wcwl-main');
    }
    
    /**
     * Dequeue YITH WooCommerce Product Bundles css
     */
    if (defined('YITH_WCPB')) {
        wp_deregister_style('yith_wcpb_bundle_frontend_style');
    }
    
    /**
     * Dequeue Css files from TradeaceTheme Options
     */
    if (!TRADEACE_CORE_IN_ADMIN && !empty($tradeace_opt['css_files'])) {
        foreach ($tradeace_opt['css_files'] as $handle => $val) {
            if ($val == 1) {
                continue;
            }
            
            /**
             * Continue if Css Preview Elementor
             */
            if (
                isset($_REQUEST['elementor-preview']) &&
                $_REQUEST['elementor-preview'] &&
                in_array($handle, array('elementor-icons', 'elementor-animations'))
            ) {
                continue;
            }
            
            /**
             * Continue if Css Preview WPBakery
             */
            if (
                isset($_REQUEST['vc_editable']) &&
                $_REQUEST['vc_editable'] == 'true' &&
                in_array($handle, array('js_composer_front', 'vc_animate-css'))
            ) {
                continue;
            }
            
            /**
             * Deregister and Dequeue CSS file
             */
            wp_deregister_style($handle);
            wp_dequeue_style($handle);
        }
    }
}

/**
 * List CSS files Call
 * @return type
 */
function tradeace_get_list_css_files_call() {
    $list_css = array(
        'tradeace-animate' => esc_html__("Theme Animation", 'tradeace-theme'),
        'wp-block-library' => esc_html__("WordPress Block Style", 'tradeace-theme')
    );

    /**
     * WooCommerce
     */
    if (TRADEACE_WOO_ACTIVED) {
        $list_css['wc-block-style'] = esc_html__("WooCommerce Block Style", 'tradeace-theme');
    }

    /**
     * Elementor active
     */
    if (TRADEACE_ELEMENTOR_ACTIVE) {
        $list_css['elementor-icons'] = esc_html__("Elementor Icons", 'tradeace-theme');
        $list_css['elementor-animations'] = esc_html__("Elementor Animate", 'tradeace-theme');
    }

    /**
     * WPBakery active
     */
    if (class_exists('Vc_Manager')) {
        $list_css['js_composer_front'] = esc_html__("WPBakery Front-End", 'tradeace-theme');
        $list_css['vc_animate-css'] = esc_html__("WPBakery Animate", 'tradeace-theme');
    }

    /**
     * Back in Stock Notifier
     */
    if (class_exists('CWG_Instock_Notifier')) {
        $list_css['cwginstock_frontend_css'] = esc_html__("Back In Stock Notifier Front-End", 'tradeace-theme');
        $list_css['cwginstock_bootstrap'] = esc_html__("Back In Stock Notifier Bootstrap", 'tradeace-theme');
    }
    
    return apply_filters('tradeace_list_files_css_called', $list_css);
}

/**
 * Default Widgets Area
 */
add_action('widgets_init', 'tradeace_widgets_sidebars_init');
function tradeace_widgets_sidebars_init() {
    // Sidebar - Blog
    register_sidebar(array(
        'name' => esc_html__('Blog Sidebar', 'tradeace-theme'),
        'id' => 'blog-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
        'after_widget'  => '</div>'
    ));
    
    // Sidebar - Shop
    register_sidebar(array(
        'name' => esc_html__('Shop Sidebar', 'tradeace-theme'),
        'id' => 'shop-sidebar',
        'before_widget' => '<div id="%1$s" class="widget tradeace-widget-store %2$s">',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
        'after_widget'  => '</div>'
    ));
    
    // Sidebar Single Product
    register_sidebar(array(
        'name' => esc_html__('Product Sidebar', 'tradeace-theme'),
        'id' => 'product-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
        'after_widget'  => '</div>'
    ));
    
    // Footer Light 1
    register_sidebar(array(
        'name' => esc_html__('Footer Light 1 ( No.1 )', 'tradeace-theme'),
        'id' => 'footer-light-1-1',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 1 ( No.2 )', 'tradeace-theme'),
        'id' => 'footer-light-1-2',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 1 ( No.3 )', 'tradeace-theme'),
        'id' => 'footer-light-1-3',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 1 ( No.4 )', 'tradeace-theme'),
        'id' => 'footer-light-1-4',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 1 ( No.5 )', 'tradeace-theme'),
        'id' => 'footer-light-1-5',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 1 ( No.6 )', 'tradeace-theme'),
        'id' => 'footer-light-1-6',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    // Footer Light 2
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.1 )', 'tradeace-theme'),
        'id' => 'footer-light-2-1',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.2 )', 'tradeace-theme'),
        'id' => 'footer-light-2-2',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.3 )', 'tradeace-theme'),
        'id' => 'footer-light-2-3',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.4 )', 'tradeace-theme'),
        'id' => 'footer-light-2-4',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.5 )', 'tradeace-theme'),
        'id' => 'footer-light-2-5',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.6 )', 'tradeace-theme'),
        'id' => 'footer-light-2-6',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.7 )', 'tradeace-theme'),
        'id' => 'footer-light-2-7',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    // Footer Light 3
    register_sidebar(array(
        'name' => esc_html__('Footer Light 3 ( No.1 )', 'tradeace-theme'),
        'id' => 'footer-light-3-1',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 3 ( No.2 )', 'tradeace-theme'),
        'id' => 'footer-light-3-2',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    // Footer Dark
    register_sidebar(array(
        'name' => esc_html__('Footer Dark ( No.1 )', 'tradeace-theme'),
        'id' => 'footer-dark-1-1',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Dark ( No.2 )', 'tradeace-theme'),
        'id' => 'footer-dark-1-2',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    // Footer Mobile
    register_sidebar(array(
        'name' => esc_html__('Footer Mobile', 'tradeace-theme'),
        'id' => 'footer-mobile',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
}
