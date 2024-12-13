<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Add Block header
 */
if (!function_exists('tradeace_block_header')):
    function tradeace_block_header() {
        global $tradeace_opt, $wp_query;
        
        $object = $wp_query->get_queried_object();
        $pageOption = isset($object->post_type) && $object->post_type == 'page' ? true : false;
        $objectId = $pageOption ? $object->ID : 0;

        $custom_header = $objectId ? get_post_meta($objectId, '_tradeace_custom_header', true) : '';
        
        if (!isset($tradeace_opt['header-block'])) {
            $tradeace_opt['header-block'] = 'default';
        }
        
        $header_block = ($custom_header !== '' && $objectId) ? get_post_meta($objectId, '_tradeace_header_block', true) : $tradeace_opt['header-block'];

        if ($header_block == '-1' || $header_block == 'default') {
            return;
        }
        
        $header_block = $header_block == '' ? ($tradeace_opt['header-block'] != 'default' ? $tradeace_opt['header-block'] : false) : $header_block;
        $header_block = $header_block ? $header_block : false;
        
        echo $header_block ? tradeace_get_block($header_block) : '';
    }
endif;

/**
 * Add action header
 */
add_action('init', 'tradeace_add_action_header');
if (!function_exists('tradeace_add_action_header')):
    function tradeace_add_action_header() {
        /* Header Promotion */
        add_action('tradeace_before_header_structure', 'tradeace_promotion_recent_post', 1);
        
        /* Header Default */
        add_action('tradeace_header_structure', 'tradeace_get_header_structure', 10);
        add_action('tradeace_header_structure', 'tradeace_block_header', 100);
        
        /* Breadcrumb site */
        add_action('tradeace_after_header_structure', 'tradeace_get_breadcrumb', 999);
        
        /* Add Breadcrumb for Header Elementor-Pro */
        if (function_exists('elementor_pro_load_plugin')) {
            add_action('elementor/theme/after_do_header', 'tradeace_open_elm_breadcrumb', 80);
            add_action('elementor/theme/after_do_header', 'tradeace_get_breadcrumb', 90);
            add_action('elementor/theme/after_do_header', 'tradeace_close_elm_breadcrumb', 100);
        }
        
        /* Topbar */
        add_action('tradeace_topbar_header', 'tradeace_header_topbar');
        
        /* Topbar Mobile */
        add_action('tradeace_topbar_header_mobile', 'tradeace_header_topbar_mobile');
        
        /**
         * Deprecated from 4.2.6
         * Header - Responsive
         */
        if (function_exists('tradeace_mobile_header')) {
            add_action('tradeace_mobile_header', 'tradeace_mobile_header');
        }
    }
endif;

/**
 * Add custom meta to head tag
 */
if (!is_home()) :
    add_action('wp_head', 'tradeace_share_meta_head');
    if (!function_exists('tradeace_share_meta_head')):
        function tradeace_share_meta_head() {
            global $post;
            ?>
            <meta property="og:title" content="<?php the_title(); ?>" />
            <?php if (isset($post->ID) && has_post_thumbnail($post->ID)) :
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                <meta property="og:image" content="<?php echo esc_url($image[0]); ?>" />
            <?php endif; ?>
            <meta property="og:url" content="<?php the_permalink(); ?>" />
            <?php
        }
    endif;
endif;

/**
 * Get header structure
 */
