<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Disable default Yith Woo wishlist button
 */
if (TRADEACE_WISHLIST_ENABLE && function_exists('YITH_WCWL_Frontend')) {
    remove_action('init', array(YITH_WCWL_Frontend(), 'add_button'));
}

/*
 * Remove action woocommerce
 */
add_action('init', 'tradeace_remove_action_woo');
if (!function_exists('tradeace_remove_action_woo')) :
    function tradeace_remove_action_woo() {
        if (!TRADEACE_WOO_ACTIVED) {
            return;
        }
        
        global $tradeace_opt, $yith_woocompare;
        
        /* UNREGISTRER DEFAULT WOOCOMMERCE HOOKS */
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_show_messages', 10);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
        
        remove_action('woocommerce_single_product_summary', 'woocommerce_breadcrumb', 20);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
        
        if (isset($tradeace_opt['disable-cart']) && $tradeace_opt['disable-cart']) {
            remove_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
            remove_action('woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30);
            remove_action('woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30);
        }
        
        remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
        remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);

        remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
        
        /**
         * Remove compare default
         */
        if ($yith_woocompare) {
            $tradeace_compare = isset($yith_woocompare->obj) ? $yith_woocompare->obj : $yith_woocompare;
            remove_action('woocommerce_after_shop_loop_item', array($tradeace_compare, 'add_compare_link'), 20);
            remove_action('woocommerce_single_product_summary', array($tradeace_compare, 'add_compare_link'), 35);
        }
        
        /**
         * For content-product
         */
        remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
        remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
        
        /**
         * Shop page
         */
        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
        
        /**
         * Sale-Flash
         */
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
        
        /**
         * Mini Cart
         */
        remove_action('woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10);
        
        /**
         * Remove Relate Products
         */
        if (isset($tradeace_opt['relate_product']) && !$tradeace_opt['relate_product']) {
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
        }
    }
endif;

/*
 * Add action woocommerce
 */
add_action('init', 'tradeace_add_action_woo');
if (!function_exists('tradeace_add_action_woo')) :
    function tradeace_add_action_woo() {
        if (!TRADEACE_WOO_ACTIVED) {
            return;
        }
        
        global $tradeace_opt, $yith_woocompare, $tradeace_loadmore_style;
        
        // add_action('tradeace_root_cats', 'tradeace_get_root_categories');
        add_action('tradeace_child_cat', 'tradeace_get_childs_category', 10, 2);
        
        // Results count in shop page
        $disable_ajax_product = false;
        if ((isset($tradeace_opt['disable_ajax_product']) && $tradeace_opt['disable_ajax_product'])) :
            $disable_ajax_product = true;
        endif;
        
        $pagination_style = isset($tradeace_opt['pagination_style']) ? $tradeace_opt['pagination_style'] : 'style-2';
        
        if (isset($_REQUEST['paging-style']) && in_array($_REQUEST['paging-style'], $tradeace_loadmore_style)) {
            $pagination_style = $_REQUEST['paging-style'];
        }
        
        if ($disable_ajax_product) :
            $pagination_style = $pagination_style == 'style-2' ? 'style-2' : 'style-1';
        else :
            add_action('woocommerce_before_main_content', 'tradeace_open_woo_main');
            add_action('woocommerce_after_main_content', 'tradeace_close_woo_main');
        endif;
        
        if (in_array($pagination_style, $tradeace_loadmore_style)) {
            add_action('tradeace_shop_category_count', 'tradeace_result_count', 20);
        } else {
            add_action('tradeace_shop_category_count', 'woocommerce_result_count', 20);
        }
        
        add_action('woocommerce_archive_description', 'tradeace_before_archive_description', 1);
        add_action('woocommerce_archive_description', 'tradeace_get_cat_top', 5);
        add_action('woocommerce_archive_description', 'tradeace_after_archive_description', 999);
        
        add_action('woocommerce_after_shop_loop', 'tradeace_get_cat_bottom', 1000);
        
        add_action('tradeace_change_view', 'tradeace_tradeace_change_view', 10, 3);

        add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display');
        add_action('popup_woocommerce_after_cart', 'woocommerce_cross_sell_display');
        
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_loop_rating', 10);
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_price', 15);
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_excerpt', 20);
        
        // Deal time for Quickview product
        if (!isset($tradeace_opt['single-product-deal']) || $tradeace_opt['single-product-deal']) {
            add_action('woocommerce_single_product_lightbox_summary', 'tradeace_deal_time_quickview', 29);
        }
        
        if (!isset($tradeace_opt['disable-cart']) || !$tradeace_opt['disable-cart']) {
            add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_add_to_cart', 30);
        }
        
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_meta', 40);
        add_action('woocommerce_single_product_lightbox_summary', 'tradeace_combo_in_quickview', 31);
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_sharing', 50);
        
        add_action('tradeace_single_product_layout', 'tradeace_single_product_layout', 1);

        add_action('woocommerce_after_single_product_summary', 'tradeace_clearboth', 11);
        add_action('woocommerce_after_single_product_summary', 'tradeace_open_wrap_12_cols', 11);
        add_action('woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 11);
        add_action('woocommerce_after_single_product_summary', 'tradeace_close_wrap_12_cols', 11);
        
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        add_action('woocommerce_single_product_summary', 'tradeace_next_prev_single_product', 6);

        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15);
        
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 25);
        
        // Deal time for Single product
        if (!isset($tradeace_opt['single-product-deal']) || $tradeace_opt['single-product-deal']) {
            add_action('woocommerce_single_product_summary', 'tradeace_deal_time_single', 29);
        }
        
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 40);
        
        /**
         * Remove heading Description tab
         */
        add_filter('woocommerce_product_description_heading', '__return_false');
        
        /**
         * Add compare product
         */
        if ($yith_woocompare) {
            if (get_option('yith_woocompare_compare_button_in_product_page') == 'yes') {
                add_action('tradeace_single_buttons', 'tradeace_add_compare_in_detail', 20);
            }
            
            if (get_option('yith_woocompare_compare_button_in_products_list') == 'yes') {
                add_action('tradeace_show_buttons_loop', 'tradeace_add_compare_in_list', 50);
            }
        }
        
        /**
         * Single Product Ajax Call
         */
        add_action('woocommerce_after_single_product', 'tradeace_ajax_single_product_tag');
        
        /**
         * Add to Cart in list - Loop
         */
        add_action('tradeace_show_buttons_loop', 'tradeace_add_to_cart_in_list', 10);
        
        add_action('tradeace_show_buttons_loop', 'tradeace_add_wishlist_in_list', 20);
        if (!isset($tradeace_opt['disable-quickview']) || !$tradeace_opt['disable-quickview']) {
            add_action('tradeace_show_buttons_loop', 'tradeace_quickview_in_list', 40);
        }
        add_action('tradeace_show_buttons_loop', 'tradeace_bundle_in_list', 60, 1);
        
        /**
         * Notice in Archive Products Page | Single Product Page
         */
        add_action('woocommerce_before_main_content', 'woocommerce_output_all_notices', 10);
        
        // Tradeace ADD BUTTON BUY NOW
        add_action('woocommerce_after_add_to_cart_button', 'tradeace_add_buy_now_btn');
        
        // Tradeace Add Custom fields
        add_action('woocommerce_after_add_to_cart_button', 'tradeace_add_custom_field_detail_product', 25);
        
        // tradeace_top_sidebar_shop
        add_action('tradeace_top_sidebar_shop', 'tradeace_top_sidebar_shop', 10, 1);
        add_action('tradeace_sidebar_shop', 'tradeace_side_sidebar_shop', 10 , 1);
        
        // For Product content
        add_action('woocommerce_before_shop_loop_item_title', 'tradeace_loop_countdown');
        
        /**
         * Custom filters woocommerce_post_class
         */
        add_filter('woocommerce_post_class', 'tradeace_custom_woocommerce_post_class');
        
        add_action('tradeace_get_content_products', 'tradeace_get_content_products', 10, 1);
        add_action('woocommerce_before_shop_loop_item_title', 'tradeace_loop_product_content_btns', 15);
        add_action('woocommerce_before_shop_loop_item_title', 'tradeace_gift_featured', 15);
        add_action('woocommerce_before_shop_loop_item_title', 'tradeace_loop_product_content_thumbnail', 20);
        
        add_action('woocommerce_after_shop_loop_item', 'tradeace_content_show_in_list');
        
        /**
         * Sale flash
         */
        add_action('woocommerce_before_shop_loop_item_title', 'tradeace_add_custom_sale_flash', 10);
        add_action('woocommerce_before_single_product_summary', 'tradeace_add_custom_sale_flash', 11);
        
        add_action('woocommerce_shop_loop_item_title', 'tradeace_loop_product_cats', 5, 1);
        add_action('woocommerce_shop_loop_item_title', 'tradeace_loop_product_content_title', 10);
        add_action('woocommerce_after_shop_loop_item_title', 'tradeace_loop_product_description', 15, 1);
        
        /**
         * Add to wishlist in Single Product
         */
        add_action('tradeace_single_buttons', 'tradeace_add_wishlist_in_detail', 15);
        
        // for woo 3.3
        if (version_compare(WC()->version, '3.3.0', ">=")) {
            if (!isset($tradeace_opt['show_uncategorized']) || !$tradeace_opt['show_uncategorized']) {
                add_filter('woocommerce_product_subcategories_args', 'tradeace_hide_uncategorized');
            }
        }
        
        /**
         * Share icon in Single Product
         */
        add_action('woocommerce_share', 'tradeace_before_woocommerce_share', 5);
        add_action('woocommerce_share', 'tradeace_woocommerce_share', 10);
        add_action('woocommerce_share', 'tradeace_after_woocommerce_share', 15);
        
        /**
         * Mini Cart
         */
        add_action('woocommerce_widget_shopping_cart_total', 'tradeace_widget_shopping_cart_subtotal', 10);
        
        /**
         * Add src image large for variation
         */
        add_filter('woocommerce_available_variation', 'tradeace_src_large_image_single_product');
        
        /**
         * Add class Sub Categories
         */
        add_filter('product_cat_class', 'tradeace_add_class_sub_categories');
        
        /**
         * Filter redirect checkout buy now
         */
        add_filter('woocommerce_add_to_cart_redirect', 'tradeace_buy_now_to_checkout');
        
        /**
         * Filter Single Stock
         */
        if (!isset($tradeace_opt['enable_progess_stock']) || $tradeace_opt['enable_progess_stock']) {
            add_filter('woocommerce_get_stock_html', 'tradeace_single_stock', 10, 2);
        }
        
        /**
         * Disable redirect Search one product to single product
         */
        add_filter('woocommerce_redirect_single_search_result', '__return_false');
        
        /**
         * Custom Tabs in Single product
         */
        add_filter('woocommerce_product_tabs', 'tradeace_custom_tabs_single_product');
        
        /**
         * Support Yith WooCommerce Product Add-ons in Quick view
         */
        if (class_exists('YITH_WAPO')) {
            $yith_wapo = YITH_WAPO::instance();
            $yith_wapo_frontend = $yith_wapo->frontend;
            add_action('woocommerce_single_product_lightbox_summary', array($yith_wapo_frontend, 'check_variable_product'));
        }
        
        /**
         * Compatible with WC_Vendor plugin
         */
        if (class_exists('WCV_Vendor_Shop')) {
            if (has_action('woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9)) {
                remove_action('woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9);
                add_action('woocommerce_after_shop_loop_item_title', 'tradeace_wc_vendor_template_loop_sold_by');
            }
            
            if (has_action('woocommerce_product_meta_start', array('WCV_Vendor_Cart', 'sold_by_meta'))) {
                remove_action('woocommerce_product_meta_start', array('WCV_Vendor_Cart', 'sold_by_meta'));
                add_action('woocommerce_product_meta_start', 'tradeace_wc_vendor_sold_by_meta');
            }
        }
        
        /**
         * Compatible with Dokan plugin
         */
        if (TRADEACE_DOKAN_ACTIVED) {
            add_action('woocommerce_after_shop_loop_item_title', 'tradeace_dokan_loop_sold_by');
            
            if (version_compare(WC()->version, '3.3.0', ">=")) {
                if (!isset($tradeace_opt['show_uncategorized']) || !$tradeace_opt['show_uncategorized']) {
                    add_filter('dokan_category_widget', 'tradeace_hide_uncategorized');
                }
            }
        }
        
        /**
         * woocommerce_form_field_args
         */
        add_filter('woocommerce_form_field_args', 'tradeace_wc_form_field_args');
    }
endif;

/* ========================================================================= */
/* Functions - Add action, filter WooCommerce ============================== */
/* ========================================================================= */

/**
 * Custom Content show in list view archive page
 */
if (!function_exists('tradeace_content_show_in_list')) :
    function tradeace_content_show_in_list($show_in_list) {
        global $product, $tradeace_opt;
        
        if ($show_in_list && (!isset($tradeace_opt['tradeace_in_mobile']) || !$tradeace_opt['tradeace_in_mobile'])) {
            $availability = $product->get_availability();
            if (!empty($availability['availability'])) {
                $stock_class = $availability['class'];
                $stock_label = $availability['availability'];
                ?>
                <!-- Clone Group btns for layout List -->
                <div class="hidden-tag tradeace-list-stock-wrap">
                    <p class="tradeace-list-stock-status <?php echo esc_attr($stock_class); ?>">
                        <?php echo $stock_label; ?>
                    </p>
                </div>
                <?php
            }
        }
    }
endif;

/**
 * Custom woocommerce_post_class
 */
if (!function_exists('tradeace_custom_woocommerce_post_class')) :
    function tradeace_custom_woocommerce_post_class($classes) {
        global $tradeace_opt, $product, $tradeace_time_sale;
        
        $product_id = $product->get_id();
        
        $classes[] = 'product-item grid';
        
        /**
         * Animate class
         */
        if (!isset($tradeace_opt['tradeace_in_mobile']) || !$tradeace_opt['tradeace_in_mobile']) {
            $classes[] = 'wow fadeInUp';
        }
        
        /**
         * Hover effect products in grid
         */
        if (isset($tradeace_opt['animated_products']) && $tradeace_opt['animated_products']) {
            $classes[] = $tradeace_opt['animated_products'];
        }
        
        /**
         * Out of Stock
         */
        if ("outofstock" == $product->get_stock_status()) {
            $classes[] = 'out-of-stock';
        }
        
        /**
         * Deal class
         */
        if (!isset($tradeace_time_sale[$product_id])) {
            $tradeace_time_sale[$product_id] = false;
            if ($product->is_on_sale() && $product->get_type() != 'variable') {
                $time_from = get_post_meta($product_id, '_sale_price_dates_from', true);
                $time_to = get_post_meta($product_id, '_sale_price_dates_to', true);
                $tradeace_time_sale[$product_id] = ((int) $time_to < TRADEACE_TIME_NOW || (int) $time_from > TRADEACE_TIME_NOW) ? false : (int) $time_to;
            }
            
            $GLOBALS['tradeace_time_sale'] = $tradeace_time_sale;
        }
        
        if ($tradeace_time_sale[$product_id]) {
            $classes[] = 'product-deals';
        }
        
        return $classes;
    }
endif;

/**
 * Deal time for loop
 */
if (!function_exists('tradeace_loop_countdown')) :
    function tradeace_loop_countdown() {
        global $product, $tradeace_time_sale;
        
        $product_id = $product->get_id();
        
        /**
         * Deal class
         */
        if (!isset($tradeace_time_sale[$product_id])) {
            $tradeace_time_sale[$product_id] = false;
            if ($product->is_on_sale() && $product->get_type() != 'variable') {
                $time_from = get_post_meta($product_id, '_sale_price_dates_from', true);
                $time_to = get_post_meta($product_id, '_sale_price_dates_to', true);
                $tradeace_time_sale[$product_id] = ((int) $time_to < TRADEACE_TIME_NOW || (int) $time_from > TRADEACE_TIME_NOW) ? false : (int) $time_to;
            }
            
            $GLOBALS['tradeace_time_sale'] = $tradeace_time_sale;
        }
        
        echo $tradeace_time_sale[$product_id] ? tradeace_time_sale($tradeace_time_sale[$product_id]) : '<div class="tradeace-sc-pdeal-countdown hidden-tag"></div>';
    }
endif;

/**
 * Compatible with WC_Vendor plugin
 * 
 * sold-by in loop
 */
if (!function_exists('tradeace_wc_vendor_template_loop_sold_by')) :
    function tradeace_wc_vendor_template_loop_sold_by() {
        if (!class_exists('WCV_Vendor_Shop')) {
            return;
        }

        global $product;
        WCV_Vendor_Shop::template_loop_sold_by($product->get_id());
    }
endif;

/**
 * Compatible with DOKAN plugin
 * 
 * sold-by in loop
 */
if (!function_exists('tradeace_dokan_loop_sold_by')) :
    function tradeace_dokan_loop_sold_by() {
        if (!TRADEACE_DOKAN_ACTIVED) {
            return;
        }
        
        global $post, $tradeace_dokan_vendors;
        if (!$post) {
            return;
        }
        
        if (!isset($tradeace_dokan_vendors[$post->post_author])) {
            $author = get_user_by('id', $post->post_author);
            $store_info = dokan_get_store_info($author->ID);
            
            if (!empty($store_info['store_name'])) {
                $tradeace_dokan_vendors[$post->post_author]['name'] = $store_info['store_name'];
                $tradeace_dokan_vendors[$post->post_author]['url'] = dokan_get_store_url($author->ID);
            } else {
                $tradeace_dokan_vendors[$post->post_author] = null;
            }
            
            $GLOBALS['tradeace_dokan_vendors'] = $tradeace_dokan_vendors;
        }
        
        if (isset($tradeace_dokan_vendors[$post->post_author]) && $tradeace_dokan_vendors[$post->post_author]) {
            echo '<small class="tradeace-dokan-sold_by_in_loop">';
                echo esc_html__('Sold By: ', 'tradeace-theme');
                echo '<a ' .
                'href="' . esc_url($tradeace_dokan_vendors[$post->post_author]['url']) . '" ' .
                'class="tradeace-dokan-sold_by_href" ' .
                'title="' . esc_attr($tradeace_dokan_vendors[$post->post_author]['name']) . '">';
                    echo $tradeace_dokan_vendors[$post->post_author]['name'];
                echo '</a>';
            echo '</small>';
        }
    }
endif;

/**
 * Compatible with WC_Vendor plugin
 * 
 * Meta in single product
 */
if (!function_exists('tradeace_wc_vendor_sold_by_meta')) :
    function tradeace_wc_vendor_sold_by_meta() {
        if (!class_exists('WCV_Vendor_Cart')) {
            return;
        }
        
        echo '<span class="tradeace-wc-vendor-single-meta">';
        WCV_Vendor_Cart::sold_by_meta();
        echo '</span>';
    }
endif;

/**
 * Single Product stock
 */
if (!function_exists('tradeace_single_stock')) :
    function tradeace_single_stock($html, $product) {
        if ($html == '' || !$product) {
            return $html;
        }
        
        $productId = $product->get_id();
        $type = $product->get_type();
        $stock = get_post_meta($productId, '_stock', true);
        
        if (!$stock && $type == 'variation') {
            global $product;
            if ($product) {
                $productId = $product->get_id();
                $stock = get_post_meta($productId, '_stock', true);
            }
        }
        
        if (!$stock) {
            return $html;
        }
        
        $total_sales = get_post_meta($productId, 'total_sales', true);
        $stock_sold = $total_sales ? round($total_sales) : 0;
        $stock_available = $stock ? round($stock) : 0;
        $percentage = $stock_available > 0 ? round($stock_sold/($stock_available + $stock_sold) * 100) : 0;
        
        $new_html = '<div class="stock tradeace-single-product-stock">';
        $new_html .= '<span class="stock-sold">';
        $new_html .= sprintf(esc_html__('HURRY! ONLY %s LEFT IN STOCK.', 'tradeace-theme'), '<b>' . $stock_available . '</b>');
        $new_html .= '</span>';
        $new_html .= '<div class="tradeace-product-stock-progress">';
        $new_html .= '<span class="tradeace-product-stock-progress-bar" style="width:' . $percentage . '%"></span>';
        $new_html .= '</div>';
        $new_html .= '</div>';
        
        return $new_html;
    }
endif;

/**
 * Buy Now button
 */
if (!function_exists('tradeace_add_buy_now_btn')) :
    function tradeace_add_buy_now_btn() {
        global $tradeace_opt, $product;
        
        if (
            (isset($tradeace_opt['disable-cart']) && $tradeace_opt['disable-cart']) ||
            (isset($tradeace_opt['enable_buy_now']) && !$tradeace_opt['enable_buy_now']) ||
            'external' == $product->get_type() // Disable with External Product
        ) {
            return;
        }
        
        $class = 'tradeace-buy-now';
        if (isset($tradeace_opt['enable_fixed_buy_now_desktop']) && $tradeace_opt['enable_fixed_buy_now_desktop']) {
            $class .= ' has-sticky-in-desktop';
        }
        
        echo '<input type="hidden" name="tradeace_buy_now" value="0" />';
        echo '<button class="' . $class . '">' . esc_html__('BUY NOW', 'tradeace-theme') . '</button>';
    }
endif;

/**
 * Redirect to Checkout page after click buy now
 */
if (!function_exists('tradeace_buy_now_to_checkout')) :
    function tradeace_buy_now_to_checkout($redirect_url) {
        if (isset($_REQUEST['tradeace_buy_now']) && $_REQUEST['tradeace_buy_now'] === '1') {
            $redirect_url = wc_get_checkout_url();
        }

        return $redirect_url;
    }
endif;

/**
 * Add class Sub Categories
 */
if (!function_exists('tradeace_add_class_sub_categories')) :
    function tradeace_add_class_sub_categories($classes) {
        $classes[] = 'product-warp-item';
        
        return $classes;
    }
endif;

/**
 * Deal time in Single product page
 */
if (!function_exists('tradeace_deal_time_single')) :
    function tradeace_deal_time_single() {
        global $product;
        
        if ($product->get_stock_status() == 'outofstock') {
            return;
        }
        
        $product_type = $product->get_type();
        
        // For variation of Variation product
        if ($product_type == 'variable') {
            echo '<div class="tradeace-detail-product-deal-countdown tradeace-product-variation-countdown"></div>';
            
            return;
        }
        
        if ($product_type != 'simple') {
            return;
        }
        
        $productId = $product->get_id();

        $time_from = get_post_meta($productId, '_sale_price_dates_from', true);
        $time_to = get_post_meta($productId, '_sale_price_dates_to', true);
        $time_sale = ((int) $time_to < TRADEACE_TIME_NOW || (int) $time_from > TRADEACE_TIME_NOW) ? false : (int) $time_to;
        if (!$time_sale) {
            return;
        }
        
        echo '<div class="tradeace-detail-product-deal-countdown">';
        echo tradeace_time_sale($time_sale);
        echo '</div>';
    }
endif;

/**
 * Deal time in Quick view product
 */
if (!function_exists('tradeace_deal_time_quickview')) :
    function tradeace_deal_time_quickview() {
        global $product;
        
        if ($product->get_stock_status() == 'outofstock') {
            return;
        }
        
        $product_type = $product->get_type();
        
        // For variation of Variation product
        if ($product_type == 'variable') {
            echo '<div class="tradeace-quickview-product-deal-countdown tradeace-product-variation-countdown"></div>';
            return;
        }
        
        if ($product_type != 'simple') {
            return;
        }
        
        $productId = $product->get_id();

        $time_from = get_post_meta($productId, '_sale_price_dates_from', true);
        $time_to = get_post_meta($productId, '_sale_price_dates_to', true);
        $time_sale = ((int) $time_to < TRADEACE_TIME_NOW || (int) $time_from > TRADEACE_TIME_NOW) ? false : (int) $time_to;
        if (!$time_sale) {
            return;
        }
        
        echo '<div class="tradeace-quickview-product-deal-countdown">';
        echo tradeace_time_sale($time_sale);
        echo '</div>';
    }
endif;

/**
 * Main Image of Variation
 */
if (!function_exists('tradeace_src_large_image_single_product')) :
    function tradeace_src_large_image_single_product($variation) {
        if (!isset($variation['image_single_page'])) {
            $image = wp_get_attachment_image_src($variation['image_id'], 'shop_single');
            $variation['image_single_page'] = isset($image[0]) ? $image[0] : '';
        }
        
        return $variation;
    }
endif;

/**
 * Results count in archive page in top
 */
if (!function_exists('tradeace_result_count')) :
    function tradeace_result_count() {
        if (! wc_get_loop_prop('is_paginated') || !woocommerce_products_will_display()) {
            return;
        }
        
        $total = wc_get_loop_prop('total');
        $per_page = wc_get_loop_prop('per_page');
        
        echo '<p class="woocommerce-result-count">';
        if ( $total <= $per_page || -1 === $per_page ) {
            printf(_n('Showing the single result', 'Showing all %d results', $total, 'tradeace-theme'), $total);
	} else {
            $current = wc_get_loop_prop('current_page');
            $showed = $per_page * $current;
            if ($showed > $total) {
                $showed = $total;
            }
            
            printf(_n('Showing the single result', 'Showing %d results', $total, 'tradeace-theme' ), $showed);
	}
        echo '</p>';
    }
endif;

/**
 * Get Top Content category products page
 */
if (!function_exists('tradeace_get_cat_top')):
    function tradeace_get_cat_top() {
        global $wp_query, $tradeace_opt;
        
        $catId = null;
        $tradeace_cat_obj = $wp_query->get_queried_object();
        if (isset($tradeace_cat_obj->term_id) && isset($tradeace_cat_obj->taxonomy)) {
            $catId = (int) $tradeace_cat_obj->term_id;
        }
        
        $content = '<div class="tradeace-cat-header">';
        $do_content = '';
        
        if ((int) $catId > 0) {
            $block = get_term_meta($catId, 'cat_header', true);
            
            if ($block === '-1') {
                return;
            }
            
            if ($block) {
                $do_content = tradeace_get_block($block);
            }
        }

        if (trim($do_content) === '') {
            if (isset($tradeace_opt['cat_header_content']) && $tradeace_opt['cat_header_content'] != '') {
                $do_content = tradeace_get_block($tradeace_opt['cat_header_content']);
            }
        }

        if (trim($do_content) === '') {
            return;
        }

        $content .= $do_content . '</div>';

        echo $content;
    }
endif;

/**
 * Get Bottom Content category products page
 */
if (!function_exists('tradeace_get_cat_bottom')):
    function tradeace_get_cat_bottom() {
        global $wp_query, $tradeace_opt;
        
        $catId = null;
        $tradeace_cat_obj = $wp_query->get_queried_object();
        if (isset($tradeace_cat_obj->term_id) && isset($tradeace_cat_obj->taxonomy)) {
            $catId = (int) $tradeace_cat_obj->term_id;
        }
        
        $content = '<div class="tradeace-cat-footer padding-top-20 padding-bottom-50">';
        $do_content = '';
        
        if ((int) $catId > 0) {
            $block = get_term_meta($catId, 'cat_footer_content', true);
            
            if ($block === '-1') {
                return;
            }
            
            if ($block) {
                $do_content = tradeace_get_block($block);
            }
        }

        if (trim($do_content) === '') {
            if (isset($tradeace_opt['cat_footer_content']) && $tradeace_opt['cat_footer_content'] != '') {
                $do_content = tradeace_get_block($tradeace_opt['cat_footer_content']);
            }
        }

        if (trim($do_content) === '') {
            return;
        }

        $content .= $do_content . '</div>';

        echo $content;
    }
endif;

/**
 * Tradeace childs category in Shop Top bar
 */
if (!function_exists('tradeace_get_childs_category')):
    function tradeace_get_childs_category($term = null, $instance = array()) {
        $content = '';
        
        if (TRADEACE_WOO_ACTIVED){
            global $wp_query;
            
            $term = $term == null ? $wp_query->get_queried_object() : $term;
            $parent_id = is_numeric($term) ? $term : (isset($term->term_id) ? $term->term_id : 0);
            
            $tradeace_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                'taxonomy' => 'product_cat',
                'parent' => $parent_id,
                'hierarchical' => true,
                'hide_empty' => false,
                'orderby' => 'name'
            )));
            
            if (!$tradeace_terms) {
                $term_root = get_ancestors($parent_id, 'product_cat');
                $term_parent = isset($term_root[0]) ? $term_root[0] : 0;
                $tradeace_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                    'taxonomy' => 'product_cat',
                    'parent' => $term_parent,
                    'hierarchical' => true,
                    'hide_empty' => false,
                    'orderby' => 'name'
                )));
            }
            
            if ($tradeace_terms) {
                $show = isset($instance['show_items']) ? (int) $instance['show_items'] : 0;
                $content .= '<ul class="tradeace-children-cat product-categories tradeace-product-child-cat-top-sidebar">';
                $items = 0;
                foreach ($tradeace_terms as $v) {
                    $class_active = $parent_id == $v->term_id ? ' tradeace-active' : '';
                    $class_li = ($show && $items >= $show) ? ' tradeace-show-less' : '';
                    
                    $icon = '';
                    if (isset($instance['cat_' . $v->slug]) && trim($instance['cat_' . $v->slug]) != '') {
                        $icon = '<i class="' . $instance['cat_' . $v->slug] . '"></i>';
                        $icon .= '&nbsp;&nbsp;';
                    }
                    
                    $content .= '<li class="cat-item cat-item-' . esc_attr($v->term_id) . ' cat-item-accessories root-item' . $class_li . '">';
                    $content .= '<a href="' . esc_url(get_term_link($v)) . '" data-id="' . esc_attr($v->term_id) . '" class="tradeace-filter-by-cat' . $class_active . '" title="' . esc_attr($v->name) . '" data-taxonomy="product_cat">';
                    $content .= '<div class="tradeace-cat-warp">';
                    $content .= '<h5 class="tradeace-cat-title">';
                    $content .= $icon . esc_attr($v->name);
                    $content .= '</h5>';
                    $content .= '</div>';
                    $content .= '</a>';
                    $content .= '</li>';
                    $items++;
                }
                
                if ($show && ($items > $show)) {
                    $content .= '<li class="tradeace_show_manual"><a data-show="1" class="tradeace-show" href="javascript:void(0);" data-text="' . esc_attr__('- Show less', 'tradeace-theme') . '" rel="nofollow">' . esc_html__('+ Show more', 'tradeace-theme') . '</a></li>';
                }
                
                $content .= '</ul>';
            }
        }
        
        echo $content;
    }
