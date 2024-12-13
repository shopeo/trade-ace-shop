<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Get product meta value
 */
if (!function_exists('tradeace_get_product_meta_value')):
    function tradeace_get_product_meta_value($post_id = 0, $field_id = null) {
       
        
        return null;
    }
endif;

/**
 * Custom shopping cart page when empty
 */
add_filter('wc_empty_cart_message', 'tradeace_empty_cart_message');
if (!function_exists('tradeace_empty_cart_message')) :
    function tradeace_empty_cart_message ($mess) {
        $mess .= '<span class="tradeace-extra-empty">' . esc_html__('Before proceed to checkout you must add some products to shopping cart.', 'tradeace-theme') . '</span>';
        $mess .= '<span class="tradeace-extra-empty">' . esc_html__('You will find a lot of interesting products on our "Shop" page.', 'tradeace-theme') . '</span>';

        return $mess;
    }
endif;

/**
 * Override hover effect animated product
 */
add_action('wp_head', 'tradeace_effect_animated_products');
if (!function_exists('tradeace_effect_animated_products')) :
    function tradeace_effect_animated_products() {
        if (!TRADEACE_WOO_ACTIVED) {
            return;
        }
        
        $root_term_id = tradeace_get_root_term_id();
        if ($root_term_id) {
            $effect_product = get_term_meta($root_term_id, 'cat_effect_hover', true);
            
            if ($effect_product) {
                if ($effect_product == 'no') {
                    $GLOBALS['tradeace_animated_products'] = '';
                }
                
                else {
                    $GLOBALS['tradeace_animated_products'] = $effect_product;
                }
            }
        }
    }
endif;

/**
 * Tiny account
 */
if (!function_exists('tradeace_tiny_account')) {
    function tradeace_tiny_account($icon = false, $user = false) {
        global $tradeace_opt;
        if (isset($tradeace_opt['hide_tini_menu_acc']) && $tradeace_opt['hide_tini_menu_acc']) {
            return '';
        }
        
        $login_url = '#';
        $register_url = '#';
        $profile_url = '#';
        
        /* Active woocommerce */
        if (TRADEACE_WOO_ACTIVED) {
            $myaccount_page_id = get_option('woocommerce_myaccount_page_id');
            if ($myaccount_page_id) {
                $login_url = get_permalink($myaccount_page_id);
                $register_url = $login_url;
                $profile_url = $login_url;
            }
        } else {
            $login_url = wp_login_url();
            $register_url = wp_registration_url();
            $profile_url = admin_url('profile.php');
        }

        $result = '<ul class="tradeace-menus-account">';
        
        $icon_user = apply_filters('tradeace_mini_icon_account', '<i class="pe7-icon pe-7s-user"></i>');
        
        /**
         * Not Logged in
         */
        if (!TRADEACE_CORE_USER_LOGGED && !$user) {
            global $tradeace_opt;
            $login_ajax = (!isset($tradeace_opt['login_ajax']) || $tradeace_opt['login_ajax'] == 1) ? '1' : '0';
            $span = $icon ? $icon_user : '';
            $result .= '<li class="menu-item"><a class="tradeace-login-register-ajax inline-block" data-enable="' . $login_ajax . '" href="' . esc_url($login_url) . '" title="' . esc_attr__('Login / Register', 'tradeace-theme') . '">' . $span . '<span class="tradeace-login-title">' . esc_html__('Login / Register', 'tradeace-theme') . '</span></a></li>';
        }
        
        /**
         * Logged in
         */
        else {
            $span1 = $icon ? $icon_user : '';
            
            $submenu = '<ul class="sub-menu">';
            $current_user = wp_get_current_user();
            
            // Hello Account
            $submenu .= '<li class="tradeace-subitem-acc tradeace-hello-acc">' . sprintf(esc_html__('Hello, %s!', 'tradeace-theme'), $current_user->display_name) . '</li>';
            
            $menu_items = TRADEACE_WOO_ACTIVED ? wc_get_account_menu_items() : false;
            if ($menu_items) {
                foreach ($menu_items as $endpoint => $label) {
                    $submenu .= '<li class="tradeace-subitem-acc ' . wc_get_account_menu_item_classes($endpoint) . '"><a href="' . esc_url(wc_get_account_endpoint_url($endpoint)) . '">' . esc_html($label) . '</a></li>';
                }
            }
            
            $submenu .= '</ul>';
            
            $result .= 
                '<li class="menu-item tradeace-menu-item-account menu-item-has-children root-item">' .
                    '<a href="' . esc_url($profile_url) . '" title="' . esc_attr__('My Account', 'tradeace-theme') . '">' . $span1 . esc_html__('My Account', 'tradeace-theme') . '</a>' .
                    $submenu .
                '</li>';
        }
        
        $result .= '</ul>';
        
        return apply_filters('tradeace_tiny_account_ajax', $result);
    }
}

/**
 * icon cart
 */
if (!function_exists('tradeace_mini_cart_icon')) :
    function tradeace_mini_cart_icon() {
        global $tradeace_opt;
        
        $icon_number = isset($tradeace_opt['mini-cart-icon']) ? $tradeace_opt['mini-cart-icon'] : '1';
        switch ($icon_number) {
            case '2':
                $icon_class = 'icon-tradeace-cart-2';
                break;
            case '3':
                $icon_class = 'icon-tradeace-cart-4';
                break;
            case '4':
                $icon_class = 'pe-7s-cart';
                break;
            case '5':
                $icon_class = 'fa fa-shopping-cart';
                break;
            case '6':
                $icon_class = 'fa fa-shopping-bag';
                break;
            case '7':
                $icon_class = 'fa fa-shopping-basket';
                break;
            case '1':
            default:
                $icon_class = 'icon-tradeace-cart-3';
                break;
        }

        return apply_filters('tradeace_mini_icon_cart', $icon_class);
    }
endif;

/**
 * Mini cart icon
 */
if (!function_exists('tradeace_mini_cart')) {
    function tradeace_mini_cart($show = true) {
        global $woocommerce, $tradeace_opt, $tradeace_mini_cart;
        
        if (!$woocommerce || (isset($tradeace_opt['disable-cart']) && $tradeace_opt['disable-cart'])) {
            return;
        }
        
        if (!$tradeace_mini_cart) {
            $slClass = $show ? '' : ' hidden-tag';
            
            $slClass .= $woocommerce->cart->cart_contents_count == 0 ? ' tradeace-product-empty' : '';
            $tradeaceSl = $woocommerce->cart->cart_contents_count;
            if (!isset($tradeace_opt['compact_number']) || $tradeace_opt['compact_number']) {
                $tradeaceSl = $tradeaceSl > 9 ? '9+' : $tradeaceSl;
            }
            
            $icon_class = tradeace_mini_cart_icon();
            
            $tradeace_mini_cart = 
            '<a href="javascript:void(0);" class="cart-link mini-cart cart-inner mini-cart-type-full inline-block" title="' . esc_attr__('Cart', 'tradeace-theme') . '" rel="nofollow">' .
                '<i class="tradeace-icon cart-icon ' . $icon_class . '"></i>' .
                '<span class="tradeace-cart-count tradeace-mini-number cart-number' . $slClass . '">' .
                    apply_filters('tradeace_mini_cart_total_items', $tradeaceSl) .
                '</span>' .
            '</a>';
            
            $tradeace_mini_cart = apply_filters('tradeace_mini_cart', $tradeace_mini_cart);
            
            $GLOBALS['tradeace_mini_cart'] = $tradeace_mini_cart;
        }
        
        return $tradeace_mini_cart;
    }
}