if (!function_exists('tradeace_get_header_structure')):
    function tradeace_get_header_structure() {
        global $tradeace_opt, $post;
        
        $has_vertical = array(4);
        $has_search_icon = array(3, 4, 5);
        $full_rule_headers = array('2', '3');

        $hstructure = isset($tradeace_opt['header-type']) ? $tradeace_opt['header-type'] : '1';
        $page_id = false;
        $header_override = false;
        $header_slug = isset($tradeace_opt['header-custom']) && $tradeace_opt['header-custom'] != 'default' ? $tradeace_opt['header-custom'] : false;
        $header_slug_ovrride = false;
        $fixed_nav_header = '';
        
        $is_shop = $pageShop = $is_product_taxonomy = $is_product = false;
        if (TRADEACE_WOO_ACTIVED) {
            $is_shop = is_shop();
            $is_product = is_product();
            $is_product_taxonomy = is_product_taxonomy();
            $pageShop = wc_get_page_id('shop');
        }
        
        /**
         * Override Header
         */
        $root_term_id = tradeace_get_root_term_id();
        if (!$root_term_id) {
            /**
             * Store Page
             */
            if (($is_shop || $is_product_taxonomy) && $pageShop > 0) {
                $page_id = $pageShop;
            }

            /**
             * Page
             */
            if (!$page_id && isset($post->post_type) && $post->post_type == 'page') {
                $page_id = $post->ID;
            }
            
            /**
             * Blog
             */
            if (!$page_id && tradeace_check_blog_page()) {
                $page_id = get_option('page_for_posts');
            }

            /**
             * Swith header structure
             */
            if ($page_id) {
                $custom_header = get_post_meta($page_id, '_tradeace_custom_header', true);
                if (!empty($custom_header)) {
                    $hstructure = $custom_header;
                    $header_slug_ovrride = get_post_meta($page_id, '_tradeace_header_builder', true);
                }

                $fixed_nav_header = get_post_meta($page_id, '_tradeace_fixed_nav', true);
                $fixed_nav_header = $fixed_nav_header == '-1' ? false : $fixed_nav_header;
            }
        }
        
        else {
            /**
             * For Root category (parent = 0)
             */
            $header_override = get_term_meta($root_term_id, 'cat_header_type', true);
            
            if ($header_override == 'tradeace-custom') {
                $hstructure = $header_override;
                $header_slug_ovrride = get_term_meta($root_term_id, 'cat_header_builder', true);
            } else {
                $hstructure = $header_override ? $header_override : $hstructure;
            }
        }
        
        /**
         * Apply to override header structure
         */
        $hstructure = apply_filters('tradeace_header_structure_type', $hstructure);
        
        if ($fixed_nav_header === '') {
            $fixed_nav_header = (!isset($tradeace_opt['fixed_nav']) || $tradeace_opt['fixed_nav']);
        }
        
        /**
         * Apply to fixed header
         */
        $fixed_nav = apply_filters('tradeace_header_sticky', $fixed_nav_header);
        
        /**
         * Header builder
         */
        if ($hstructure == 'tradeace-custom') {
            remove_action('tradeace_header_structure', 'tradeace_block_header', 100);
            
            $header_slug = $header_slug_ovrride ? $header_slug_ovrride : $header_slug;
            if ($header_slug) {
                tradeace_header_builder($header_slug);
            }
            
            return;
        }
        
        $header_classes = array();
        
        /**
         * Transparent header
         */
        $header_transparent = $page_id ? get_post_meta($page_id, '_tradeace_header_transparent', true) : '';
        $header_transparent = $header_transparent == '-1' ? '0' : $header_transparent;
        $header_transparent = $header_transparent == '' ? ((!isset($tradeace_opt['header_transparent']) || !$tradeace_opt['header_transparent']) ? false : true) : (bool) $header_transparent;
        if ($header_transparent) {
            $header_classes[] = 'tradeace-header-transparent';
        }
        
        /**
         * Mobile Detect
         */
        if (isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile']) {
            $header_classes[] = 'tradeace-header-mobile-layout';
            if ($fixed_nav) {
                $header_classes[] = 'tradeace-header-sticky';
            }
            
            $vertical = in_array($hstructure, $has_vertical) ? true : false;
            $header_classes = !empty($header_classes) ? implode(' ', $header_classes) : '';
            $header_classes = apply_filters('tradeace_header_classes', $header_classes);
            
            $file = TRADEACE_CHILD_PATH . '/headers/header-mobile.php';
            include is_file($file) ? $file : TRADEACE_THEME_PATH . '/headers/header-mobile.php';
            
            return;
        }
        
        /**
         * Init vars
         */
        $menu_warp_class = array();
        $header_classes[] = 'header-wrapper header-type-' . $hstructure;
        
        /**
         * Extra class name
         */
        $el_class_header = $page_id ? get_post_meta($page_id, '_tradeace_el_class_header', true) : '';
        if ($el_class_header != '') {
            $header_classes[] = $el_class_header;
        }
        
        /**
         * Main menu style
         */
        $menu_warp_class[] = 'tradeace-nav-style-1';
        $data_padding_y = apply_filters('tradeace_responsive_y_menu', 15);
        $data_padding_x = apply_filters('tradeace_responsive_x_menu', 35);
        
        $menu_warp_class = !empty($menu_warp_class) ? ' ' . implode(' ', $menu_warp_class) : '';
        
        /**
         * Full width main menu
         */
        $fullwidth_main_menu = true;
        if (in_array($hstructure, $full_rule_headers)) {
            $fullwidth_main_menu = $page_id ? get_post_meta($page_id, '_tradeace_fullwidth_main_menu', true) : true;
            $fullwidth_main_menu = $fullwidth_main_menu === '-1' ? '0' : $fullwidth_main_menu;
            
            if ($fullwidth_main_menu == '' && isset($tradeace_opt['header-type']) && in_array($tradeace_opt['header-type'], $full_rule_headers)) {
                $fullwidth_main_menu = (isset($tradeace_opt['fullwidth_main_menu']) && !$tradeace_opt['fullwidth_main_menu']) ? false : true;
            }
            
            else {
                $fullwidth_main_menu = $fullwidth_main_menu ? true : false;
            }
        }
        
        /**
         * Top filter cats
         */
        $show_icon_cat_top = isset($tradeace_opt['show_icon_cat_top']) ? $tradeace_opt['show_icon_cat_top'] : 'show-in-shop';
        switch ($show_icon_cat_top) :
            case 'show-all-site':
                $show_cat_top_filter = true;
                break;

            case 'not-show':
                $show_cat_top_filter = false;
                break;

            case 'show-in-shop':
            default:
                $show_cat_top_filter = ($is_shop || $is_product_taxonomy || $is_product) ? true : false;
                break;
        endswitch;
        
        $show_product_cat = true;
        $show_cart = true;
        $show_compare = true;
        $show_wishlist = true;
        $icon_search = in_array($hstructure, $has_search_icon) ? false : true;
        $show_search = apply_filters('tradeace_search_icon_header', $icon_search);
        $tradeace_header_icons = tradeace_header_icons($show_product_cat, $show_cart, $show_compare, $show_wishlist, $show_search);
        
        /**
         * Sticky header
         */
        if ($fixed_nav) {
            $header_classes[] = 'tradeace-header-sticky';
        }
        
        /**
         * $header_classes to string
         */
        $header_classes = !empty($header_classes) ? implode(' ', $header_classes) : '';
        $header_classes = apply_filters('tradeace_header_classes', $header_classes);
        
        /**
         * Main header include
         */
        $file = TRADEACE_CHILD_PATH . '/headers/header-structure-' . ((int) $hstructure) . '.php';
        if (is_file($file)) {
            include $file;
        } else {
            $file = TRADEACE_THEME_PATH . '/headers/header-structure-' . ((int) $hstructure) . '.php';
            include is_file($file) ? $file : TRADEACE_THEME_PATH . '/headers/header-structure-1.php';
        }
    }