endif;

/**
 * Add action archive-product get content product.
 */
if (!function_exists('tradeace_get_content_products')) :
    function tradeace_get_content_products($tradeace_sidebar = 'top') {
        $file = TRADEACE_CHILD_PATH . '/includes/tradeace-get-content-products.php';
        include is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-get-content-products.php';
    }
endif;

/**
 * Next - Prev Single Product
 */
if (!function_exists('tradeace_next_prev_single_product')) :
    function tradeace_next_prev_single_product() {
        echo '<div class="products-arrow">';
        do_action('next_prev_product');
        echo '</div>';
    }
endif;

/*
 * Wishlist in list
 */
if (!function_exists('tradeace_add_wishlist_in_list')) :
    function tradeace_add_wishlist_in_list() {
        if (TRADEACE_WISHLIST_IN_LIST) {
            tradeace_add_wishlist_button('left');
        }
    }
endif;

/*
 * Wishlist in single
 */
if (!function_exists('tradeace_add_wishlist_in_detail')) :
    function tradeace_add_wishlist_in_detail() {
        tradeace_add_wishlist_button('right');
    }
endif;

/**
 * Quick view in list
 */
if (!function_exists('tradeace_quickview_in_list')) :
    function tradeace_quickview_in_list($echo = true) {
        global $product;
        $type = $product->get_type();
        
        /**
         * Apply Filters Icon
         */
        $icon = apply_filters('tradeace_icon_quickview', '<i class="tradeace-icon pe-7s-look"></i>');
        
        $quickview = '<a ' .
            'href="javascript:void(0);" ' .
            'class="quick-view btn-link quick-view-icon tradeace-tip tradeace-tip-left" ' .
            'data-prod="' . absint($product->get_id()) . '" ' .
            'data-icon-text="' . ($type !== 'woosb' ? esc_attr__('Quick View', 'tradeace-theme') : esc_attr__('View', 'tradeace-theme')) . '" ' .
            'title="' . ($type !== 'woosb' ? esc_attr__('Quick View', 'tradeace-theme') : esc_attr__('View', 'tradeace-theme')) . '" ' .
            'data-product_type="' . esc_attr($type) . '" ' .
            'data-href="' . get_the_permalink() . '" rel="nofollow">' .
            $icon .
        '</a>';
        
        if (!$echo) {
            return $quickview;
        }
        
        echo $quickview;
    }