/**
 * Add to cart dropdown - Refresh mini cart content.
 */
add_filter('woocommerce_add_to_cart_fragments', 'tradeace_add_to_cart_refresh');
if (!function_exists('tradeace_add_to_cart_refresh')) :
    function tradeace_add_to_cart_refresh($fragments) {
        $fragments['.cart-inner'] = tradeace_mini_cart();
        
        if (isset($_REQUEST['product_id'])) {
            $fragments['.woocommerce-message'] = sprintf(
                '<div class="woocommerce-message text-center" role="alert">%s</div>',
                esc_html__('Product added to cart successfully!', 'tradeace-theme')
            );
        }

        return $fragments;
    }
endif;

/**
 * Mini wishlist sidebar
 */
if (!function_exists('tradeace_mini_wishlist_sidebar')) {
    function tradeace_mini_wishlist_sidebar($return = false) {
        if (!TRADEACE_WOO_ACTIVED){
            return '';
        }
        
        global $tradeace_opt;
        
        if (!TRADEACE_WISHLIST_ENABLE && isset($tradeace_opt['enable_tradeace_wishlist']) && !$tradeace_opt['enable_tradeace_wishlist']) :
            return '';
        endif;
        
        if ($return) :
            ob_start();
        endif;
        
        $file = TRADEACE_CHILD_PATH . '/includes/tradeace-sidebar-wishlist.php';
        include is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-sidebar-wishlist.php';
        
        if ($return) :
            $content = ob_get_clean();
            return $content;
        endif;
    }
}

/**
 * Add to cart button from wishlist
 */
if (!function_exists('tradeace_add_to_cart_in_wishlist')) :
    function tradeace_add_to_cart_in_wishlist() {
        global $product, $tradeace_opt;

        if (isset($tradeace_opt['disable-cart']) && $tradeace_opt['disable-cart']) {
            return '';
        }

        $title = $product->add_to_cart_text();
        $product_type = $product->get_type();
        $productId = $product->get_id();
        $enable_button_ajax = false;
        if ($product->is_in_stock() && $product->is_purchasable()) {
            if ($product_type == 'simple' || ($product_type == TRADEACE_COMBO_TYPE && $product->all_items_in_stock())) {
                $ajaxAdd = get_option('woocommerce_enable_ajax_add_to_cart');
                $enable_button_ajax = 'yes' === $ajaxAdd ? true : false;
                $url = $enable_button_ajax ? 'javascript:void(0);' : esc_url($product->add_to_cart_url());
            }
            
            else {
                
                /**
                 * Bundle product
                 */
                if ($product_type == 'woosb') {
                    $url = '?add-to-cart=' . $productId;
                    if (get_option('yith_wcwl_remove_after_add_to_cart') == 'yes') {
                        $url .= '&remove_from_wishlist_after_add_to_cart=' . $productId;
                    }
                }
                
                /**
                 * Normal product
                 */
                else {
                    $url = esc_url($product->add_to_cart_url());
                }
            }
        }
        else {
            return '';
        }

        $addToCart = apply_filters(
            'woocommerce_loop_add_to_cart_link',
            sprintf(
                '<a href="%s" rel="nofollow" data-quantity="1" data-product_id="%s" data-product_sku="%s" class="button-in-wishlist small btn-from-wishlist %s product_type_%s add-to-cart-grid wishlist-fragment" data-type="%s" title="%s">%s</a>',
                $url, //link
                $productId, //product id
                esc_attr($product->get_sku()), //product sku
                $enable_button_ajax ? 'tradeace_add_to_cart_from_wishlist' : '', //class name
                esc_attr($product_type),
                esc_attr($product_type), //product type
                $title,
                $title
            ),
            $product
        );
        
        if ($product_type === 'variable') {
            $addToCart .= sprintf('<a href="javascript:void(0);" class="quick-view tradeace-view-from-wishlist hidden-tag" data-prod="%s" data-from_wishlist="1" rel="nofollow">%s</a>', $productId, esc_html__('Quick View', 'tradeace-theme'));
        }
        
        return $addToCart;
    }
endif;

/**
 * Add to cart button
 */
if (!function_exists('tradeace_add_to_cart_btn')):
    function tradeace_add_to_cart_btn($echo = true, $customClass = '') {
        global $product, $tradeace_opt;

        if (isset($tradeace_opt['disable-cart']) && $tradeace_opt['disable-cart']) {
            return '';
        }

        $product_type = $product->get_type();
        $sku = $product->get_sku();
        
        $product_id = $product->get_id();
        if ($product_type == 'variation') {
            $product_id = $product->get_parent_id();
        }

        $class_btn = 'add-to-cart-grid btn-link tradeace-tip';
        
        $attributes = 'data-product_id="' . esc_attr($product_id) . '"';
        $attributes .= $sku ? ' data-product_sku="' . esc_attr($sku) . '"' : '';
        $attributes .= ' aria-label="' . esc_attr($product->add_to_cart_description()) . '"';
        $attributes .= ' rel="nofollow"';
        
        $ajaxAdd = get_option('woocommerce_enable_ajax_add_to_cart');
        
        if ($product->is_purchasable() && $product->is_in_stock()) {
            /**
             * Simple, Variation product
             */
            if ($product_type == 'simple') {
                $class_btn .= 'yes' === $ajaxAdd ? ' add_to_cart_button ajax_add_to_cart' : '';
            }
            
            /**
             * Variation product
             */
            if ($product_type == 'variation') {
                $attributes .= ' data-variation="' . esc_attr(json_encode($product->get_variation_attributes())) . '"';
                $attributes .= ' data-variation_id="' . esc_attr($product->get_id()) . '"';
            }
            
            /**
             * Yith Bundle product
             */
            if ($product_type == TRADEACE_COMBO_TYPE) {
                $class_btn .= 'yes' === $ajaxAdd ? ' add_to_cart_button tradeace_bundle_add_to_cart' : ' add_to_cart_button';
                $attributes .= ' data-type="' . esc_attr($product_type) . '"';
            }
        }
        
        if ('yes' !== $ajaxAdd) {
            $class_btn .= ' tradeace-disable-ajax';
        }
        
        $class_btn .= $customClass != '' ? ' ' . $customClass : $customClass;
        $class_button = apply_filters('tradeace_filter_add_to_cart_class', $class_btn);
        
        $icon_class = 'cart-icon ';
        $icon_number = isset($tradeace_opt['cart-icon-grid']) ? $tradeace_opt['cart-icon-grid'] : '1';
        switch ($icon_number) {
            case '2':
                $icon_class .= 'icon-tradeace-cart-3';
                break;
            case '3':
                $icon_class .= 'icon-tradeace-cart-2';
                break;
            case '4':
                $icon_class .= 'icon-tradeace-cart-4';
                break;
            case '5':
                $icon_class .= 'pe-7s-cart';
                break;
            case '6':
                $icon_class .= 'fa fa-shopping-cart';
                break;
            case '7':
                $icon_class .= 'fa fa-shopping-bag';
                break;
            case '8':
                $icon_class .= 'fa fa-shopping-basket';
                break;
            case '1':
            default:
                $icon_class .= 'tradeace-df-plus';
                break;
        }
        
        $args = apply_filters('woocommerce_loop_add_to_cart_args', array(
            'class_button' => $class_button,
            'icon_class' => $icon_class,
            'attributes' => $attributes,
            'quantity' => 1
        ), $product);

        if (!$echo) {
            ob_start();
        }
        
        wc_get_template('loop/add-to-cart.php', $args);
        
        if (!$echo) {
            return ob_get_clean();
        }
    }
