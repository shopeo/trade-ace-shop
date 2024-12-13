<?php
add_action('init', 'tradeace_product_detail_heading');
if (!function_exists('tradeace_product_detail_heading')) {
    function tradeace_product_detail_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Single Product Page", 'tradeace-theme'),
            "target" => 'product-detail',
            "type" => "heading",
        );
        
        $of_options[] = array(
            "name" => esc_html__("Ajax Load", 'tradeace-theme'),
            "id" => "single_product_ajax",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Single Product Layout", 'tradeace-theme'),
            "id" => "product_detail_layout",
            "std" => "new",
            "type" => "select",
            "options" => array(
                "new" => esc_html__("New layout (sidebar - Off-Canvas)", 'tradeace-theme'),
                "classic" => esc_html__("Classic layout (Sidebar - columns)", 'tradeace-theme'),
                'full' => esc_html__("Slider - No Thumbs (sidebar - Off-Canvas)", 'tradeace-theme'),
            ),
            'class' => 'tradeace-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Images Columns", 'tradeace-theme'),
            "id" => "product_image_layout",
            "std" => "double",
            "type" => "select",
            "options" => array(
                "double" => esc_html__("Double images", 'tradeace-theme'),
                "single" => esc_html__("Single images", 'tradeace-theme')
            ),
            'class' => 'tradeace-theme-option-child tradeace-product_detail_layout tradeace-product_detail_layout-new'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Images Style", 'tradeace-theme'),
            "id" => "product_image_style",
            "std" => "slide",
            "type" => "select",
            "options" => array(
                "slide" => esc_html__("Slide images", 'tradeace-theme'),
                "scroll" => esc_html__("Scroll images", 'tradeace-theme')
            ),
            'class' => 'tradeace-theme-option-child tradeace-product_detail_layout tradeace-product_detail_layout-new'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Thumbnail Layout", 'tradeace-theme'),
            "id" => "product_thumbs_style",
            "std" => "ver",
            "type" => "select",
            "options" => array(
                "ver" => esc_html__("Vertical", 'tradeace-theme'),
                "hoz" => esc_html__("Horizontal", 'tradeace-theme')
            ),
            'class' => 'tradeace-theme-option-child tradeace-product_detail_layout tradeace-product_detail_layout-classic'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Dots for Main Slide", 'tradeace-theme'),
            "id" => "product_slide_dot",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Arrows for Main Slide", 'tradeace-theme'),
            "id" => "product_slide_arrows",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hover Zoom Image", 'tradeace-theme'),
            "id" => "product-zoom",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Lightbox Image When click", 'tradeace-theme'),
            "id" => "product-image-lightbox",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Focus Main Image", 'tradeace-theme'),
            "id" => "enable_focus_main_image",
            "desc" => esc_html__("Focus main image after active variation product", 'tradeace-theme'),
            "std" => "0",
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Product Sidebar", 'tradeace-theme'),
            "id" => "product_sidebar",
            "std" => "left",
            "type" => "select",
            "options" => array(
                "left" => esc_html__("Left Sidebar", 'tradeace-theme'),
                "right" => esc_html__("Right Sidebar", 'tradeace-theme'),
                "no" => esc_html__("No sidebar", 'tradeace-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Deal Time in Single or Quickview", 'tradeace-theme'),
            "id" => "single-product-deal",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Buy Now", 'tradeace-theme'),
            "id" => "enable_buy_now",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Buy Now Background Color", 'tradeace-theme'),
            "id" => "buy_now_bg_color",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Buy Now Background Color Hover", 'tradeace-theme'),
            "id" => "buy_now_bg_color_hover",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Buy Now Shadow Color", 'tradeace-theme'),
            "id" => "buy_now_color_shadow",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Sticky Add To Cart", 'tradeace-theme'),
            "id" => "enable_fixed_add_to_cart",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Sticky Buy Now - Desktop", 'tradeace-theme'),
            "id" => "enable_fixed_buy_now_desktop",
            "std" => "0",
            "type" => "switch"
        );
        
        $options = array(
            "no" => esc_html__("Not Show", 'tradeace-theme'),
            "ext" => esc_html__("Extends Desktop", 'tradeace-theme')
        );
        
        if (class_exists('Tradeace_Mobile_Detect')) {
            $options['btn'] = esc_html__("Only Show Buttons", 'tradeace-theme');
        }
        
        $of_options[] = array(
            "name" => esc_html__("Sticky Add To Cart In Mobile", 'tradeace-theme'),
            "id" => "mobile_fixed_add_to_cart",
            "std" => "no",
            "type" => "select",
            "options" => $options
        );
        
        $of_options[] = array(
            "name" => esc_html__("Stock Progress Bar", 'tradeace-theme'),
            "id" => "enable_progess_stock",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Tabs Layout", 'tradeace-theme'),
            "id" => "tab_style_info",
            "std" => "2d-no-border",
            "type" => "select",
            "options" => array(
                "2d-no-border" => esc_html__("Classic 2D - No border", 'tradeace-theme'),
                "2d-radius" => esc_html__("Classic 2D - Radius", 'tradeace-theme'),
                "2d-radius-dashed" => esc_html__("Classic 2D - Radius - Dash", 'tradeace-theme'),
                "2d" => esc_html__("Classic 2D", 'tradeace-theme'),
                "3d" => esc_html__("Classic 3D", 'tradeace-theme'),
                "slide" => esc_html__("Slide", 'tradeace-theme'),
                "accordion" => esc_html__("Accordion", 'tradeace-theme'),
                'scroll-down' => esc_html__("Scroll Down", 'tradeace-theme'),
            ),
            'class' => 'tradeace-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Tabs Align", 'tradeace-theme'),
            "id" => "tab_align_info",
            "std" => "center",
            "type" => "select",
            "options" => array(
                "center" => esc_html__("Center", 'tradeace-theme'),
                "left" => esc_html__("Left", 'tradeace-theme'),
                "right" => esc_html__("Right", 'tradeace-theme')
            ),
            'class' => 'tradeace-tab_style_info tradeace-tab_style_info-2d-no-border tradeace-tab_style_info-2d-radius tradeace-tab_style_info-2d tradeace-tab_style_info-3d tradeace-tab_style_info-slide tradeace-tab_style_info-scroll-down tradeace-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__('WooCommerce Tabs Off - Canvas in Mobile', 'tradeace-theme'),
            "id" => "woo_tabs_off_canvas",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__('Product Description Wrapper', 'tradeace-theme'),
            "id" => "desc_product_wrap",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hide Additional Information Tab", 'tradeace-theme'),
            "desc" => esc_html__("Yes, Please!", 'tradeace-theme'),
            "id" => "hide_additional_tab",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__('Relate Products', 'tradeace-theme'),
            "id" => "relate_product",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Number for relate products", 'tradeace-theme'),
            "id" => "relate_product_number",
            "std" => "12",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns Relate | Upsell Products", 'tradeace-theme'),
            "id" => "relate_columns_desk",
            "std" => "5-cols",
            "type" => "select",
            "options" => array(
                "5-cols" => esc_html__("5 columns", 'tradeace-theme'),
                "4-cols" => esc_html__("4 columns", 'tradeace-theme'),
                "3-cols" => esc_html__("3 columns", 'tradeace-theme'),
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns Relate | Upsell Products for Mobile", 'tradeace-theme'),
            "id" => "relate_columns_small",
            "std" => "2-cols",
            "type" => "select",
            "options" => array(
                "2-cols" => esc_html__("2 columns", 'tradeace-theme'),
                "1.5-cols" => esc_html__("1,5 column", 'tradeace-theme'),
                "1-col" => esc_html__("1 column", 'tradeace-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns Relate | Upsell Products for Tablet", 'tradeace-theme'),
            "id" => "relate_columns_tablet",
            "std" => "3-cols",
            "type" => "select",
            "options" => array(
                "4-cols" => esc_html__("4 columns", 'tradeace-theme'),
                "3-cols" => esc_html__("3 columns", 'tradeace-theme'),
                "2-cols" => esc_html__("2 columns", 'tradeace-theme')
            )
        );
        
        // Enable AJAX add to cart buttons on Detail OR Quickview
        $of_options[] = array(
            "name" => esc_html__("AJAX add to cart button on Single And Quickview", 'tradeace-theme'),
            "id" => "enable_ajax_addtocart",
            "std" => "1",
            "type" => "switch",
            "desc" => '<span class="tradeace-warning red-color">' . esc_html__('Note: Consider disabling this feature if you are using a third-party plugin developed for the Add to Cart feature in the Single Product Page!', 'tradeace-theme') . '</span>'
        );
        
        $of_options[] = array(
            "name" => esc_html__('Mobile Layout', 'tradeace-theme'),
            "desc" => esc_html__('Note: Mobile layout for single product pages will hide all widgets and sidebar to increase performance.', 'tradeace-theme'),
            "id" => "single_product_mobile",
            "std" => 0,
            "type" => "switch"
        );
    }
}