endif;

/**
 * add to cart in list
 */
if (!function_exists('tradeace_add_to_cart_in_list')) :
    function tradeace_add_to_cart_in_list() {
        global $tradeace_opt;
        
        if (!isset($tradeace_opt['loop_add_to_cart']) || $tradeace_opt['loop_add_to_cart']) {
            tradeace_add_to_cart_btn();
        }
    }
endif;

/**
 * tradeace gift icon in list
 */
if (!function_exists('tradeace_bundle_in_list')) :
    function tradeace_bundle_in_list($combo_show_type) {
        global $product;
        if (!defined('YITH_WCPB') || $product->get_type() != TRADEACE_COMBO_TYPE) {
            return;
        }
        ?>
        <a href="javascript:void(0);" class="btn-combo-link btn-link gift-icon tradeace-tip tradeace-tip-left" data-prod="<?php echo (int) $product->get_id(); ?>" data-tip="<?php esc_attr_e('Promotion Gifts', 'tradeace-theme'); ?>" title="<?php esc_attr_e('Promotion Gifts', 'tradeace-theme'); ?>" data-icon-text="<?php esc_attr_e('Promotion Gifts', 'tradeace-theme'); ?>" data-show_type="<?php echo esc_attr($combo_show_type); ?>" rel="nofollow">
            <i class="tradeace-icon pe-7s-gift"></i>
        </a>
        <?php
    }