endif;

/**
 * Group header icons
 */
if (!function_exists('tradeace_header_icons')) :
    function tradeace_header_icons($product_cat = true, $cart = true, $compare = true, $wishlist = true, $search = true) {
        global $tradeace_opt;
        
        $icons = '';
        $first = false;
        
        /**
         * Account menu item mobile version
         */
        if (
            TRADEACE_WOO_ACTIVED &&
            isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile'] &&
            (!isset($tradeace_opt['hide_tini_menu_acc']) || !$tradeace_opt['hide_tini_menu_acc']) &&
            (!isset($tradeace_opt['main_screen_acc_mobile']) || $tradeace_opt['main_screen_acc_mobile'])
        ) {
            $title_acc = !TRADEACE_CORE_USER_LOGGED ? esc_attr__('Login / Register', 'tradeace-theme') : esc_attr__('My Account', 'tradeace-theme');

            $login_ajax = !TRADEACE_CORE_USER_LOGGED && (!isset($tradeace_opt['login_ajax']) || $tradeace_opt['login_ajax'] == 1) ? '1' : '0';

            $login_url = '#';
            $myaccount_page_id = get_option('woocommerce_myaccount_page_id');
            if ($myaccount_page_id) {
                $login_url = get_permalink($myaccount_page_id);
            }
            
            $icon = apply_filters('tradeace_mini_icon_account', '<i class="tradeace-icon pe7-icon pe-7s-user"></i>');

            $tradeace_icon_account = 
            '<a class="tradeace-login-register-ajax inline-block" data-enable="' . $login_ajax . '" href="' . esc_url($login_url) . '" title="' . $title_acc . '">' .
                $icon .
            '</a>';

            $class = !$first ? 'first ' : '';
            $first = true;
            $icons .= '<li class="' . $class . 'tradeace-icon-account-mobile">' . $tradeace_icon_account . '</li>';
        }
        
        /**
         * List Product Categories icons
         */
        if (TRADEACE_WOO_ACTIVED && $product_cat) {
            $show_icon_cat_top = isset($tradeace_opt['show_icon_cat_top']) ? $tradeace_opt['show_icon_cat_top'] : 'show-in-shop';
            
            switch ($show_icon_cat_top) {
                case 'show-all-site':
                    $show_icon = true;
                    break;
                
                case 'not-show':
                    $show_icon = false;
                    break;
                
                case 'show-in-shop':
                default:
                    $show_icon = (!is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) ? false : true;
                    break;
            }
            
            if ($show_icon) {
                $icon = apply_filters('tradeace_mini_icon_filter_cats', '<i class="tradeace-icon pe-7s-keypad"></i>');
                
                $tradeace_icon_cat = 
                    '<a class="filter-cat-icon inline-block tradeace-hide-for-mobile" href="javascript:void(0);" title="' . esc_attr__('Product Categories', 'tradeace-theme') . '" rel="nofollow">' .
                        $icon .
                    '</a>' .
                    '<a class="filter-cat-icon-mobile inline-block" href="javascript:void(0);" title="' . esc_attr__('Product Categories', 'tradeace-theme') . '" rel="nofollow">' .
                        $icon .
                    '</a>';
                $class = !$first ? 'first ' : '';
                $first = true;
                $icons .= '<li class="' . $class . 'tradeace-icon-filter-cat">' . $tradeace_icon_cat . '</li>';
            }
        }
        
        if ($cart) {
            $show = defined('TRADEACE_PLG_CACHE_ACTIVE') && TRADEACE_PLG_CACHE_ACTIVE ? false : true;
            $tradeace_mini_cart = tradeace_mini_cart($show);
            if ($tradeace_mini_cart != '') {
                $class = !$first ? 'first ' : '';
                $first = true;
                $icons .= '<li class="' . $class . 'tradeace-icon-mini-cart">' . $tradeace_mini_cart . '</li>';
            }
        }
        
        if ($wishlist) {
            $tradeace_icon_wishlist = tradeace_icon_wishlist();
            if ($tradeace_icon_wishlist != '') {
                $class = !$first ? 'first ' : '';
                $first = true;
                $icons .= '<li class="' . $class . 'tradeace-icon-wishlist">' . $tradeace_icon_wishlist . '</li>';
            }
        }
        
        if ($compare && (!isset($tradeace_opt['tradeace-product-compare']) || $tradeace_opt['tradeace-product-compare'])) {
            $tradeace_icon_compare = tradeace_icon_compare();
            if ($tradeace_icon_compare != '') {
                $class = !$first ? 'first ' : '';
                $first = true;
                $icons .= '<li class="' . $class . 'tradeace-icon-compare">' . $tradeace_icon_compare . '</li>';
            }
        }
        
        if ($search) {
            $icon = apply_filters('tradeace_mini_icon_search', '<i class="tradeace-icon tradeace-search icon-tradeace-search"></i>');
            
            $search_icon = 
            '<a class="search-icon desk-search inline-block" href="javascript:void(0);" data-open="0" title="' . esc_attr__('Search', 'tradeace-theme') . '" rel="nofollow">' .
                $icon .
            '</a>';
            $class = !$first ? 'first ' : '';
            $first = true;
            $icons .= '<li class="' . $class . 'tradeace-icon-search tradeace-hide-for-mobile">' . $search_icon . '</li>';
        }
        
        $icons_wrap = ($icons != '') ? '<div class="tradeace-header-icons-wrap"><ul class="header-icons">' . $icons . '</ul></div>' : '';
        
        return apply_filters('tradeace_header_icons', $icons_wrap);
    }