endif;

/**
 * Product group buttons
 */
if (!function_exists('tradeace_product_group_button')):
    function tradeace_product_group_button($combo_show_type = 'popup') {
        ob_start();
        $file = TRADEACE_CHILD_PATH . '/includes/tradeace-product-buttons.php';
        include is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-product-buttons.php';

        return ob_get_clean();
    }
endif;

/**
 * Wishlist link
 */
if (!function_exists('tradeace_tini_wishlist')):
    function tradeace_tini_wishlist($icon = false) {
        if (!TRADEACE_WOO_ACTIVED || !TRADEACE_WISHLIST_ENABLE) {
            return;
        }

        $tini_wishlist = '';
        $wishlist_page_id = get_option('yith_wcwl_wishlist_page_id');
        if (function_exists('icl_object_id')) {
            $wishlist_page_id = icl_object_id($wishlist_page_id, 'page', true);
        }
        
        $wishlist_page = get_permalink($wishlist_page_id);

        $span = $icon ? '<span class="icon-tradeace-like"></span>' : '';
        $tini_wishlist .= '<a href="' . esc_url($wishlist_page) . '" title="' . esc_attr__('Wishlist', 'tradeace-theme') . '">' . $span . esc_html__('Wishlist', 'tradeace-theme') . '</a>';

        return $tini_wishlist;
    }
endif;

/**
 * Wishlist icons
 */
if (!function_exists('tradeace_icon_wishlist')):
    function tradeace_icon_wishlist() {
        if (!TRADEACE_WOO_ACTIVED) {
            return '';
        }

        global $tradeace_icon_wishlist;
        if (!isset($tradeace_icon_wishlist)) {
            $show = defined('TRADEACE_PLG_CACHE_ACTIVE') && TRADEACE_PLG_CACHE_ACTIVE ? false : true;
            $count = tradeace_get_count_wishlist($show);
            
            /**
             * Yith WooCommerce Wishlist
             */
            if (TRADEACE_WISHLIST_ENABLE) {
                $href = '';
                $class = 'wishlist-link inline-block';
                
                if (defined('YITH_WCWL_PREMIUM')) {
                    $class .= ' wishlist-link-premium';
                    $wishlist_page_id = get_option('yith_wcwl_wishlist_page_id');
                    
                    if (function_exists('icl_object_id') && $wishlist_page_id) {
                        $wishlist_page_id = icl_object_id($wishlist_page_id, 'page', true);
                    }

                    $href = $wishlist_page_id ? get_permalink($wishlist_page_id) : home_url('/');
                }
                
                $icon = apply_filters('tradeace_mini_icon_wishlist', '<i class="tradeace-icon wishlist-icon icon-tradeace-like"></i>');

                $tradeace_icon_wishlist = 
                '<a class="' . $class . '" href="' . ($href != '' ? esc_url($href) : 'javascript:void(0);') . '" title="' . esc_attr__('Wishlist', 'tradeace-theme') . '">' .
                    $icon .
                    $count .
                '</a>';
            }
            
            /**
             * TradeaceTheme Wishlist
             */
            else {
                global $tradeace_opt;

                if (isset($tradeace_opt['enable_tradeace_wishlist']) && !$tradeace_opt['enable_tradeace_wishlist']) {
                    return;
                }
                
                $class = 'wishlist-link tradeace-wishlist-link inline-block';
                
                $icon = apply_filters('tradeace_mini_icon_wishlist', '<i class="tradeace-icon wishlist-icon icon-tradeace-like"></i>');
                
                $tradeace_icon_wishlist = 
                '<a class="' . $class . '" href="javascript:void(0);" title="' . esc_attr__('Wishlist', 'tradeace-theme') . '" rel="nofollow">' .
                    $icon .
                    $count .
                '</a>';
            }
            
            $GLOBALS['tradeace_icon_wishlist'] = $tradeace_icon_wishlist;
        }

        return isset($tradeace_icon_wishlist) && $tradeace_icon_wishlist ? apply_filters('tradeace_mini_wishlist', $tradeace_icon_wishlist) : '';
    }
endif;

/**
 * Count mini wishlist icon
 */
if (!function_exists('tradeace_get_count_wishlist')) :
    function tradeace_get_count_wishlist($show = true, $init_count = true) {
        if (!TRADEACE_WOO_ACTIVED) {
            return '';
        }
        
        global $tradeace_opt;
        
        $count = 0;
        if (TRADEACE_WISHLIST_ENABLE) {
            $count = $init_count ? yith_wcwl_count_products() : 0;
        } else {
            $show = true;
        }
        
        $hasEmpty = (int) $count == 0 ? ' tradeace-product-empty' : '';
        $sl = $show ? '' : ' hidden-tag';
        $class_wrap = 'tradeace-wishlist-count tradeace-mini-number wishlist-number' . $sl . $hasEmpty;
        
        if (!isset($tradeace_opt['compact_number']) || $tradeace_opt['compact_number']) {
            $count = $count > 9 ? '9+' : (int) $count;
        }
        
        return 
            '<span class="' . $class_wrap . '">' .
                apply_filters('tradeace_mini_wishlist_total_items', $count) .
            '</span>';
    }
endif;

/**
 * Compare link
 */
if (!function_exists('tradeace_icon_compare')):
    function tradeace_icon_compare() {
        if (!TRADEACE_WOO_ACTIVED || !defined('YITH_WOOCOMPARE')) {
            return;
        }

        global $tradeace_icon_compare, $tradeace_opt;
        if (!$tradeace_icon_compare) {
            global $yith_woocompare;
            
            if (!isset($tradeace_opt['tradeace-product-compare']) || $tradeace_opt['tradeace-product-compare']) {
                $view_href = isset($tradeace_opt['tradeace-page-view-compage']) && (int) $tradeace_opt['tradeace-page-view-compage'] ? get_permalink((int) $tradeace_opt['tradeace-page-view-compage']) : home_url('/');
                $class = 'tradeace-show-compare inline-block';
                $wrap = false;
            } else {
                $view_href = add_query_arg(array('iframe' => 'true'), $yith_woocompare->obj->view_table_url());
                $class = 'compare';
                $wrap = true;
            }
            
            $icon = apply_filters('tradeace_mini_icon_compare', '<i class="tradeace-icon compare-icon icon-tradeace-refresh"></i>');
            
            $GLOBALS['tradeace_icon_compare'] = 
            ($wrap ? '<span class="yith-woocompare-widget">' : '') .
                '<a href="' . esc_url($view_href) . '" title="' . esc_attr__('Compare', 'tradeace-theme') . '" class="' . esc_attr($class) . '">' .
                    $icon .
                    '<span class="tradeace-compare-count tradeace-mini-number compare-number tradeace-product-empty">0</span>' .
                '</a>' .
            ($wrap ? '</span>' : '');
        }
        
        return $tradeace_icon_compare ? apply_filters('tradeace_mini_compare', $tradeace_icon_compare) : '';
    }