endif;

/**
 * Tradeace Gift icon Featured
 */
if (!function_exists('tradeace_gift_featured')) :
    function tradeace_gift_featured() {
        global $product, $tradeace_opt;
        
        if (isset($tradeace_opt['enable_gift_featured']) && !$tradeace_opt['enable_gift_featured']) {
            return;
        }
        
        $product_type = $product->get_type();
        if (!defined('YITH_WCPB') || $product_type != TRADEACE_COMBO_TYPE) {
            return;
        }
        
        echo 
        '<div class="tradeace-gift-featured-wrap">' .
            '<div class="tradeace-gift-featured">' .
                '<div class="gift-icon">' .
                    '<a href="javascript:void(0);" class="tradeace-gift-featured-event tradeace-transition" title="' . esc_attr__('View the promotion gifts', 'tradeace-theme') . '" rel="nofollow">' .
                        '<span class="pe-icon pe-7s-gift"></span>' .
                        '<span class="hidden-tag tradeace-icon-text">' . 
                            esc_html__('Promotion Gifts', 'tradeace-theme') . 
                        '</span>' .
                    '</a>' .
                '</div>' .
            '</div>' .
        '</div>';
    }
endif;

/**
 * tradeace add compare in list
 */
if (!function_exists('tradeace_add_compare_in_list')) :
    function tradeace_add_compare_in_list() {
        global $product, $tradeace_opt;
        $productId = $product->get_id();
        
        $tradeace_compare = (!isset($tradeace_opt['tradeace-product-compare']) || $tradeace_opt['tradeace-product-compare']) ? true : false;
        
        $class_btn = 'btn-compare btn-link compare-icon tradeace-tip tradeace-tip-left';
        $class_btn .= $tradeace_compare ? ' tradeace-compare' : '';
        
        /**
         * Apply Filters Icon
         */
        $icon = apply_filters('tradeace_icon_compare', '<i class="tradeace-icon icon-tradeace-refresh"></i>');
        ?>
        <a href="javascript:void(0);" class="<?php echo esc_attr($class_btn); ?>" data-prod="<?php echo (int) $productId; ?>" data-icon-text="<?php esc_attr_e('Compare', 'tradeace-theme'); ?>" title="<?php esc_attr_e('Compare', 'tradeace-theme'); ?>" rel="nofollow">
            <?php echo $icon; ?>
        </a>
        
        <?php if (!$tradeace_compare) : ?>
            <div class="add-to-link woocommerce-compare-button hidden-tag">
                <?php echo do_shortcode('[yith_compare_button]'); ?>
            </div>
        <?php endif;
    }
