<?php
add_action('init', 'tradeace_style_color_heading');
if (!function_exists('tradeace_style_color_heading')) {
    function tradeace_style_color_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Style and Colors", 'tradeace-theme'),
            "target" => 'style-color',
            "type" => "heading",
        );

        $of_options[] = array(
            "name" => esc_html__("Style and Colors Global Option", 'tradeace-theme'),
            "std" => "<h4>" . esc_html__("Style and Colors Global Option", 'tradeace-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Primary Color", 'tradeace-theme'),
            "desc" => esc_html__("Change primary color. Used for primary buttons, link hover, background, etc.", 'tradeace-theme'),
            "id" => "color_primary",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Success Color", 'tradeace-theme'),
            "id" => "color_success",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Custom Badge Color", 'tradeace-theme'),
            "id" => "color_hot_label",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Featured Badge Color", 'tradeace-theme'),
            "id" => "color_featured_label",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Video Badge Color", 'tradeace-theme'),
            "id" => "color_video_label",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("360&#176; Badge Color", 'tradeace-theme'),
            "id" => "color_360_label",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Deal Badge Color", 'tradeace-theme'),
            "id" => "color_deal_label",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Sale Badge Color", 'tradeace-theme'),
            "id" => "color_sale_label",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Variants Badge Color", 'tradeace-theme'),
            "id" => "color_variants_label",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Price Color", 'tradeace-theme'),
            "id" => "color_price_label",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Style and Color", 'tradeace-theme'),
            "std" => "<h4>" . esc_html__("Buttons Style and Color", 'tradeace-theme') . "</h4>",
            "type" => "info"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Background Color", 'tradeace-theme'),
            "id" => "color_button",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Background Color Hover", 'tradeace-theme'),
            "desc" => esc_html__("Default use primary color", 'tradeace-theme'),
            "id" => "color_hover",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Border Color", 'tradeace-theme'),
            "id" => "button_border_color",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Border Color Hover", 'tradeace-theme'),
            "id" => "button_border_color_hover",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Text Color", 'tradeace-theme'),
            "id" => "button_text_color",
            "std" => "",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Text Color Hover", 'tradeace-theme'),
            "id" => "button_text_color_hover",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Buttons Radius", 'tradeace-theme'),
            "id" => "button_radius",
            "std" => "0",
            "step" => "1",
            "max" => '100',
            "type" => "sliderui"
        );

        $of_options[] = array(
            "name" => esc_html__("Buttons Border Width", 'tradeace-theme'),
            "id" => "button_border",
            "std" => "1",
            "step" => "1",
            "max" => '5',
            "type" => "sliderui"
        );

        $of_options[] = array(
            "name" => esc_html__("Inputs Radius", 'tradeace-theme'),
            "id" => "input_radius",
            "std" => "0",
            "step" => "1",
            "max" => "100",
            "type" => "sliderui"
        );
    }
}