endif;

/**
 * Count mini Compare icon
 */
if (!function_exists('tradeace_get_count_compare')):
    function tradeace_get_count_compare($show = true) {
        if (!TRADEACE_WOO_ACTIVED || !defined('YITH_WOOCOMPARE')) {
            return '';
        }
        
        global $tradeace_opt, $yith_woocompare;
        
        $count = count($yith_woocompare->obj->products_list);
        $hasEmpty = (int) $count == 0 ? ' tradeace-product-empty' : '';
        
        $sl = $show ? '' : ' hidden-tag';
        $class_wrap = 'tradeace-compare-count tradeace-mini-number compare-number' . $sl . $hasEmpty;
        
        if (!isset($tradeace_opt['compact_number']) || $tradeace_opt['compact_number']) {
            $count = $count > 9 ? '9+' : (int) $count;
        }
        
        return
        '<span class="' . $class_wrap . '">' .
            apply_filters('tradeace_mini_compare_total_items', $count) .
        '</span>';
    }
endif;

/**
 * Tradeace root categories in Shop Top bar
 */
if (!function_exists('tradeace_get_root_categories')):
    function tradeace_get_root_categories() {
        global $tradeace_opt;
        
        $content = '';
        
        if (isset($tradeace_opt['top_filter_rootcat']) && !$tradeace_opt['top_filter_rootcat']) {
            echo ($content);
            return;
        }
        
        if (!is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) {
            echo ($content);
            return;
        }
        
        if (TRADEACE_WOO_ACTIVED){
            $tradeace_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                'taxonomy' => 'product_cat',
                'parent' => 0,
                'hide_empty' => false,
                'orderby' => 'name'
            )));
            
            if ($tradeace_terms) {
                $slug = get_query_var('product_cat');
                $tradeace_catActive = $slug ? $slug : '';
                $content .= '<div class="tradeace-transparent-topbar"></div>';
                $content .= '<div class="tradeace-root-cat-topbar-warp hidden-tag"><ul class="tradeace-root-cat product-categories">';
                $content .= '<li class="tradeace_odd"><span class="tradeace-root-cat-header">' . esc_html__('CATEGORIES', 'tradeace-theme'). '</span></li>';
                $li_class = 'tradeace_even';
                foreach ($tradeace_terms as $v) {
                    $class_active = $tradeace_catActive == $v->slug ? ' tradeace-active' : '';
                    $content .= '<li class="cat-item cat-item-' . esc_attr($v->term_id) . ' cat-item-accessories root-item ' . $li_class . '">';
                    $content .= '<a href="' . esc_url(get_term_link($v)) . '" data-id="' . esc_attr($v->term_id) . '" class="tradeace-filter-by-cat' . $class_active . '" title="' . esc_attr($v->name) . '" data-taxonomy="product_cat">' . esc_attr($v->name) . '</a>';
                    $content .= '</li>';
                    $li_class = $li_class == 'tradeace_even' ? 'tradeace_odd' : 'tradeace_even';
                }
                
                $content .= '</ul></div>';
            }
        }
        
        $icon = $content != '' ? '<div class="tradeace-icon-cat-topbar"><a href="javascript:void(0);" rel="nofollow"><i class="pe-7s-menu"></i><span class="inline-block">' . esc_html__('BROWSE', 'tradeace-theme') . '</span></a></div>' : '';
        $content = $icon . $content;
        
        echo $content;
    }
endif;

/**
 * Categories thumbnail
 */
if (!function_exists('tradeace_category_thumbnail')) :
    function tradeace_category_thumbnail($category = null, $type = 'shop_thumbnail') {
        if (!$category) {
            return '';
        }
    
        $img_str = '';
        $small_thumbnail_size = apply_filters('single_product_small_thumbnail_size', $type);
        $thumbnail_id = function_exists('get_term_meta') ? get_term_meta($category->term_id, 'thumbnail_id', true) : get_woocommerce_term_meta($category->term_id, 'thumbnail_id', true);

        $image_src = '';
        if ($thumbnail_id) {
            $image = wp_get_attachment_image_src($thumbnail_id, $small_thumbnail_size);
            $image_src = $image[0];
            $image_width = $image[1];
            $image_height = $image[2];
        } else {
            $image_src = wc_placeholder_img_src();
            $image_width = 100;
            $image_height = 100;
        }

        if ($image_src) {
            $image_src = str_replace(' ', '%20', $image_src);
            $img_str = '<img src="' . esc_url($image_src) . '" alt="' . esc_attr($category->name) . '" width="' . $image_width . '" height="' . $image_height . '" />';
        }

        return $img_str;
    }
endif;

/**
 * Login Or Register Form
 */
add_action('tradeace_login_register_form', 'tradeace_login_register_form', 10, 1);
if (!function_exists('tradeace_login_register_form')) :
    function tradeace_login_register_form($prefix = false) {
        global $tradeace_opt;
        if (!TRADEACE_WOO_ACTIVED) {
            return;
        }
        
        $file = TRADEACE_CHILD_PATH . '/includes/tradeace-login-register-form.php';
        include is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-login-register-form.php';
    }
endif;

/**
 * Number post_per_page shop/archive_product
 */
add_filter('loop_shop_per_page', 'tradeace_loop_shop_per_page', 20);
if (!function_exists('tradeace_loop_shop_per_page')) :
    function tradeace_loop_shop_per_page($post_per_page) {
        global $tradeace_opt;
        
        return (isset($tradeace_opt['products_pr_page']) && (int) $tradeace_opt['products_pr_page']) ? (int) $tradeace_opt['products_pr_page'] : get_option('posts_per_page');
    }
endif;

/**
 * Number relate products
 */
add_filter('woocommerce_output_related_products_args', 'tradeace_output_related_products_args');
if (!function_exists('tradeace_output_related_products_args')) :
    function tradeace_output_related_products_args($args) {
        global $tradeace_opt;
        $args['posts_per_page'] = (isset($tradeace_opt['relate_product_number']) && (int) $tradeace_opt['relate_product_number']) ? (int) $tradeace_opt['relate_product_number'] : 12;
        
        return $args;
    }
endif;

/**
 * Compare list in bot site
 */
add_action('tradeace_show_mini_compare', 'tradeace_show_mini_compare');
if (!function_exists('tradeace_show_mini_compare')) :
    function tradeace_show_mini_compare() {
        global $tradeace_opt, $yith_woocompare;
        
        if (isset($tradeace_opt['tradeace-product-compare']) && !$tradeace_opt['tradeace-product-compare']) {
            echo '';
            return;
        }
        
        $tradeace_compare = isset($yith_woocompare->obj) ? $yith_woocompare->obj : $yith_woocompare;
        if (!$tradeace_compare) {
            echo '';
            return;
        }
        
        if (!isset($tradeace_opt['tradeace-page-view-compage']) || !(int) $tradeace_opt['tradeace-page-view-compage']) {
            $pages = get_pages(array(
                'meta_key' => '_wp_page_template',
                'meta_value' => 'page-view-compare.php'
            ));
            
            if ($pages) {
                foreach ($pages as $page) {
                    $tradeace_opt['tradeace-page-view-compage'] = (int) $page->ID;
                    break;
                }
            }
        }
        
        $view_href = isset($tradeace_opt['tradeace-page-view-compage']) && (int) $tradeace_opt['tradeace-page-view-compage'] ? get_permalink((int) $tradeace_opt['tradeace-page-view-compage']) : home_url('/');
        
        $tradeace_compare_list = $tradeace_compare->get_products_list();
        $max_compare = isset($tradeace_opt['max_compare']) ? (int) $tradeace_opt['max_compare'] : 4;
        
        $file = TRADEACE_CHILD_PATH . '/includes/tradeace-mini-compare.php';
        include is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-mini-compare.php';
    }