endif;

/**
 * tradeace add compare in single
 */
if (!function_exists('tradeace_add_compare_in_detail')) :
    function tradeace_add_compare_in_detail() {
        global $product, $tradeace_opt;
        $productId = $product->get_id();
        
        $tradeace_compare = (!isset($tradeace_opt['tradeace-product-compare']) || $tradeace_opt['tradeace-product-compare']) ? true : false;
        
        $class_btn = 'btn-compare btn-link compare-icon tradeace-tip tradeace-tip-right';
        $class_btn .= $tradeace_compare ? ' tradeace-compare' : '';
        
        /**
         * Apply Filters Icon
         */
        $icon = apply_filters('tradeace_icon_compare_in_detail', '<span class="tradeace-icon icon-tradeace-compare-2"></span>');
        ?>
        <a href="javascript:void(0);" class="<?php echo esc_attr($class_btn); ?>" data-prod="<?php echo (int) $productId; ?>" data-tip="<?php esc_attr_e('Compare', 'tradeace-theme'); ?>" title="<?php esc_attr_e('Compare', 'tradeace-theme'); ?>" rel="nofollow">
            <?php echo $icon; ?>
            <span class="tradeace-icon-text"><?php esc_html_e('Add to Compare', 'tradeace-theme'); ?></span>
        </a>

        <?php if (!$tradeace_compare) : ?>
            <div class="add-to-link woocommerce-compare-button hidden-tag">
                <?php echo do_shortcode('[yith_compare_button]'); ?>
            </div>
        <?php endif; ?>
    <?php
    }
endif;

/**
 * custom fields single product
 */
if (!function_exists('tradeace_add_custom_field_detail_product')) :
    function tradeace_add_custom_field_detail_product() {
        global $product, $product_lightbox;
        if ($product_lightbox) {
            $product = $product_lightbox;
        }
        
        $product_type = $product->get_type();
        // 'woosb' Bundle product
        if (in_array($product_type, array('external', 'woosb')) || (!defined('YITH_WCPB') && $product_type == TRADEACE_COMBO_TYPE)) {
            return;
        }
        
        global $tradeace_opt;

        $tradeace_btn_ajax_value = '0';
        if (
            'yes' !== get_option('woocommerce_cart_redirect_after_add') &&
            'yes' === get_option('woocommerce_enable_ajax_add_to_cart') &&
            (!isset($tradeace_opt['enable_ajax_addtocart']) || $tradeace_opt['enable_ajax_addtocart'] == '1')
        ) {
            $tradeace_btn_ajax_value = '1';
        }
        
        echo '<div class="tradeace-custom-fields hidden-tag">';
        echo '<input type="hidden" name="tradeace-enable-addtocart-ajax" value="' . $tradeace_btn_ajax_value . '" />';
        echo '<input type="hidden" name="data-product_id" value="' . esc_attr($product->get_id()) . '" />';
        echo '<input type="hidden" name="data-type" value="' . esc_attr($product_type) . '" />';
        
        if (TRADEACE_WISHLIST_ENABLE) {
            $tradeace_has_wishlist = (isset($_REQUEST['tradeace_wishlist']) && $_REQUEST['tradeace_wishlist'] == '1') ? '1' : '0';
            echo '<input type="hidden" name="data-from_wishlist" value="' . esc_attr($tradeace_has_wishlist) . '" />';
        }
        
        echo '</div>';
    }
endif;

/**
 * Images in content product
 */
if (!function_exists('tradeace_loop_product_content_thumbnail')) :
    function tradeace_loop_product_content_thumbnail() {
        global $tradeace_opt, $product;
        
        /**
         * Hover effect products in grid
         */
        $tradeace_animated_products = isset($tradeace_opt['animated_products']) && $tradeace_opt['animated_products'] ? $tradeace_opt['animated_products'] : '';
        
        $tradeace_link = $product->get_permalink(); // permalink
        $tradeace_title = $product->get_name(); // Title
        $attachment_ids = false;
        $sizeLoad = 'shop_catalog';
        
        $backImageMobile = isset($tradeace_opt['mobile_back_image']) && $tradeace_opt['mobile_back_image'] ? true : false;
        
        /**
         * Mobile detect
         */
        if (
            !in_array($tradeace_animated_products, array('', 'hover-zoom', 'hover-to-top')) && 
            (!isset($tradeace_opt['tradeace_in_mobile']) || !$tradeace_opt['tradeace_in_mobile'] || ($tradeace_opt['tradeace_in_mobile'] && $backImageMobile))
        ) {
            $attachment_ids = $product->get_gallery_image_ids();
        }
        
        $image_size = apply_filters('single_product_archive_thumbnail_size', $sizeLoad);
        $main_img = $product->get_image($image_size);
        
        $class_wrap = 'product-img';
        if (!$attachment_ids && !in_array($tradeace_animated_products, array('hover-zoom', 'hover-to-top'))) {
            $class_wrap .= ' tradeace-no-effect';
        }
        
        $class_wrap .= (isset($tradeace_opt['single_product_ajax']) && $tradeace_opt['single_product_ajax']) ? ' tradeace-ajax-call' : '';
        ?>
        <a class="<?php echo esc_attr($class_wrap); ?>" href="<?php echo esc_url($tradeace_link); ?>" title="<?php echo esc_attr($tradeace_title); ?>">
            <div class="main-img">
                <?php echo $main_img; ?>
            </div>

            <?php
            /**
             * Back image
             */
            if ($attachment_ids) :
                foreach ($attachment_ids as $attachment_id) :
                    printf('<div class="back-img back">%s</div>', wp_get_attachment_image($attachment_id, $image_size));
                    break;
                endforeach;
            endif; ?>
        </a>
    <?php
    }
