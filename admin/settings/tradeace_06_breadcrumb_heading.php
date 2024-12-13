<?php
add_action('init', 'tradeace_breadcrumb_heading');
if (!function_exists('tradeace_breadcrumb_heading')) {
    function tradeace_breadcrumb_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Breadcrumb", 'tradeace-theme'),
            "target" => 'breadcumb',
            "type" => "heading"
        );

        $of_options[] = array(
            "name" => esc_html__("Enable", 'tradeace-theme'),
            "id" => "breadcrumb_show",
            "std" => 1,
            "type" => "switch",
            'class' => 'tradeace-breadcrumb-flag-option'
        );

        $of_options[] = array(
            "name" => esc_html__("Layout", 'tradeace-theme'),
            "desc" => esc_html__("Layout Single or Double rows.", 'tradeace-theme'),
            "id" => "breadcrumb_row",
            "std" => "multi",
            "type" => "select",
            "options" => array(
                "multi" => esc_html__("Double Rows", 'tradeace-theme'),
                "single" => esc_html__("Single Row", 'tradeace-theme')
            ),
        );
        
        $of_options[] = array(
            "name" => esc_html__("Type", 'tradeace-theme'),
            "desc" => esc_html__("With or Without Background.", 'tradeace-theme'),
            "id" => "breadcrumb_type",
            "std" => "has-background",
            "type" => "select",
            "options" => array(
                "default" => esc_html__("Without Background - Default use Background Color", 'tradeace-theme'),
                "has-background" => esc_html__("With Background", 'tradeace-theme')
            ),
        );

        $of_options[] = array(
            "name" => esc_html__("Background Image", 'tradeace-theme'),
            "id" => "breadcrumb_bg",
            "std" => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/breadcrumb-bg.jpg',
            "type" => "media"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Background Parallax", 'tradeace-theme'),
            "id" => "breadcrumb_bg_lax",
            "std" => 0,
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Background Color", 'tradeace-theme'),
            "id" => "breadcrumb_bg_color",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Text Color", 'tradeace-theme'),
            "id" => "breadcrumb_color",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Text Align", 'tradeace-theme'),
            "id" => "breadcrumb_align",
            "std" => "text-center",
            "type" => "select",
            "options" => array(
                "text-center" => esc_html__("Center", 'tradeace-theme'),
                "text-left" => esc_html__("Left", 'tradeace-theme'),
                "text-right" => esc_html__("Right", 'tradeace-theme')
            ),
        );

        $of_options[] = array(
            "name" => esc_html__("Height", 'tradeace-theme'),
            "desc" => esc_html__("Default - 130px", 'tradeace-theme'),
            "id" => "breadcrumb_height",
            "std" => "130",
            "type" => "text"
        );
    }
}
