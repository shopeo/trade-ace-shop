<?php
add_action('init', 'tradeace_product_global_heading');
if (!function_exists('tradeace_product_global_heading')) {
    function tradeace_product_global_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Product Global Options", 'tradeace-theme'),
            "target" => 'product-global',
            "type" => "heading",
        );
        
        // Coming Soon
        $of_options[] = array(
            "name" => esc_html__("Loop Product Buttons for Desktop", 'tradeace-theme'),
            "id" => "loop_layout_buttons",
            "std" => "ver-buttons",
            "type" => "select",
            "options" => array(
                "ver-buttons" => esc_html__("Vertical Buttons", 'tradeace-theme'),
                "hoz-buttons" => esc_html__("Horizontal Buttons", 'tradeace-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hover Product Effect", 'tradeace-theme'),
            "id" => "animated_products",
            "std" => "hover-fade",
            "type" => "select",
            "options" => array(
                "hover-fade" => esc_html__("Fade", 'tradeace-theme'),
                "hover-zoom" => esc_html__("Zoom", 'tradeace-theme'),
                "hover-to-top" => esc_html__("Move To Top", 'tradeace-theme'),
                "hover-flip" => esc_html__("Flip Horizontal", 'tradeace-theme'),
                "hover-bottom-to-top" => esc_html__("Bottom To Top", 'tradeace-theme'),
                "hover-top-to-bottom" => esc_html__("Top To Bottom", 'tradeace-theme'),
                "hover-left-to-right" => esc_html__("Left To Right", 'tradeace-theme'),
                "hover-right-to-left" => esc_html__("Right To Left", 'tradeace-theme'),
                "" => esc_html__("No Effect", 'tradeace-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Back Image in Mobile Layout", 'tradeace-theme'),
            "id" => "mobile_back_image",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Featured Badge", 'tradeace-theme'),
            "id" => "featured_badge",
            "std" => "0",
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Catalog Mode - Disable Add To Cart Feature", 'tradeace-theme'),
            "id" => "disable-cart",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Add To Cart in Loop", 'tradeace-theme'),
            "id" => "loop_add_to_cart",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Event After Add to Cart", 'tradeace-theme'),
            "id" => "event-after-add-to-cart",
            "std" => "sidebar",
            "type" => "select",
            "options" => array(
                "sidebar" => esc_html__("Open Cart Sidebar - Not with Mobile", 'tradeace-theme'),
                "popup" => esc_html__("Popup Your Order - Not with Mobile", 'tradeace-theme'),
                "notice" => esc_html__("Show Notice", 'tradeace-theme'),
            ),
            "desc" => esc_html__('Note: With Mobile always "Show Notice" After Added To Cart', 'tradeace-theme')
        );
        
        $of_options[] = array(
            "name" => esc_html__("Icon Mini Cart in Header", 'tradeace-theme'),
            "id" => "mini-cart-icon",
            "std" => "1",
            "type" => "images",
            "options" => array(
                // icon-tradeace-cart-3 - default
                '1' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-1.jpg',
                // icon-tradeace-cart-2
                '2' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-2.jpg',
                // icon-tradeace-cart-4
                '3' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-3.jpg',
                // pe-7s-cart
                '4' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-4.jpg',
                // fa fa-shopping-cart
                '5' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-5.jpg',
                // fa fa-shopping-bag
                '6' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-6.jpg',
                // fa fa-shopping-basket
                '7' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-7.jpg'
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Icon Add To Cart in Grid", 'tradeace-theme'),
            "id" => "cart-icon-grid",
            "std" => "1",
            "type" => "images",
            "options" => array(
                // fa fa-plus - default
                '1' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/cart-plus.jpg',
                // icon-tradeace-cart-3
                '2' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-1.jpg',
                // icon-tradeace-cart-2
                '3' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-2.jpg',
                // icon-tradeace-cart-4
                '4' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-3.jpg',
                // pe-7s-cart
                '5' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-4.jpg',
                // fa fa-shopping-cart
                '6' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-5.jpg',
                // fa fa-shopping-bag
                '7' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-6.jpg',
                // fa fa-shopping-basket
                '8' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/mini-cart-7.jpg'
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Quantity Input - Off-Canvas Cart", 'tradeace-theme'),
            "id" => "mini_cart_qty",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Compact Number - Cart, Wishlist, Compare (9+)", 'tradeace-theme'),
            "id" => "compact_number",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable Quick View", 'tradeace-theme'),
            "id" => "disable-quickview",
            "desc" => esc_html__("Yes, Please!", 'tradeace-theme'),
            "std" => "0",
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Quickview Layout", 'tradeace-theme'),
            "id" => "style_quickview",
            "std" => "sidebar",
            "type" => "select",
            "options" => array(
                'popup' => esc_html__('Popup Classical', 'tradeace-theme'),
                'sidebar' => esc_html__('Off-Canvas', 'tradeace-theme')
            ),
            
            'class' => 'tradeace-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Number Show Quickview Thumbnail", 'tradeace-theme'),
            "id" => "quick_view_item_thumb",
            "std" => "1-item",
            "type" => "select",
            "options" => array(
                '1-item' => esc_html__('Single Thumbnail', 'tradeace-theme'),
                '2-items' => esc_html__('Double Thumbnails', 'tradeace-theme')
            ),
            
            'class' => 'tradeace-style_quickview tradeace-style_quickview-sidebar tradeace-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Cart Sidebar Layout", 'tradeace-theme'),
            "id" => "style-cart",
            "std" => "style-1",
            "type" => "select",
            "options" => array(
                'style-1' => esc_html__('Light', 'tradeace-theme'),
                'style-2' => esc_html__('Dark', 'tradeace-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Wishlist Sidebar Layout", 'tradeace-theme'),
            "id" => "style-wishlist",
            "std" => "style-1",
            "type" => "select",
            "options" => array(
                'style-1' => esc_html__('Light', 'tradeace-theme'),
                'style-2' => esc_html__('Dark', 'tradeace-theme')
            )
        );
        
        if (defined('YITH_WCPB')) {
            // Enable Gift in grid
            $of_options[] = array(
                "name" => esc_html__("Enable Promotion Gifts featured icon", 'tradeace-theme'),
                "id" => "enable_gift_featured",
                "std" => 1,
                "type" => "switch"
            );
        }
        
        // Options live search products
        $of_options[] = array(
            "name" => esc_html__("Search Anything After Submit", 'tradeace-theme'),
            "id" => "anything_search",
            "std" => 0,
            "type" => "switch",
            "desc" => '<span class="tradeace-warning red-color">' . esc_html__("If Turn on, the live search Ajax feature will be lost", 'tradeace-theme') . '</span>',
        );

        // Options live search products
        $of_options[] = array(
            "name" => esc_html__("Live Search Ajax Products", 'tradeace-theme'),
            "id" => "enable_live_search",
            "std" => 1,
            "type" => "switch"
        );
        
        // limit_results_search
        $of_options[] = array(
            "name" => esc_html__("Results Ajax Search (Limit Products)", 'tradeace-theme'),
            "id" => "limit_results_search",
            "std" => "5",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Suggested Keywords", 'tradeace-theme'),
            "desc" => 'Please input the Suggested keywords (ex: Sweater, Jacket, T-shirt ...).',
            "id" => "hotkeys_search",
            "std" => '',
            "type" => "textarea"
        );
        // End Options live search products
        
        $of_options[] = array(
            "name" => esc_html__("Display top icon filter categories", 'tradeace-theme'),
            "id" => "show_icon_cat_top",
            "std" => "show-in-shop",
            "type" => "select",
            "options" => array(
                'show-in-shop' => esc_html__('Only show in shop', 'tradeace-theme'),
                'show-all-site' => esc_html__('Always show all pages', 'tradeace-theme'),
                'not-show' => esc_html__('Disabled', 'tradeace-theme'),
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Max Depth Level Top Filter Categories", 'tradeace-theme'),
            "id" => "depth_cat_top",
            "std" => "0",
            "type" => "select",
            "options" => array(
                '0' => esc_html__('Show All', 'tradeace-theme'),
                '1' => esc_html__('Max Depth 1 Level', 'tradeace-theme'),
                '2' => esc_html__('Max Depth 2 Levels', 'tradeace-theme'),
                '3' => esc_html__('Max Depth 3 Levels', 'tradeace-theme')
            ),
            'override_numberic' => true
        );
        
        // Hide categories empty product
        $of_options[] = array(
            "name" => esc_html__("Hide categories empty product - Top Filter Categories", 'tradeace-theme'),
            "id" => "hide_empty_cat_top",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable top level of categories follow current category archive (Use for Multi stores)", 'tradeace-theme'),
            "desc" => esc_html__("Yes, Please!", 'tradeace-theme'),
            "id" => "disable_top_level_cat",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Show Uncategorized", 'tradeace-theme'),
            "id" => "show_uncategorized",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Crazy Loading", 'tradeace-theme'),
            "id" => "crazy_load",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable ajax Progress Bar Loading", 'tradeace-theme'),
            "id" => "disable_ajax_product_progress_bar",
            "desc" => esc_html__("Yes, Please!", 'tradeace-theme'),
            "std" => 0,
            "type" => "checkbox"
        );
    }
}