endif;

/**
 * Ajax Single Product Page
 */
if (!function_exists('tradeace_ajax_single_product_tag')) :
    function tradeace_ajax_single_product_tag() {
        global $tradeace_opt;
        
        echo (isset($tradeace_opt['single_product_ajax']) && $tradeace_opt['single_product_ajax']) ? '<div id="tradeace-single-product-ajax" class="hidden-tag"></div>' : '';
    }
endif;

/**
 * Buttons in content product
 */
if (!function_exists('tradeace_loop_product_content_btns')) :
    function tradeace_loop_product_content_btns() {
        echo '<div class="tradeace-product-grid tradeace-group-btns tradeace-btns-product-item">';
        echo tradeace_product_group_button('popup');
        echo '</div>';
    }
endif;

/**
 * Categories in content product
 */
if (!function_exists('tradeace_loop_product_cats')) :
    function tradeace_loop_product_cats($cat_info = true) {
        if (!$cat_info) {
            return;
        }
        
        global $product;
        
        echo '<div class="tradeace-list-category hidden-tag">';
        echo wc_get_product_category_list($product->get_id(), ', ');
        echo '</div>';
    }
endif;

/**
 * Title in content product
 */
if (!function_exists('tradeace_loop_product_content_title')) :
    function tradeace_loop_product_content_title() {
        global $product, $tradeace_opt;
        
        $tradeace_link = $product->get_permalink(); // permalink
        $tradeace_title = $product->get_name(); // Title
        $class_title = 'name';
        $class_title .= (!isset($tradeace_opt['cutting_product_name']) || $tradeace_opt['cutting_product_name']) ? ' tradeace-show-one-line' : '';
        
        $class_title .= (isset($tradeace_opt['single_product_ajax']) && $tradeace_opt['single_product_ajax']) ? ' tradeace-ajax-call' : '';
        ?>
        
        <a class="<?php echo esc_attr($class_title); ?>" href="<?php echo esc_url($tradeace_link); ?>" title="<?php echo esc_attr($tradeace_title); ?>">
            <?php echo $tradeace_title; ?>
        </a>
    <?php
    }
endif;

/**
 * Description in content product
 */
if (!function_exists('tradeace_loop_product_description')) :
    function tradeace_loop_product_description($desc_info = true) {
        if (!$desc_info) {
            return;
        }
        
        global $post;
        
        $short_desc = apply_filters('woocommerce_short_description', $post->post_excerpt);
        
        echo $short_desc ? '<div class="info_main product-des-wrap product-des">' . $short_desc . '</div>' : '';
    }
endif;

/**
 * tradeace product budles in quickview
 */
if (!function_exists('tradeace_combo_in_quickview')) :
    function tradeace_combo_in_quickview() {
        global $woocommerce, $tradeace_opt, $product;

        if (!$woocommerce || !$product || $product->get_type() != TRADEACE_COMBO_TYPE || !($combo = $product->get_bundled_items())) {
            echo '';
        }
        else {
            $file = TRADEACE_CHILD_PATH . '/includes/tradeace-combo-products-quickview.php';
            $file = is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-combo-products-quickview.php';

            include $file;
        }
    }
endif;

/**
 * Top side bar shop
 */
if (!function_exists('tradeace_top_sidebar_shop')) :
    function tradeace_top_sidebar_shop($type = '') {
        $type_top = !$type ? '1' : $type;
        $class = 'tradeace-relative hidden-tag';
        $class .= $type_top == '1' ? ' large-12 columns tradeace-top-sidebar' : ' tradeace-top-sidebar-' . $type_top;
        
        $attributes = '';
        if ($type_top == '2') {
            $attributes .= ' data-columns="' . apply_filters('tradeace_top_bar_2_cols', '4') . '"';
            $attributes .= ' data-columns-small="' . apply_filters('tradeace_top_bar_2_cols_small', '2') . '"';
            $attributes .= ' data-columns-tablet="' . apply_filters('tradeace_top_bar_2_cols_medium', '3') . '"';
            $attributes .= ' data-switch-tablet="' . tradeace_switch_tablet() . '"';
            $attributes .= ' data-switch-desktop="' . tradeace_switch_desktop() . '"';
        }
        
        $sidebar_run = 'shop-sidebar';
        
        if (is_tax('product_cat')) {
            global $wp_query;
            $query_obj = $wp_query->get_queried_object();
            $sidebar_cats = get_option('tradeace_sidebars_cats');
            
            if (isset($sidebar_cats[$query_obj->slug])) {
                $sidebar_run = $query_obj->slug;
            }
            else {
                global $tradeace_root_term_id;
                
                if (!$tradeace_root_term_id) {
                    $ancestors = get_ancestors($query_obj->term_id, 'product_cat');
                    $tradeace_root_term_id = $ancestors ? end($ancestors) : 0;
                }
                
                if ($tradeace_root_term_id) {
                    $GLOBALS['tradeace_root_term_id'] = $tradeace_root_term_id;
                    $rootTerm = get_term_by('term_id', $tradeace_root_term_id, 'product_cat');
                    if ($rootTerm && isset($sidebar_cats[$rootTerm->slug])) {
                        $sidebar_run = $rootTerm->slug;
                    }
                }
            }
        } ?>

        <div class="<?php echo esc_attr($class); ?>"<?php echo $attributes; ?>>
            <?php if ($type_top == '1') : ?>
                <span class="tradeace-close-sidebar-wrap hidden-tag">
                    <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'tradeace-theme'); ?>" class="hidden-tag tradeace-close-sidebar" rel="nofollow"><?php echo esc_html__('Close', 'tradeace-theme'); ?></a>
                </span>
            <?php endif; ?>
            <?php
            if (is_active_sidebar($sidebar_run)) :
                dynamic_sidebar($sidebar_run);
            endif;
            ?>
        </div>
    <?php
    }
endif;

/**
 * Side bar shop
 */
if (!function_exists('tradeace_side_sidebar_shop')) :
    function tradeace_side_sidebar_shop($tradeace_sidebar = 'left') {
        $sidebar_run = 'shop-sidebar';
        if (is_tax('product_cat')) {
            global $wp_query;
            $query_obj = $wp_query->get_queried_object();
            $sidebar_cats = get_option('tradeace_sidebars_cats');
            
            if (isset($sidebar_cats[$query_obj->slug])) {
                $sidebar_run = $query_obj->slug;
            }
            
            else {
                global $tradeace_root_term_id;
                
                if (!$tradeace_root_term_id) {
                    $ancestors = get_ancestors($query_obj->term_id, 'product_cat');
                    $tradeace_root_term_id = $ancestors ? end($ancestors) : 0;
                }
                
                if ($tradeace_root_term_id) {
                    $GLOBALS['tradeace_root_term_id'] = $tradeace_root_term_id;
                    $rootTerm = get_term_by('term_id', $tradeace_root_term_id, 'product_cat');
                    if ($rootTerm && isset($sidebar_cats[$rootTerm->slug])) {
                        $sidebar_run = $rootTerm->slug;
                    }
                }
            }
        }
        
        switch ($tradeace_sidebar) :
            case 'right' :
                $class = 'tradeace-side-sidebar tradeace-sidebar-right';
                break;
            
            case 'left-classic' :
                $class = 'large-3 left columns col-sidebar';
                break;
            
            case 'right-classic' :
                $class = 'large-3 right columns col-sidebar';
                break;
            
            case 'left' :
            default:
                $class = 'tradeace-side-sidebar tradeace-sidebar-left';
                break;
        endswitch;
        ?>
        
        <div class="<?php echo esc_attr($class); ?>">
            <?php if (is_active_sidebar($sidebar_run)) : ?>
                <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'tradeace-theme'); ?>" class="hidden-tag tradeace-close-sidebar" rel="nofollow">
                    <?php echo esc_html__('Close', 'tradeace-theme'); ?>
                </a>
                <div class="tradeace-sidebar-off-canvas">
                    <?php dynamic_sidebar($sidebar_run); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php
    }
endif;

/**
 * Sale flash | Badges
 */