endif;

/**
 * Default page compare
 */
if (!function_exists('tradeace_products_compare_content')) :
    function tradeace_products_compare_content($echo = false) {
        global $tradeace_opt, $yith_woocompare;
        
        if (isset($tradeace_opt['tradeace-product-compare']) && !$tradeace_opt['tradeace-product-compare']) {
            return '';
        }
        
        $tradeace_compare = isset($yith_woocompare->obj) ? $yith_woocompare->obj : $yith_woocompare;
        if (!$tradeace_compare) {
            return '';
        }
        
        $file = TRADEACE_CHILD_PATH . '/includes/tradeace-view-compare.php';
        if (!$echo) {
            ob_start();
            include is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-view-compare.php';

            return ob_get_clean();
        } else {
            include is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-view-compare.php';
        }
    }
endif;

/**
 * NEXT NAV ON SINGLE PRODUCT
 */
add_action('next_prev_product', 'tradeace_next_product');
if (!function_exists('tradeace_next_product')) :
    function tradeace_next_product() {
        global $tradeace_opt;
        
        $next_post = get_next_post(true, '', 'product_cat');
        if (is_a($next_post, 'WP_Post')) {
            $product_obj = new WC_Product($next_post->ID);
            $title = get_the_title($next_post->ID);
            $link = get_the_permalink($next_post->ID);
            $class_ajax = (isset($tradeace_opt['single_product_ajax']) && $tradeace_opt['single_product_ajax']) ? ' tradeace-ajax-call' : '';
            ?>
            <div class="next-product next-prev-buttons">
                <a href="<?php echo esc_url($link); ?>" rel="next" class="icon-next-prev pe-7s-angle-right next<?php echo $class_ajax; ?>" title="<?php echo esc_attr($title); ?>"></a>
                <a class="dropdown-wrap<?php echo $class_ajax; ?>" title="<?php echo esc_attr($title); ?>" href="<?php echo esc_url($link); ?>">
                    <?php echo get_the_post_thumbnail($next_post->ID, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail')); ?>
                    <div class="next-prev-info">
                        <p class="product-name"><?php echo $title; ?></p>
                        <span class="price"><?php echo $product_obj->get_price_html(); ?></span>
                    </div>
                </a>
            </div>
            <?php
        }
    }
endif;

/**
 * PRVE NAV ON SINGLE PRODUCT PAGE
 */
add_action('next_prev_product', 'tradeace_prev_product');
if (!function_exists('tradeace_prev_product')) :
    function tradeace_prev_product() {
        global $tradeace_opt;

        $prev_post = get_previous_post(true, '', 'product_cat');
        if (is_a($prev_post, 'WP_Post')) {
            $product_obj = new WC_Product($prev_post->ID);
            $title = get_the_title($prev_post->ID);
            $link = get_the_permalink($prev_post->ID);
            $class_ajax = (isset($tradeace_opt['single_product_ajax']) && $tradeace_opt['single_product_ajax']) ? ' tradeace-ajax-call' : '';
            ?>
            <div class="prev-product next-prev-buttons">
                <a href="<?php echo esc_url($link); ?>" rel="prev" class="icon-next-prev pe-7s-angle-left prev<?php echo $class_ajax; ?>" title="<?php echo esc_attr($title); ?>"></a>
                <a class="dropdown-wrap<?php echo $class_ajax; ?>" title="<?php echo esc_attr($title); ?>" href="<?php echo esc_url($link); ?>">
                    <?php echo get_the_post_thumbnail($prev_post->ID, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail')); ?>
                    <div class="next-prev-info">
                        <p class="product-name"><?php echo $title; ?></p>
                        <span class="price"><?php echo $product_obj->get_price_html(); ?></span>
                    </div>
                </a>
            </div>
            <?php
        }
    }
endif;

/**
 * ADD LIGHTBOX IMAGES BUTTON ON PRODUCT DETAIL PAGE
 */
add_action('tradeace_single_buttons', 'tradeace_product_single_lightbox_btn');
if (!function_exists('tradeace_product_single_lightbox_btn')) {
    function tradeace_product_single_lightbox_btn() {
        echo '<a class="product-lightbox-btn hidden-tag" href="javascript:void(0);" rel="nofollow"></a>';
    }
}

/**
 * ADD VIDEO PLAY BUTTON ON PRODUCT DETAIL PAGE
 */
add_action('tradeace_single_buttons', 'tradeace_product_video_btn', 30);
if (!function_exists('tradeace_product_video_btn')) {
    function tradeace_product_video_btn() {
        global $product;
        
        $id = $product->get_id();
        $video_link = tradeace_get_product_meta_value($id, '_product_video_link');
 
        if ($video_link) {
            ?>
            <a class="product-video-popup tradeace-tip tradeace-tip-right" data-tip="<?php esc_attr_e('Play Video', 'tradeace-theme'); ?>" href="<?php echo esc_url($video_link); ?>" title="<?php esc_attr_e('Play Video', 'tradeace-theme'); ?>">
                <span class="tradeace-icon pe-7s-play"></span>
            </a>

            <?php
            $height = '800';
            $width = '800';
            $iframe_scale = '100%';
            $custom_size = tradeace_get_product_meta_value($id, '_product_video_size');
            if ($custom_size) {
                $split = explode("x", $custom_size);
                $height = $split[0];
                $width = $split[1];
                $iframe_scale = ($width / $height * 100) . '%';
            }
            
            $style = '.has-product-video .mfp-iframe-holder .mfp-content{max-width: ' . $width . 'px;}';
            $style .= '.has-product-video .mfp-iframe-scaler{padding-top: ' . $iframe_scale . ';}';
            wp_add_inline_style('product_detail_css_custom', $style);
        }
    }
}

/**
 * Wishlist Button ext Yith Wishlist
 */
if (!function_exists('tradeace_add_wishlist_button')) :
    function tradeace_add_wishlist_button($tip = 'left') {
        if (TRADEACE_WISHLIST_ENABLE) {
            global $product, $yith_wcwl, $tradeace_opt;
            if (!$yith_wcwl) {
                return;
            }
            
            $variation = false;
            $productId = $product->get_id();
            $productType = $product->get_type();
            if ($productType == 'variation') {
                $variation_product = $product;
                $productId = wp_get_post_parent_id($productId);
                $parentProduct = wc_get_product($productId);
                $productType = $parentProduct->get_type();
                
                $GLOBALS['product'] = $parentProduct;
                $variation = true;
            }

            $class_btn = 'btn-wishlist btn-link wishlist-icon tradeace-tip';
            $class_btn .= ' tradeace-tip-' . $tip;
            
            /**
             * Apply Filters Icon
             */
            $icon = apply_filters('tradeace_icon_wishlist', '<i class="tradeace-icon icon-tradeace-like"></i>');
            ?>
            <a href="javascript:void(0);" class="<?php echo esc_attr($class_btn); ?>" data-prod="<?php echo (int) $productId; ?>" data-prod_type="<?php echo esc_attr($productType); ?>" data-original-product-id="<?php echo (int) $productId; ?>" data-icon-text="<?php esc_attr_e('Wishlist', 'tradeace-theme'); ?>" title="<?php esc_attr_e('Wishlist', 'tradeace-theme'); ?>" rel="nofollow">
                <?php echo $icon; ?>
            </a>

            <?php if (isset($tradeace_opt['optimize_wishlist_html']) && !$tradeace_opt['optimize_wishlist_html']) : ?>
                <div class="add-to-link hidden-tag">
                    <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                </div>
            <?php endif; ?>

            <?php
            if ($variation) {
                $GLOBALS['product'] = $variation_product;
            }
        }
    }
endif;

/**
 * progress bar stock quantity
 */
if (!function_exists('tradeace_single_availability')) :
    function tradeace_single_availability() {
        global $product;
        
        // Availability
        $availability = $product->get_availability();

        if ($availability['availability']) :
            echo apply_filters('woocommerce_stock_html', '<p class="stock ' . esc_attr($availability['class']) . '">' . wp_kses(__('<span>Availability:</span> ', 'tradeace-theme'), array('span' => array())) . esc_html($availability['availability']) . '</p>', $availability['availability']);
        endif;
    }
endif;

/**
 * Toggle coupon
 */
if (!function_exists('tradeace_wrap_coupon_toggle')) :
    function tradeace_wrap_coupon_toggle($content) {
        return '<div class="tradeace-toggle-coupon-checkout">' . $content . '</div>';
    }
endif;

/**
 * Tab Combo Yith Bundle product
 */
if (!function_exists('tradeace_combo_tab')) :
    function tradeace_combo_tab($tradeace_viewmore = true) {
        global $woocommerce, $tradeace_opt, $product;

        if (!$woocommerce || !$product || $product->get_type() != TRADEACE_COMBO_TYPE || !$combo = $product->get_bundled_items()) {
            return false;
        }

        $file = TRADEACE_CHILD_PATH . '/includes/tradeace-combo-products-in-detail.php';
        $file = is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-combo-products-in-detail.php';
        ob_start();
        include $file;

        return ob_get_clean();
    }
endif;

/**
 * Get All categories product filter in top
 */
if (!function_exists('tradeace_get_all_categories')) :
    function tradeace_get_all_categories($only_show_child = false, $main = false, $hierarchical = true, $order = 'order') {
        if (!TRADEACE_WOO_ACTIVED) {
            return;
        }
        
        if (!$only_show_child) {
            global $tradeace_top_filter;
        }
        
        if (!isset($tradeace_top_filter)) {
            global $tradeace_opt, $wp_query, $post;

            $current_cat = false;
            $cat_ancestors = array();
            
            $root_id = 0;
            
            /**
             * post type page
             */
            if (
                isset($tradeace_opt['disable_top_level_cat']) &&
                $tradeace_opt['disable_top_level_cat'] &&
                isset($post->ID) &&
                $post->post_type == 'page'
            ) {
                $current_slug = get_post_meta($post->ID, '_tradeace_root_category', true);
                
                if ($current_slug) {
                    $current_cat = get_term_by('slug', $current_slug, 'product_cat');
                    if ($current_cat && isset($current_cat->term_id)) {
                        $cat_ancestors = get_ancestors($current_cat->term_id, 'product_cat');
                    }
                }
            }
            
            /**
             * Archive product category
             */
            elseif (is_tax('product_cat')) {
                $current_cat = $wp_query->queried_object;
                $cat_ancestors = get_ancestors($current_cat->term_id, 'product_cat');
            }
            
            /**
             * Single product page
             */
            elseif (is_singular('product')) {
                $productId = isset($wp_query->queried_object->ID) ? $wp_query->queried_object->ID : $post->ID;
                
                $product_category = wc_get_product_terms($productId, 'product_cat', array(
                    'orderby' => 'parent',
                    'order'   => 'DESC'
                ));
                
                if ($product_category) {
                    $main_term = apply_filters('woocommerce_product_categories_widget_main_term', $product_category[0], $product_category);
                    $current_cat = $main_term;
                    $cat_ancestors = get_ancestors($main_term->term_id, 'product_cat');
                }
            }
            
            if ($only_show_child && $current_cat && $current_cat->term_id) {
                $terms_chilren = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                    'taxonomy' => 'product_cat',
                    'parent' => $current_cat->term_id,
                    'hierarchical' => $hierarchical,
                    'hide_empty' => false
                )));

                if (!$terms_chilren) {
                    $term_root = get_ancestors($current_cat->term_id, 'product_cat');
                    $root_id = isset($term_root[0]) ? $term_root[0] : $root_id;
                } else {
                    $root_id = $current_cat->term_id;
                }
            }
            
            elseif ((isset($tradeace_opt['disable_top_level_cat']) && $tradeace_opt['disable_top_level_cat'])) {
                $root_id = $cat_ancestors ? end($cat_ancestors) : ($current_cat ? $current_cat->term_id : $root_id);
            }
            
            $hide_empty = (isset($tradeace_opt['hide_empty_cat_top']) && $tradeace_opt['hide_empty_cat_top']) ? true : false;
            $args = array(
                'taxonomy' => 'product_cat',
                'show_count' => 0,
                'hierarchical' => 1,
                'hide_empty' => apply_filters('tradeace_top_filter_cats_hide_empty', $hide_empty)
            );
            
            /**
             * Max depth = 0 ~ all
             */
            $max_depth = !isset($tradeace_opt['depth_cat_top']) ? 0 : (int) $tradeace_opt['depth_cat_top']; 
            $args['depth'] = apply_filters('tradeace_max_depth_top_filter_cats', $max_depth);
            
            $args['menu_order'] = false;
            if ($order == 'order') {
                $args['menu_order'] = 'asc';
            } else {
                $args['orderby'] = 'title';
            }
            
            $args['walker'] = new Trade_Ace_Product_Cat_List_Walker($args['depth']);
            $args['title_li'] = '';
            $args['pad_counts'] = 1;
            $args['show_option_none'] = esc_html__('No product categories exist.', 'tradeace-theme');
            $args['current_category'] = $current_cat ? $current_cat->term_id : '';
            $args['current_category_ancestors'] = $cat_ancestors;
            $args['child_of'] = apply_filters('tradeace_root_id_top_filter_cats', $root_id);
            $args['echo'] = false;
            
            if (version_compare(WC()->version, '3.3.0', ">=") && (!isset($tradeace_opt['show_uncategorized']) || !$tradeace_opt['show_uncategorized'])) {
                $args['exclude'] = get_option('default_product_cat');
            }

            $tradeace_top_filter = '<ul class="tradeace-top-cat-filter product-categories tradeace-accordion">';
            
            $tradeace_top_filter .= wp_list_categories(apply_filters('woocommerce_product_categories_widget_args', $args));
            
            $tradeace_top_filter .= '<li class="tradeace-current-note"></li>';
            $tradeace_top_filter .= '</ul>';
            
            if (!$only_show_child) {
                $GLOBALS['tradeace_top_filter'] = $tradeace_top_filter;
            }
        }
        
        $result = $tradeace_top_filter;
        if ($main) {
            $result = '<div id="tradeace-main-cat-filter">' . $result . '</div>';
        }
        
        return $result;
    }
