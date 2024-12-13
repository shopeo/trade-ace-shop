<?php
add_action('init', 'tradeace_promotion_news_heading');
if (!function_exists('tradeace_promotion_news_heading')) {
    function tradeace_promotion_news_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Promotion News", 'tradeace-theme'),
            "target" => "promotion-news",
            "type" => "heading"
        );

        $of_options[] = array(
            "name" => esc_html__("Top Bar Promotion News", 'tradeace-theme'),
            "id" => "enable_post_top",
            "std" => 0,
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Type Show", 'tradeace-theme'),
            "id" => "type_display",
            "std" => 'custom',
            "type" => "select",
            "options" => array(
                'custom' => esc_html__('Custom Content', 'tradeace-theme'),
                'list-posts' => esc_html__('Posts', 'tradeace-theme')
            ),
            'class' => 'type_promotion'
        );

        $of_options[] = array(
            "name" => esc_html__("Custom Content", 'tradeace-theme'),
            "desc" => '<a href="javascript:void(0);" class="reset_content_custom"><b>Default value</b></a> for My content custom.<br /><a href="javascript:void(0);" class="restore_content_custom"><b>Restore text</b></a> for My content custom.<br />',
            "id" => "content_custom",
            "std" => '',
            'type' => 'textarea',
            'class' => 'hidden-tag tradeace-custom_content'
        );

        $of_options[] = array(
            "name" => esc_html__("Category Post", 'tradeace-theme'),
            "id" => "category_post",
            "std" => '',
            "type" => "select",
            "options" =>tradeace_get_cats_array(),
            'class' => 'hidden-tag tradeace-list_post'
        );

        $of_options[] = array(
            "name" => esc_html__("Limit Posts", 'tradeace-theme'),
            "id" => "number_post",
            "std" => 4,
            "type" => "text",
            'class' => 'hidden-tag tradeace-list_post'
        );

        $of_options[] = array(
            "name" => esc_html__("Slide Show", 'tradeace-theme'),
            "id" => "number_post_slide",
            "std" => 1,
            "type" => "text",
            'class' => 'hidden-tag tradeace-list_post'
        );

        $of_options[] = array(
            "name" => esc_html__("Full Width", 'tradeace-theme'),
            "id" => "enable_fullwidth",
            "std" => 1,
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Text Promotion Color", 'tradeace-theme'),
            "id" => "t_promotion_color",
            "std" => "#333",
            "type" => "color"
        );

        $of_options[] = array(
            "name" => esc_html__("Background Image", 'tradeace-theme'),
            "id" => "background_area",
            "std" => TRADEACE_THEME_URI . '/assets/images/promo_bg.jpg',
            "type" => "media"
        );
    }
}