if (!function_exists('tradeace_add_custom_sale_flash')) :
    function tradeace_add_custom_sale_flash() {
        global $tradeace_opt, $product;
        
        $badges = '';
        
        /**
         * Featured
         */
        if (isset($tradeace_opt['featured_badge']) && $tradeace_opt['featured_badge'] && $product->is_featured()):
            $badges .= '<span class="badge featured-label">' . esc_html__('Featured', 'tradeace-theme') . '</span>';
        endif;

        /**
         * On Sale Badge
         */
        if ($product->is_on_sale()) :
            global $post;
            
            /**
             * Sale
             */
            $product_type = $product->get_type();
            $badges_sale = '';
            if ($product_type == 'variable') :
                $badges_sale = '<span class="badge sale-label sale-variable">' . esc_html__('Sale', 'tradeace-theme') . '</span>';
                
            else :
                $maximumper = 0;
                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();
                if (is_numeric($sale_price)) :
                    $percentage = $regular_price ? round(((($regular_price - $sale_price) / $regular_price) * 100), 0) : 0;
                    if ($percentage > $maximumper) :
                        $maximumper = $percentage;
                    endif;
                    
                    $badges_sale = '<span class="badge sale-label">' . sprintf(esc_html__('&#45;%s&#37;', 'tradeace-theme'), $maximumper) . '</span>';
                endif;
            endif;
            
            /**
             * Hook onsale WooCommerce
             */
            $badges .= apply_filters('woocommerce_sale_flash', $badges_sale, $post, $product);
            
            /**
             * Style show with Deal product
             */
            $badges .= '<span class="badge deal-label">' . esc_html__('Limited', 'tradeace-theme') . '</span>';
        endif;
        
        /**
         * Out of stock
         */
        $stock_status = $product->get_stock_status();
        if ($stock_status == "outofstock"):
            $badges_outofstock = '<span class="badge out-of-stock-label">' . esc_html__('Sold Out', 'tradeace-theme') . '</span>';
            $badges .= apply_filters('tradeace_badge_outofstock', $badges_outofstock);
        endif;
        
        $badges_content = apply_filters('tradeace_badges', $badges);
        
        echo ('' !== $badges_content) ? '<div class="tradeace-badges-wrap">' . $badges_content . '</div>' : '';
    }
endif;

/**
 * Change View
 */
if (!function_exists('tradeace_tradeace_change_view')) :
    function tradeace_tradeace_change_view($tradeace_change_view = true, $typeShow = 'grid-4', $tradeace_sidebar = 'no') {
        global $tradeace_opt;
        
        if (!$tradeace_change_view) :
            return;
        endif;
        
        $classic = in_array($tradeace_sidebar, array('left-classic', 'right-classic', 'top-push-cat'));
        echo ($classic) ? '<input type="hidden" name="tradeace-data-sidebar" value="' . esc_attr($tradeace_sidebar) . '" />' : '';
        $col_2 = isset($tradeace_opt['option_2_cols']) && $tradeace_opt['option_2_cols'] ? true : false;
        $col_6 = isset($tradeace_opt['option_6_cols']) && $tradeace_opt['option_6_cols'] ? true : false;
        $class_wrap = 'filter-tabs tradeace-change-view';
        $number_view = $col_2 || $col_6 ? true : false;
        $class_wrap .= $number_view ? ' tradeace-show-number' : '';
        
        $list_view = isset($tradeace_opt['products_layout_style']) && $tradeace_opt['products_layout_style'] == 'masonry-isotope' ? false : true;
        ?>
        <ul class="<?php echo $class_wrap; ?>">
            <?php if ($number_view) : ?>
                <li class="tradeace-label-change-view">
                    <span class="tradeace-text-number hidden-tag tradeace-bold-700">
                        <?php echo esc_html__('See', 'tradeace-theme'); ?>
                    </span>
                </li>
            <?php endif; ?>
            <?php if (isset($tradeace_opt['option_6_cols']) && $tradeace_opt['option_6_cols']) : ?>
                <li class="tradeace-change-layout productGrid grid-6<?php echo ($typeShow == 'grid-6') ? ' active' : ''; ?>" data-columns="6">
                    <span class="tradeace-text-number hidden-tag">
                        <?php echo esc_html__('6', 'tradeace-theme'); ?>
                    </span>
                </li>
            <?php endif; ?>
            
            <li class="tradeace-change-layout productGrid grid-5<?php echo ($typeShow == 'grid-5') ? ' active' : ''; ?>" data-columns="5">
                <?php if ($number_view) : ?>
                    <span class="tradeace-text-number hidden-tag">
                        <?php echo esc_html__('5', 'tradeace-theme'); ?>
                    </span>
                <?php endif; ?>
                
                <i class="icon-tradeace-5column"></i>
            </li>
            
            <li class="tradeace-change-layout productGrid grid-4<?php echo ($typeShow == 'grid-4') ? ' active' : ''; ?>" data-columns="4">
                <?php if ($number_view) : ?>
                    <span class="tradeace-text-number hidden-tag">
                        <?php echo esc_html__('4', 'tradeace-theme'); ?>
                    </span>
                <?php endif; ?>
                
                <i class="icon-tradeace-4column"></i>
            </li>
            
            <li class="tradeace-change-layout productGrid grid-3<?php echo ($typeShow == 'grid-3') ? ' active' : ''; ?>" data-columns="3">
                <?php if ($number_view) : ?>
                    <span class="tradeace-text-number hidden-tag">
                        <?php echo esc_html__('3', 'tradeace-theme'); ?>
                    </span>
                <?php endif; ?>
                
                <i class="icon-tradeace-3column"></i>
            </li>
            
            <?php if (isset($tradeace_opt['option_2_cols']) && $tradeace_opt['option_2_cols']) : ?>
                <li class="tradeace-change-layout productGrid grid-2<?php echo ($typeShow == 'grid-2') ? ' active' : ''; ?>" data-columns="2">
                    <?php if ($number_view) : ?>
                        <span class="tradeace-text-number hidden-tag">
                            <?php echo esc_html__('2', 'tradeace-theme'); ?>
                        </span>
                    <?php endif; ?>
                    
                    <i class="icon-tradeace-2column"></i>
                </li>
            <?php endif; ?>
            
            <?php if ($list_view) : ?>
                <li class="tradeace-change-layout productList list<?php echo ($typeShow == 'list') ? ' active' : ''; ?>" data-columns="1">
                    <?php if ($number_view) : ?>
                        <span class="tradeace-text-number hidden-tag">
                            <?php echo esc_html__('List', 'tradeace-theme'); ?>
                        </span>
                    <?php endif; ?>

                    <i class="icon-tradeace-list"></i>
                </li>
            <?php endif; ?>
        </ul>
        <?php
        
        /**
         * Grid - List view cookie name
         */
        $grid_cookie_name = 'archive_grid_view';
        $siteurl = get_option('siteurl');
        $grid_cookie_name .= $siteurl ? '_' . md5($siteurl) : '';
        echo '<input type="hidden" name="tradeace_archive_grid_view" value="' . esc_attr($grid_cookie_name) . '" />';
    }
endif;

/**
 * Single Product Layout
 */