endif;

/**
 * tradeace_archive_get_sub_categories
 */
add_action('tradeace_archive_get_sub_categories', 'tradeace_archive_get_sub_categories');
if (!function_exists('tradeace_archive_get_sub_categories')) :
    function tradeace_archive_get_sub_categories() {
        $GLOBALS['tradeace_cat_loop_delay'] = 0;
        
        echo '<div class="tradeace-archive-sub-categories-wrap">';
        
        woocommerce_product_subcategories(array(
            'before' => '<div class="row"><div class="large-12 columns"><h3>' . esc_html__('Subcategories: ', 'tradeace-theme') . '</h3></div></div><div class="row">',
            'after' => '</div><div class="row"><div class="large-12 columns margin-bottom-20 margin-top-20 text-center"><hr class="margin-left-20 margin-right-20" /></div></div>'
        ));
        
        echo '</div>';
    }
endif;

/**
 * Pagination product pages
 */
if (!function_exists('tradeace_get_pagination_ajax')) :
    function tradeace_get_pagination_ajax(
        $total = 1,
        $current = 1,
        $type = 'list',
        $prev_text = 'PREV', 
        $next_text = 'NEXT',
        $end_size = 3, 
        $mid_size = 3,
        $prev_next = true,
        $show_all = false
    ) {

        if ($total < 2) {
            return;
        }

        if ($end_size < 1) {
            $end_size = 1;
        }

        if ($mid_size < 0) {
            $mid_size = 2;
        }

        $r = '';
        $page_links = array();

        // PREV Button
        if ($prev_next && $current && 1 < $current){
            $page_links[] = '<a class="tradeace-prev prev page-numbers" data-page="' . ((int)$current - 1) . '" href="javascript:void(0);" rel="nofollow">' . $prev_text . '</a>';
        }

        // PAGE Button
        $moreStart = false;
        $moreEnd = false;
        for ($n = 1; $n <= $total; $n++){
            $page = number_format_i18n($n);
            if ($n == $current){
                $page_links[] = '<a class="tradeace-current current page-numbers" data-page="' . $page . '" href="javascript:void(0);" rel="nofollow">' . $page . '</a>';
            }
            
            else {
                if ($show_all || ($current && $n >= $current - $mid_size && $n <= $current + $mid_size)) {
                    $page_links[] = '<a class="tradeace-page page-numbers" data-page="' . $page . '" href="javascript:void(0);" rel="nofollow">' . $page . "</a>";
                }
                
                elseif ($n == 1 || $n == $total) {
                    $page_links[] = '<a class="tradeace-page page-numbers" data-page="' . $page . '" href="javascript:void(0);" rel="nofollow">' . $page . "</a>";
                }
                
                elseif (!$moreStart && $n <= $end_size + 1) {
                    $moreStart = true;
                    $page_links[] = '<span class="tradeace-page-more">' . esc_html__('...', 'tradeace-theme') . '</span>';
                }
                
                elseif (!$moreEnd && $n > $total - $end_size - 1) {
                    $moreEnd = true;
                    $page_links[] = '<span class="tradeace-page-more">' . esc_html__('...', 'tradeace-theme') . '</span>';
                }
            }
        }

        // NEXT Button
        if ($prev_next && $current && ($current < $total || -1 == $total)){
            $page_links[] = '<a class="tradeace-next next page-numbers" data-page="' . ((int)$current + 1)  . '" href="javascript:void(0);" rel="nofollow">' . $next_text . '</a>';
        }
        // DATA Return
        switch ($type) {
            case 'array' :
                return $page_links;

            case 'list' :
                $r .= '<ul class="page-numbers tradeace-pagination-ajax"><li>';
                $r .= implode('</li><li>', $page_links);
                $r .= '</li></ul>';
                break;

            default :
                $r = implode('', $page_links);
                break;
        }

        return $r;
    }
