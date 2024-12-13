<?php
add_action('init', 'tradeace_product_compare_heading');
if (!function_exists('tradeace_product_compare_heading')) {
    function tradeace_product_compare_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Compare and Wishlist", 'tradeace-theme'),
            "target" => 'product-compare-wishlist',
            "type" => "heading",
        );
        
        $of_options[] = array(
            "name" => esc_html__("Compare Options", 'tradeace-theme'),
            "std" => "<h4>" . esc_html__("Compare Options", 'tradeace-theme') . "</h4>",
            "type" => "info"
        );
        
        global $yith_woocompare;
        if ($yith_woocompare) {
            $of_options[] = array(
                "name" => esc_html__("Tradeace compare products Extends Yith Plugin Compare", 'tradeace-theme'),
                "id" => "tradeace-product-compare",
                "std" => 1,
                "type" => "switch"
            );
            
            $of_options[] = array(
                "name" => esc_html__("Page view compare products", 'tradeace-theme'),
                "id" => "tradeace-page-view-compage",
                "type" => "select",
                "options" => get_pages_temp_compare()
            );

            $of_options[] = array(
                "name" => esc_html__("Max products compare", 'tradeace-theme'),
                "id" => "max_compare",
                "std" => "4",
                "type" => "select",
                "options" => array("2" => "2", "3" => "3", "4" => "4")
            );
        } else {
            $of_options[] = array(
                "name" => esc_html__("Please Install Yith Plugin Compare", 'tradeace-theme'),
                "std" => '<h4 style="color: red">' . esc_html__("Please, Install Yith Plugin Compare!", 'tradeace-theme') . "</h4>",
                "type" => "info"
            );
        }
        
        /**
         * Wishlist
         */
        $of_options[] = array(
            "name" => esc_html__("Wishlist Options", 'tradeace-theme'),
            "std" => "<h4>" . esc_html__("Wishlist Options", 'tradeace-theme') . "</h4>",
            "type" => "info"
        );
        
        if (TRADEACE_WISHLIST_ENABLE) {
            $of_options[] = array(
                "name" => esc_html__("Optimize Yith Wishlist HTML", 'tradeace-theme'),
                "id" => "optimize_wishlist_html",
                "std" => 1,
                "type" => "switch"
            );
        }
        
        /**
         * Tradeace Wishlist
         */
        else {
            $of_options[] = array(
                "name" => esc_html__("TradeaceTheme Wishlist Feature", 'tradeace-theme'),
                "id" => "enable_tradeace_wishlist",
                "std" => 1,
                "type" => "switch"
            );
        }
    }
}