endif;

/**
 * Get header builder custom
 */
if (!function_exists('tradeace_header_builder')) :
    function tradeace_header_builder($header_slug) {
        if (!function_exists('tradeace_get_header')) {
            return;
        }

        $header_builder = tradeace_get_header($header_slug);
        
        $file = TRADEACE_CHILD_PATH . '/headers/header-builder.php';
        include is_file($file) ? $file : TRADEACE_THEME_PATH . '/headers/header-builder.php';
    }
endif;

/**
 * Topbar
 */
if (!function_exists('tradeace_header_topbar')) :
    function tradeace_header_topbar($mobile = false) {
        global $wp_query, $tradeace_opt;
        
        $queryObjId = $wp_query->get_queried_object_id();
        
        /**
         * Top bar Toggle
         */
        $topbar_toggle = get_post_meta($queryObjId, '_tradeace_topbar_toggle', true);
        $topbar_df_show = $topbar_toggle == 1 ? get_post_meta($queryObjId, '_tradeace_topbar_default_show', true) : '';

        $topbar_toggle_val = $topbar_toggle == '' ? (isset($tradeace_opt['topbar_toggle']) && $tradeace_opt['topbar_toggle'] ? true : false) : ($topbar_toggle == 1 ? true : false);
        $topbar_df_show_val = $topbar_df_show == '' ? (!isset($tradeace_opt['topbar_default_show']) || $tradeace_opt['topbar_default_show'] ? true : false) : ($topbar_df_show == 1 ? true : false);

        $class_topbar = $topbar_toggle_val ? ' tradeace-topbar-toggle' : '';
        $class_topbar .= $topbar_df_show_val ? '' : ' tradeace-topbar-hide';
        
        /**
         * Top bar content
         */
        $topbar_left = '';
        if (isset($tradeace_opt['topbar_content']) && $tradeace_opt['topbar_content']) {
            $topbar_left = tradeace_get_block($tradeace_opt['topbar_content']);
        }
        
        /**
         * Old data
         */
        elseif (isset($tradeace_opt['topbar_left']) && $tradeace_opt['topbar_left'] != '') {
            $topbar_left = do_shortcode($tradeace_opt['topbar_left']);
        }
        
        $file = TRADEACE_CHILD_PATH . '/headers/top-bar.php';
        include is_file($file) ? $file : TRADEACE_THEME_PATH . '/headers/top-bar.php';
    }