endif;

/**
 * No paging url
 */
if (!function_exists('tradeace_nopaging_url')) :
    function tradeace_nopaging_url() {
        global $wp;

        if (!$wp->request) {
            return false;
        }

        $current_url = home_url($wp->request);
        $pattern = '/page(\/)*([0-9\/])*/i';
        $nopaging_url = preg_replace($pattern, '', $current_url);

        return trailingslashit($nopaging_url);
    }
endif;

/**
 * Compatible WooCommerce_Advanced_Free_Shipping
 * Only with one Rule "subtotal >= Rule"
 */
add_action('tradeace_subtotal_free_shipping', 'tradeace_subtotal_free_shipping');
add_action('woocommerce_widget_shopping_cart_total', 'tradeace_subtotal_free_shipping', 20);
if (!function_exists('tradeace_subtotal_free_shipping')) :
    function tradeace_subtotal_free_shipping($return = false) {
        $content = '';
        
        /**
         * Check active plug-in WooCommerce || WooCommerce_Advanced_Free_Shipping
         */
        if (!TRADEACE_WOO_ACTIVED || !class_exists('WooCommerce_Advanced_Free_Shipping') || !function_exists('WAFS')) {
            return $content;
        }

        /**
         * Check setting plug-in
         */
        $wafs = WAFS();
        if (!isset($wafs->was_method)) {
            $wafs->wafs_free_shipping();
        }
        
        $wafs_method = isset($wafs->was_method) ? $wafs->was_method : null;
        if (!$wafs_method || $wafs_method->hide_shipping === 'no' || $wafs_method->enabled === 'no') {
            return $content;
        }

        /**
         * Check only 1 post wafs inputed
         */
        $wafs_posts = get_posts(array(
            'posts_per_page'    => 2,
            'post_status'       => 'publish',
            'post_type'         => 'wafs'
        ));
        if (!$wafs_posts || count($wafs_posts) !== 1) {
            return $content;
        }

        /**
         * Check only 1 rule on 1 post inputed
         */
        $wafs_post = $wafs_posts[0];
        $condition_groups = get_post_meta($wafs_post->ID, '_wafs_shipping_method_conditions', true);
        if (!$condition_groups || count($condition_groups) !== 1) {
            return;
        }
        $condition_group = $condition_groups[0];
        if (!$condition_group || count($condition_group) !== 1) {
            return $content;
        }

        /**
         * Check rule is subtotal
         */
        $value = 0;
        foreach ($condition_group as $condition) {
            if ($condition['condition'] !== 'subtotal' || $condition['operator'] !== '>=' || !$condition['value']) {
                return $content;
            }

            $value = $condition['value'];
            break;
        }

        $subtotalCart = WC()->cart->subtotal;
        $spend = 0;
        
        /**
         * Check free shipping
         */
        if ($subtotalCart < $value) {
            $spend = $value - $subtotalCart;
            $per = intval(($subtotalCart/$value)*100);
            
            $content .= '<div class="tradeace-total-condition-wrap">';
            
            $content .= '<div class="tradeace-total-condition" data-per="' . $per . '">' .
                '<span class="tradeace-total-condition-hint">' . $per . '%</span>' .
                '<div class="tradeace-subtotal-condition">' . $per . '%</div>' .
            '</div>';
            
            $allowed_html = array(
                'strong' => array(),
                'a' => array(
                    'class' => array(),
                    'href' => array(),
                    'title' => array()
                ),
                'span' => array(
                    'class' => array()
                ),
                'br' => array()
            );
            
            $content .= '<div class="tradeace-total-condition-desc">' .
            sprintf(
                wp_kses(__('Spend %s more to reach <strong>FREE SHIPPING!</strong> <a class="tradeace-close-magnificPopup hide-in-cart-sidebar" href="%s" title="Continue Shopping">Continue Shopping</a><br /><span class="hide-in-cart-sidebar">to add more products to your cart and receive free shipping for order %s.</span>', 'tradeace-theme'), $allowed_html),
                wc_price($spend),
                esc_url(get_permalink(wc_get_page_id('shop'))),
                wc_price($value)
            ) . 
            '</div>';
            
            $content .= '</div>';
        }
        /**
         * Congratulations! You've got free shipping!
         */
        else {
            $content .= '<div class="tradeace-total-condition-wrap">';
            $content .= '<div class="tradeace-total-condition-desc">';
            $content .= sprintf(
                esc_html__("Congratulations! You get free shipping with your order greater %s.", 'tradeace-theme'),
                wc_price($value)
            );
            $content .= '</div>';
            $content .= '</div>';
        }
        
        if (!$return) {
            echo $content;
            
            return;
        }
        
        return $content;
    }
