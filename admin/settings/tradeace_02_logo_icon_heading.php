<?php
add_action('init', 'tradeace_logo_icon_heading');
if (!function_exists('tradeace_logo_icon_heading')) {
    function tradeace_logo_icon_heading() {
        /**
         * The Options Array
         * Set the Options Array
         */
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Logo and Favicon", 'tradeace-theme'),
            "target" => 'logo-icons',
            "type" => "heading"
        );

        $of_options[] = array(
            "name" => esc_html__("Logo", 'tradeace-theme'),
            "id" => "site_logo",
            "std" => TRADEACE_THEME_URI . "/assets/images/logo.png",
            "type" => "media"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Retina Logo", 'tradeace-theme'),
            "id" => "site_logo_retina",
            "std" => TRADEACE_THEME_URI . "/assets/images/logo-retina.png",
            "type" => "media"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Sticky Logo", 'tradeace-theme'),
            "id" => "site_logo_sticky",
            "std" => '',
            "type" => "media"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Mobile Logo", 'tradeace-theme'),
            "id" => "site_logo_m",
            "std" => '',
            "type" => "media"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Width - Logo", 'tradeace-theme'),
            "id" => "logo_width",
            "std" => "",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Height - Logo", 'tradeace-theme'),
            "id" => "logo_height",
            "std" => "",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Width - Sticky Logo", 'tradeace-theme'),
            "id" => "logo_sticky_width",
            "std" => "",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Height - Sticky Logo", 'tradeace-theme'),
            "id" => "logo_sticky_height",
            "std" => "",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Width - Mobile Logo", 'tradeace-theme'),
            "id" => "logo_width_mobile",
            "std" => "",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Height - Mobile Logo", 'tradeace-theme'),
            "id" => "logo_height_mobile",
            "std" => "",
            "type" => "text"
        );

        $of_options[] = array(
            "name" => esc_html__("Max Height Logo", 'tradeace-theme'),
            "id" => "max_height_logo",
            "std" => "40px",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Max Height Logo in Mobile", 'tradeace-theme'),
            "id" => "max_height_mobile_logo",
            "std" => "25px",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Max Height Logo in Header Sticky", 'tradeace-theme'),
            "id" => "max_height_sticky_logo",
            "std" => "25px",
            "type" => "text"
        );

        $of_options[] = array(
            "name" => esc_html__("Favicon", 'tradeace-theme'),
            "desc" => esc_html__("Add your custom Favicon image. 16x16 - 32x32 *.ico or *.png required. (Recommended 16x16 *.ico)", 'tradeace-theme'),
            "id" => "site_favicon",
            "std" => "",
            "type" => "media"
        );
    }
}