endif;

/**
 * Topbar mobile
 */
if (!function_exists('tradeace_header_topbar_mobile')) :
    function tradeace_header_topbar_mobile() {
        tradeace_header_topbar(true);
    }
endif;

/**
 * Topbar menu
 */
add_action('tradeace_topbar_menu', 'tradeace_topbar_menu', 15);
add_action('tradeace_mobile_topbar_menu', 'tradeace_topbar_menu', 15);
if (!function_exists('tradeace_topbar_menu')) :
    function tradeace_topbar_menu() {
        tradeace_get_menu('topbar-menu', 'tradeace-topbar-menu', 1);
    }
endif;

/**
 * Topbar Account
 */
add_action('tradeace_topbar_menu', 'tradeace_topbar_account', 20);
if (!function_exists('tradeace_topbar_account')) :
    function tradeace_topbar_account() {
        echo tradeace_tiny_account(true);
    }
endif;

/**
 * Mobile account menu
 */
if (!function_exists('tradeace_mobile_account')) :
    function tradeace_mobile_account() {
        $file = TRADEACE_CHILD_PATH . '/includes/tradeace-mobile-account.php';
        include is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-mobile-account.php';
    }
endif;

/**
 * Short code group icons header
 */
add_shortcode('tradeace_sc_icons', 'tradeace_header_icons_sc');
if (!function_exists('tradeace_header_icons_sc')) :
    function tradeace_header_icons_sc($atts = array(), $content = null) {
        $dfAttr = array(
            'show_mini_cart' => 'yes',
            'show_mini_compare' => 'yes',
            'show_mini_wishlist' => 'yes',
            'el_class' => ''
        );
        extract(shortcode_atts($dfAttr, $atts));

        $cart = $show_mini_cart == 'yes' ? true : false;
        $compare = $show_mini_compare == 'yes' ? true : false;
        $wishlist = $show_mini_wishlist == 'yes' ? true : false;
        
        $class = 'tradeace-header-icons-wrap';
        $class .= $el_class != '' ? ' ' . $el_class : '';
        
        $content = '<div class="' . esc_attr($class) . '">' .
            tradeace_header_icons(false, $cart, $compare, $wishlist, false) .
        '</div>';
        
        return $content;
    }
endif;

/**
 * Short code header search
 */