if (!function_exists('tradeace_single_product_layout')) :
    function tradeace_single_product_layout() {
        global $product, $tradeace_opt;

        /**
         * Layout: New | Classic
         */
        $tradeace_opt['product_detail_layout'] = isset($tradeace_opt['product_detail_layout']) && in_array($tradeace_opt['product_detail_layout'], array('new', 'classic', 'full')) ? $tradeace_opt['product_detail_layout'] : 'new';
        
        $tradeace_opt['product_thumbs_style'] = isset($tradeace_opt['product_thumbs_style']) && $tradeace_opt['product_thumbs_style'] == 'hoz' ? $tradeace_opt['product_thumbs_style'] : 'ver';

        /**
         * Image Layout Style
         */
        $image_layout = 'single';
        $image_style = 'slide';
        if ($tradeace_opt['product_detail_layout'] == 'new') {
            $image_layout = (!isset($tradeace_opt['product_image_layout']) || $tradeace_opt['product_image_layout'] == 'double') ? 'double' : 'single';
            $image_style = (!isset($tradeace_opt['product_image_style']) || $tradeace_opt['product_image_style'] == 'slide') ? 'slide' : 'scroll';
        }
        
        $tradeace_opt['product_image_layout'] = $image_layout;
        $tradeace_opt['product_image_style'] = $image_style;
        
        $tradeace_sidebar = isset($tradeace_opt['product_sidebar']) ? $tradeace_opt['product_sidebar'] : 'no';
        
        /**
         * Override with single product options
         */
        $productId = $product->get_id();
        $single_layout = tradeace_get_product_meta_value($productId, 'tradeace_layout');
        $single_imageLayouts = tradeace_get_product_meta_value($productId, 'tradeace_image_layout');
        $single_imageStyle = tradeace_get_product_meta_value($productId, 'tradeace_image_style');
        $single_thumbStyle = tradeace_get_product_meta_value($productId, 'tradeace_thumb_style');
        
        if ($single_layout) {
            if (in_array($single_layout, array('new', 'classic', 'full'))) {
                $tradeace_opt['product_detail_layout'] = $single_layout;
            }
            
            if ($single_layout == 'new') {
                $tradeace_opt['product_image_layout'] = $single_imageLayouts ? $single_imageLayouts : $tradeace_opt['product_image_layout'];
                
                $tradeace_opt['product_image_style'] = $single_imageStyle ? $single_imageStyle : $tradeace_opt['product_image_style'];
            }

            if ($single_layout == 'classic') {
                $tradeace_opt['product_image_style'] = 'slide';
                $tradeace_opt['product_thumbs_style'] = $single_thumbStyle ? $single_thumbStyle : $tradeace_opt['product_thumbs_style'];
            }

            if ($single_layout == 'full') {
                $tradeace_opt['product_image_style'] = 'slide';
            }

            $GLOBALS['tradeace_opt'] = $tradeace_opt;
        } else {
            /**
             * Override with root Category
             */
            $rootCatId = tradeace_get_root_term_id();
            if ($rootCatId) {
                $_product_layout = get_term_meta($rootCatId, 'single_product_layout', true);

                if (in_array($_product_layout, array('new', 'classic', 'full'))) {
                    $tradeace_opt['product_detail_layout'] = $_product_layout;
                }

                if ($_product_layout == 'new') {
                    $product_image_layout = get_term_meta($rootCatId, 'single_product_image_layout', true);
                    $tradeace_opt['product_image_layout'] = $product_image_layout ? $product_image_layout : $tradeace_opt['product_image_layout'];

                    $product_image_style = get_term_meta($rootCatId, 'single_product_image_style', true);
                    $tradeace_opt['product_image_style'] = $product_image_style ? $product_image_style : $tradeace_opt['product_image_style'];
                }

                if ($_product_layout == 'classic') {
                    $tradeace_opt['product_image_style'] = 'slide';

                    $product_thumbs_style = get_term_meta($rootCatId, 'single_product_thumbs_style', true);
                    $tradeace_opt['product_thumbs_style'] = $product_thumbs_style ? $product_thumbs_style : $tradeace_opt['product_thumbs_style'];
                }

                if ($_product_layout == 'full') {
                    $tradeace_opt['product_image_style'] = 'slide';
                }

                $GLOBALS['tradeace_opt'] = $tradeace_opt;
            }
        }
        
        $in_mobile = false;
        if (isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile'] && isset($tradeace_opt['single_product_mobile']) && $tradeace_opt['single_product_mobile']) {
            $tradeace_actsidebar = false;
            $in_mobile = true;
        } else {
            $tradeace_actsidebar = is_active_sidebar('product-sidebar');
        }

        // Class
        switch ($tradeace_sidebar) :
            case 'right' :
                if ($tradeace_opt['product_detail_layout'] == 'classic') {
                    $main_class = 'large-9 columns left';
                    $bar_class = 'large-3 columns col-sidebar desktop-padding-left-20 product-sidebar-right right';
                }
                else {
                    $main_class = '';
                    $bar_class = 'tradeace-side-sidebar tradeace-sidebar-right';
                }

                break;

            case 'no' :
                $main_class = 'large-12 columns';
                $bar_class = '';
                break;

            default:
            case 'left' :
                if ($tradeace_opt['product_detail_layout'] == 'classic') {
                    $main_class = 'large-9 columns right';
                    $bar_class = 'large-3 columns col-sidebar desktop-padding-right-20 product-sidebar-left left';
                } 
                else {
                    $main_class = '';
                    $bar_class = 'tradeace-side-sidebar tradeace-sidebar-left';
                }

                break;

        endswitch;
        $main_class .= $main_class != '' ? ' ' : '';
        $main_class .= 'tradeace-single-product-' . $tradeace_opt['product_image_style'];
        $main_class .= $tradeace_opt['product_image_style'] == 'scroll' && $tradeace_opt['product_image_layout'] == 'double' ? ' tradeace-single-product-2-columns': '';
        
        $main_class .= $in_mobile ? ' tradeace-single-product-in-mobile' : '';
        
        $file = TRADEACE_CHILD_PATH . '/includes/tradeace-single-product-' . $tradeace_opt['product_detail_layout'] . '.php';
        
        include_once is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-single-product-' . $tradeace_opt['product_detail_layout'] . '.php';
    }
endif;

/**
 * Custom Tabs
 */
function tradeace_custom_tabs_single_product($tabs) {
    global $tradeace_opt;
    
    /**
     * Remove Additional tab
     */
    if (
        isset($tabs['additional_information']) &&
        isset($tradeace_opt['hide_additional_tab']) &&
        $tradeace_opt['hide_additional_tab']
    ) {
        unset($tabs['additional_information']);
    }
    
    return $tabs;
}

/**
 * Hide Uncategorized
 */
if (!function_exists('tradeace_hide_uncategorized')) :
    function tradeace_hide_uncategorized($args) {
        $args['exclude'] = get_option('default_product_cat');
        return $args;
    }
endif;

/**
 * Before Share WooCommerce
 */
if (!function_exists('tradeace_before_woocommerce_share')) :
    function tradeace_before_woocommerce_share() {
        echo '<hr class="tradeace-single-hr" /><div class="tradeace-single-share">';
    }
endif;

/**
 * Custom Share WooCommerce
 */
if (!function_exists('tradeace_woocommerce_share')) :
    function tradeace_woocommerce_share() {
        echo shortcode_exists('tradeace_share') ? do_shortcode('[tradeace_share]') : '';
    }
endif;

/**
 * After Share WooCommerce
 */
if (!function_exists('tradeace_after_woocommerce_share')) :
    function tradeace_after_woocommerce_share() {
        echo '</div>';
    }
endif;

/**
 * Before desc of Archive
 */
if (!function_exists('tradeace_before_archive_description')) :
    function tradeace_before_archive_description() {
        echo '<div class="tradeace_shop_description page-description padding-top-20">';
    }
endif;

/**
 * After desc of Archive
 */
if (!function_exists('tradeace_after_archive_description')) :
    function tradeace_after_archive_description() {
        echo '</div>';
    }
endif;

/**
 * Open wrap 12 columns
 */
if (!function_exists('tradeace_open_wrap_12_cols')) :
    function tradeace_open_wrap_12_cols() {
        echo '<div class="row"><div class="large-12 columns">';
    }
endif;

/**
 * Close wrap 12 columns
 */
if (!function_exists('tradeace_close_wrap_12_cols')) :
    function tradeace_close_wrap_12_cols() {
        echo '</div></div>';
    }
endif;

/**
 * shopping cart subtotal
 */
if (!function_exists('tradeace_widget_shopping_cart_subtotal')) :
    function tradeace_widget_shopping_cart_subtotal() {
        echo '<span class="total-price-label">' . esc_html__('Subtotal', 'tradeace-theme') . '</span>';
        echo '<span class="total-price right">' . WC()->cart->get_cart_subtotal() . '</span>';
    }
endif;

/**
 * tradeace_wc_form_field_args
 */
if (!function_exists('tradeace_wc_form_field_args')) :
    function tradeace_wc_form_field_args($args) {
        if (isset($args['label']) && (!isset($args['placeholder']) || $args['placeholder'] == '')) {
            $args['placeholder'] = $args['label'];
        }
    
        return $args;
    }
endif;

/**
 * Hook woocommerce_before_main_content
 */
if (!function_exists('tradeace_open_woo_main')) :
    function tradeace_open_woo_main() {
        global $tradeace_opt;

        $class = 'tradeace-ajax-store-content';
        $class .= !isset($tradeace_opt['crazy_load']) || $tradeace_opt['crazy_load'] ? ' tradeace-crazy-load crazy-loading' : '';

        echo '<!-- Begin Ajax Store Wrap --><div class="tradeace-ajax-store-wrapper"><div id="tradeace-ajax-store" class="' . $class . '">';
        
        if (!isset($tradeace_opt['disable_ajax_product_progress_bar']) || $tradeace_opt['disable_ajax_product_progress_bar'] != 1) :
            echo '<div class="tradeace-progress-bar-load-shop"><div class="tradeace-progress-per"></div></div>';
        endif;
        
        /**
         * For Ajax in Single Product Page
         */
        if (isset($tradeace_opt['single_product_ajax']) && $tradeace_opt['single_product_ajax'] && is_product()) :
            wp_enqueue_script('wc-add-to-cart-variation');
        endif;
    }
endif;

/**
 * Hook woocommerce_after_main_content
 */
if (!function_exists('tradeace_close_woo_main')) :
    function tradeace_close_woo_main() {
        echo '</div></div><!-- End Ajax Store Wrap -->';
    }
endif;