endif;

/**
 * Add Free_Shipping to Cart page
 */
add_action('woocommerce_cart_contents', 'tradeace_subtotal_free_shipping_in_cart');
if (!function_exists('tradeace_subtotal_free_shipping_in_cart')) :
    function tradeace_subtotal_free_shipping_in_cart() {
        $content = tradeace_subtotal_free_shipping(true);
        
        if ($content !== '') {
            echo '<tr class="tradeace-no-border"><td colspan="6" class="tradeace-subtotal_free_shipping">' . $content . '</td></tr>';
        }
    }
endif;

/**
 * Before account Navigation
 */
add_action('woocommerce_before_account_navigation', 'tradeace_before_account_nav');
if (!function_exists('tradeace_before_account_nav')) :
    function tradeace_before_account_nav() {
        global $tradeace_opt;
        
        if (!TRADEACE_WOO_ACTIVED || !TRADEACE_CORE_USER_LOGGED || (isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile'])) {
            return;
        }
        
        $current_user = wp_get_current_user();
        $logout_url = wp_logout_url(home_url('/'));
        ?>
        <div class="account-nav-wrap vertical-tabs">
            <div class="account-nav account-user hide-for-small">
                <?php echo get_avatar($current_user->ID, 60); ?>
                <span class="user-name">
                    <?php echo esc_attr($current_user->display_name); ?>
                </span>
                <span class="logout-link">
                    <a href="<?php echo esc_url($logout_url); ?>" title="<?php esc_attr_e('Logout', 'tradeace-theme'); ?>">
                        <?php esc_html_e('Logout', 'tradeace-theme'); ?>
                    </a>
                </span>
            </div>
    <?php
    }
endif;

/**
 * After account Navigation
 */
add_action('woocommerce_after_account_navigation', 'tradeace_after_account_nav');
if (!function_exists('tradeace_after_account_nav')) :
    function tradeace_after_account_nav() {
        global $tradeace_opt;
        if (!TRADEACE_WOO_ACTIVED || !TRADEACE_CORE_USER_LOGGED || (isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile'])) {
            return;
        }
        
        echo '</div>';
    }
endif;

/**
 * Account Dashboard Square
 */
add_action('woocommerce_account_dashboard', 'tradeace_account_dashboard_nav');
if (!function_exists('tradeace_account_dashboard_nav')) :
    function tradeace_account_dashboard_nav() {
        if (!TRADEACE_WOO_ACTIVED || !TRADEACE_CORE_USER_LOGGED) {
            return;
        }
        
        $menu_items = wc_get_account_menu_items();
        if (empty($menu_items)) {
            return;
        }
        ?>
        <nav class="woocommerce-MyAccount-navigation tradeace-MyAccount-navigation">
            <ul>
                <?php foreach ($menu_items as $endpoint => $label) : ?>
                    <li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?php echo esc_html($label); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    <?php
    }
endif;

/**
 * Custom class Single product Price
 */
add_filter('woocommerce_product_price_class', 'tradeace_product_price_class');
if (!function_exists('tradeace_product_price_class')) :
    function tradeace_product_price_class($class) {
        $class .= ' tradeace-single-product-price';
        
        return $class;
    }
endif;

/**
 * Custom class Single product tabs
 */
add_filter('tradeace_single_product_tabs_style', 'tradeace_single_product_tabs_class');
if (!function_exists('tradeace_single_product_tabs_class')) :
    function tradeace_single_product_tabs_class($class) {
        global $tradeace_opt, $product;
        
        $classes = isset($tradeace_opt['tab_style_info']) ? $tradeace_opt['tab_style_info'] : $class;
        
        /**
         * Override in Single product Options
         */
        $single_tabStyle = tradeace_get_product_meta_value($product->get_id(), 'tradeace_tab_style');
        if ($single_tabStyle) {
            $classes = $single_tabStyle;
        }
        
        /**
         * Override in Root Category
         */
        else {
            $rootCatId = tradeace_get_root_term_id();
            if ($rootCatId) {
                $tab_style = get_term_meta($rootCatId, 'single_product_tabs_style', true);
                $classes = $tab_style ? $tab_style : $classes;
            }
        }
        
        if ($classes == 'scroll-down' && isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile']) :
            $classes = '2d-no-border';
        endif;
        
        return $classes;
    }
endif;

/**
 *
 * Add tab Promotion Gifts (Yith WooCommerce Bundle)
 */
add_filter('woocommerce_product_tabs', 'tradeace_yith_woo_product_bundle');
function tradeace_yith_woo_product_bundle($tabs) {
    global $product;
    if (!defined('YITH_WCPB') || $product->get_type() != TRADEACE_COMBO_TYPE) {
        return $tabs;
    }
    
    $product_id = $product->get_id();
    if (!isset($tradeace_combo_detail[$product_id])) {
        $combo = $product->get_bundled_items();
        $tradeace_combo_detail[$product->get_id()] = '';
        if ($combo) {
            $file = TRADEACE_CHILD_PATH . '/includes/tradeace-combo-products-in-detail.php';
            $file = is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-combo-products-in-detail.php';

            ob_start();
            include $file;
            $tradeace_combo_detail[$product->get_id()] = ob_get_clean();
        }
        
        $GLOBALS['tradeace_combo_detail'] = $tradeace_combo_detail;
    }
    
    if ($tradeace_combo_detail[$product_id] == '') {
        return $tabs;
    }
    
    $tabs['tradeace_combo_detail'] = array(
        'title'     => esc_html__('Promotion Gifts', 'tradeace-theme'),
        'priority'  => apply_filters('tradeace_yith_woo_product_bundle_tab_priority', 5),
        'callback'  => 'tradeace_yith_woo_product_bundle_content'
    );

    return $tabs;
}

/**
 * Content Promotion Gifts (Yith WooCommerce Bundle) of the current Product
 */
function tradeace_yith_woo_product_bundle_content() {
    global $product, $tradeace_combo_detail;
    if (!$product || !isset($tradeace_combo_detail[$product->get_id()])) {
        return;
    }

    echo $tradeace_combo_detail[$product->get_id()];
}

/**
 * Get Root term_id
 */
if (!function_exists('tradeace_get_root_term_id')) :
    function tradeace_get_root_term_id() {
        return function_exists('tradeace_root_term_id') ? tradeace_root_term_id() : false;
    }
endif;