add_shortcode('tradeace_sc_search_form', 'tradeace_header_search_sc');
if (!function_exists('tradeace_header_search_sc')) :
    function tradeace_header_search_sc($atts = array(), $content = null) {
        $dfAttr = array(
            'el_class' => ''
        );
        extract(shortcode_atts($dfAttr, $atts));
        
        $class = 'tradeace-header-search-wrap';
        $class .= $el_class != '' ? ' ' . $el_class : '';
        
        $content = '<div class="' . esc_attr($class) . '">' .
            tradeace_search('full') .
        '</div>';
        
        return $content;
    }
endif;

/**
 * Get breadcrumb
 */
if (!function_exists('tradeace_get_breadcrumb')) :
    function tradeace_get_breadcrumb() {
        if (!TRADEACE_WOO_ACTIVED) {
            return;
        }

        global $wp_query, $post, $tradeace_opt, $tradeace_root_term_id;
        
        $enable = isset($tradeace_opt['breadcrumb_show']) && !$tradeace_opt['breadcrumb_show'] ? false : true;
        $is_product = is_product();
        $is_product_cat = is_product_category();
        $is_product_taxonomy = is_product_taxonomy();
        $is_shop = is_shop();
        
        $mobile = isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile'] ? true : false;
        
        $override = false;

        // Theme option
        $has_bg = isset($tradeace_opt['breadcrumb_type']) && $tradeace_opt['breadcrumb_type'] == 'has-background' ?
            true : false;

        $bg = isset($tradeace_opt['breadcrumb_bg']) && trim($tradeace_opt['breadcrumb_bg']) != '' ?
            $tradeace_opt['breadcrumb_bg'] : false;

        $bg_cl = isset($tradeace_opt['breadcrumb_bg_color']) && $tradeace_opt['breadcrumb_bg_color'] ?
            $tradeace_opt['breadcrumb_bg_color'] : false;

        $bg_lax = isset($tradeace_opt['breadcrumb_bg_lax']) && $tradeace_opt['breadcrumb_bg_lax'] ?
            true : false;

        $h_bg = isset($tradeace_opt['breadcrumb_height']) && (int) $tradeace_opt['breadcrumb_height'] ?
            (int) $tradeace_opt['breadcrumb_height'] : false;

        $txt_color = isset($tradeace_opt['breadcrumb_color']) && $tradeace_opt['breadcrumb_color'] ?
            $tradeace_opt['breadcrumb_color'] : false;

        /*
         * Override breadcrumb BG
         */
        if ($is_shop || $is_product_cat || $is_product_taxonomy || $is_product) {
            $pageShop = wc_get_page_id('shop');

            if ($pageShop > 0) {
                $show_breadcrumb = get_post_meta($pageShop, '_tradeace_show_breadcrumb', true);
                $enable = ($show_breadcrumb != 'on') ? false : true;
                if (!$enable) {
                    return;
                }
            }

            $term_id = false;

            /**
             * Check Single product
             */
            if ($is_product) {
                if (!$tradeace_root_term_id) {
                    $product_cats = get_the_terms($wp_query->get_queried_object_id(), 'product_cat');
                    if ($product_cats) {
                        foreach ($product_cats as $cat) {
                            $term_id = $cat->term_id;
                            break;
                        }
                    }
                } else {
                    $term_id = $tradeace_root_term_id;
                }
            }

            /**
             * Check Archive product
             */
            elseif ($is_product_cat) {
                $query_obj = get_queried_object();
                $term_id = isset($query_obj->term_id) ? $query_obj->term_id : false;
            }

            if ($term_id) {
                $bg_cat_enable = get_term_meta($term_id, 'cat_breadcrumb', true);

                if (!$bg_cat_enable) {
                    if ($tradeace_root_term_id) {
                        $term_id = $tradeace_root_term_id;
                    } else {
                        $ancestors = get_ancestors($term_id, 'product_cat');
                        $term_id = $ancestors ? end($ancestors) : 0;
                        $GLOBALS['tradeace_root_term_id'] = $term_id;
                    }

                    if ($term_id) {
                        $bg_cat_enable = get_term_meta($term_id, 'cat_breadcrumb', true);
                    }
                }

                if ($bg_cat_enable && !$mobile) {
                    $bgImgId = get_term_meta($term_id, 'cat_breadcrumb_bg', true);
                    if ($bgImgId) {
                        $bg = wp_get_attachment_image_url($bgImgId, 'full');
                        $has_bg = true;
                    }

                    $text_color_cat = get_term_meta($term_id, 'cat_breadcrumb_text_color', true);
                    $txt_color = $text_color_cat != '' ? $text_color_cat : $txt_color;
                }
            }

            /**
             * Breadcrumb shop page
             */
            elseif ($is_shop && $pageShop > 0) {
                $queryObj = $pageShop;
                $override = true;
            }
        }

        else {
            $pageBlog = get_option('page_for_posts');
            /**
             * Check page
             */
            if (isset($post->ID) && $post->post_type == 'page') {
                $queryObj = $post->ID;
                $show_breadcrumb = get_post_meta($queryObj, '_tradeace_show_breadcrumb', true);
                $enable = ($show_breadcrumb != 'on') ? false : true;
                $override = true;
            }

            /**
             * Check Blog | archive post | single post
             */
            elseif ($pageBlog && isset($post->post_type) && $post->post_type == 'post' && (is_category() || is_tag() || is_date() || is_home() || is_single())) {
                $show_breadcrumb = get_post_meta($pageBlog, '_tradeace_show_breadcrumb', true);
                $enable = ($show_breadcrumb != 'on') ? false : true;
                $queryObj = $pageBlog;
                $override = true;
            }

            if (!$enable) {
                return;
            }
        }
        
        /**
         * Mobile Detect
         */
        if ($mobile) {
            $has_bg = false;
            $parallax = false;
            $style_custom = $style_height = false;
            
            if (!$enable) {
                return;
            }
        }
        
        /**
         * For Desktop
         */
        else {
            // Override
            if ($override) {
                $type_bg = get_post_meta($queryObj, '_tradeace_type_breadcrumb', true);
                $bg_override = get_post_meta($queryObj, '_tradeace_bg_breadcrumb', true);
                $bg_cl_override = get_post_meta($queryObj, '_tradeace_bg_color_breadcrumb', true);
                $h_override = get_post_meta($queryObj, '_tradeace_height_breadcrumb', true);
                $color_override = get_post_meta($queryObj, '_tradeace_color_breadcrumb', true);

                if ($type_bg == '1') {
                    $bg = $bg_override ? $bg_override : $bg;
                }

                $bg_cl = $bg_cl_override ? $bg_cl_override : $bg_cl;
                $txt_color = $color_override ? $color_override : $txt_color;
                $h_bg = (int) $h_override ? (int) $h_override : $h_bg;
            }

            // set style by option breadcrumb
            $style_custom = '';
            if ($has_bg && $bg) {
                $style_custom .= 'background:url(' . esc_url($bg) . ')';
                $style_custom .= $bg_lax ? ' center center repeat-y;' : ';background-size:cover;';
            }
            
            $style_custom .= $bg_cl ? 'background-color:' . $bg_cl . ';' : '';
            $style_custom .= $txt_color ? 'color:' . $txt_color . ';' : '';
            $style_height = $h_bg ? 'height:' . $h_bg . 'px;' : 'height:auto;';
        }
        
        $parallax = ($has_bg && $bg && $bg_lax) ? true : false;
        $bread_align = !isset($tradeace_opt['breadcrumb_align']) ? 'text-center' : $tradeace_opt['breadcrumb_align'];
        
        $class_all = array('bread tradeace-breadcrumb');
        $attr_all = array('id="tradeace-breadcrumb-site"');
        if ($has_bg) {
            $class_all[] = 'tradeace-breadcrumb-has-bg';
        }
        
        if ($parallax) {
            $class_all[] = 'tradeace-parallax tradeace-parallax-stellar';
            $attr_all[] = 'data-stellar-background-ratio="0.6"';
            
            // jquery-migrate
            wp_enqueue_script('jquery-migrate', TRADEACE_THEME_URI . '/assets/js/min/jquery-migrate.min.js', array('jquery'), null);
            
            // Parallax - js
            wp_enqueue_script('jquery-stellar', TRADEACE_THEME_URI . '/assets/js/min/jquery.stellar.min.js', array('jquery'), null, true);
        }
        
        if ($style_custom) {
            $attr_all[] = 'style="' . esc_attr($style_custom) . '"';
        }
        
        $class_all_string = !empty($class_all) ? implode(' ', $class_all) : '';
        if ($class_all_string) {
            $attr_all[] = 'class="' . esc_attr($class_all_string) . '"';
        }
        
        $attr_all_string = !empty($attr_all) ? ' ' . implode(' ', $attr_all) : '';
        
        $defaults = apply_filters('tradeace_breadcrumb_args', array(
            'delimiter' => '<span class="fa fa-angle-right"></span>',
            'wrap_before' => '<span class="breadcrumb">',
            'wrap_after' => '</span>',
            'before' => '',
            'after' => '',
            'home' => esc_html__('Home', 'tradeace-theme'),
        ));
        
        $args = apply_filters('woocommerce_breadcrumb_defaults', $defaults);
        
        $wc_breadcrumbs = new WC_Breadcrumb();

        if (!empty($args['home'])) {
            $wc_breadcrumbs->add_crumb(
                $args['home'],
                apply_filters('woocommerce_breadcrumb_home_url', home_url('/'))
            );
        }
        
        $args['breadcrumb'] = $wc_breadcrumbs->generate();
        do_action('woocommerce_breadcrumb', $wc_breadcrumbs, $args);
        ?>
        <div<?php echo $attr_all_string; ?>>
            <div class="row">
                <div class="large-12 columns tradeace-display-table">
                    <nav class="breadcrumb-row <?php echo esc_attr($bread_align); ?>"<?php echo $style_height ? ' style="' . esc_attr($style_height).'"' : ''; ?>>
                        <?php wc_get_template('global/breadcrumb.php', $args); ?>
                    </nav>
                </div>
            </div>
        </div>

        <?php
    }
endif;

/**
 * Build breadcrumb Portfolio
 */
if (!function_exists('tradeace_rebuilt_breadcrumb_portfolio')) :
    function tradeace_rebuilt_breadcrumb_portfolio($orgBreadcrumb = array(), $single = true) {
        global $tradeace_opt, $post;
        
        $breadcrumb = isset($orgBreadcrumb[0]) ? array($orgBreadcrumb[0]) : array();
        
        $portfolio = null;
        if (isset($tradeace_opt['tradeace-page-view-portfolio']) && (int) $tradeace_opt['tradeace-page-view-portfolio']) {
            $portfolio = get_post((int) $tradeace_opt['tradeace-page-view-portfolio']);
        } else {
            $pages = get_pages(array(
                'meta_key' => '_wp_page_template',
                'meta_value' => 'portfolio.php'
            ));

            if ($pages) {
                foreach ($pages as $page) {
                    $portfolio = get_post((int) $page->ID);
                    break;
                }
            }
        }

        if ($portfolio) {
            $breadcrumb[] = array(
                0 => $portfolio->post_title,
                1 => get_permalink($portfolio)
            );
        }

        $terms = wp_get_post_terms(
            $post->ID,
            'portfolio_category',
            array(
                'orderby' => 'parent',
                'order' => 'DESC'
            )
        );

        if ($terms) {
            $main_term = $terms[0];
            $ancestors = get_ancestors($main_term->term_id, 'portfolio_category');
            $ancestors = array_reverse($ancestors);
            if (count($ancestors)) {
                foreach ($ancestors as $ancestor) {
                    $ancestor = get_term($ancestor, 'portfolio_category');

                    if ($ancestor) {
                        $breadcrumb[] = array(
                            0 => $ancestor->name,
                            1 => get_term_link($ancestor, 'portfolio_category')
                        );
                    }
                }
            }

            if ($single) {
                $breadcrumb[] = array(
                    0 => $main_term->name,
                    1 => get_term_link($main_term, 'portfolio_category')
                );
            }
        }

        return $breadcrumb;
    }
endif;

/**
 * Open wrap Breadcrumb for Elementor Pro - Header Builder
 */
if (!function_exists('tradeace_open_elm_breadcrumb')) :
    function tradeace_open_elm_breadcrumb() {
        echo '<!-- Begin Breadcrumb for Elementor Pro - Header Builder --><div class="tradeace-breadcrumb-wrap">';
    }
endif;

/**
 * Close wrap Breadcrumb for Elementor Pro - Header Builder
 */
if (!function_exists('tradeace_close_elm_breadcrumb')) :
    function tradeace_close_elm_breadcrumb() {
        echo '</div><!-- End Breadcrumb for Elementor Pro - Header Builder -->';
    }
endif;
