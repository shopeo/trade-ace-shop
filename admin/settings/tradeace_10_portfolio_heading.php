<?php
add_action('init', 'tradeace_portfolio_heading');
if (!function_exists('tradeace_portfolio_heading')) {
    function tradeace_portfolio_heading() {
        
        if (!defined('TRADEACE_CORE_ACTIVED') || !TRADEACE_CORE_ACTIVED) {
            return;
        }
        
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Portfolio", 'tradeace-theme'),
            "target" => 'portfolio',
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Enable Portfolio", 'tradeace-theme'),
            "id" => "enable_portfolio",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Page view Portfolio", 'tradeace-theme'),
            "id" => "tradeace-page-view-portfolio",
            "type" => "select",
            "options" => get_pages_temp_portfolio()
        );
        
        $of_options[] = array(
            "name" => esc_html__("Recent Projects", 'tradeace-theme'),
            "id" => "recent_projects",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array(
            "name" => esc_html__("Portfolio Comments", 'tradeace-theme'),
            "id" => "portfolio_comments",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array(
            "name" => esc_html__("Portfolio Count", 'tradeace-theme'),
            "id" => "portfolio_count",
            "std" => 10,
            "type" => "text"
        );
        $of_options[] = array(
            "name" => esc_html__("Project Category", 'tradeace-theme'),
            "id" => "project_byline",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array(
            "name" => esc_html__("Project Name", 'tradeace-theme'),
            "id" => "project_name",
            "std" => 1,
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Portfolio Columns", 'tradeace-theme'),
            "id" => "portfolio_columns",
            "std" => "5-cols",
            "type" => "select",
            "options" => array(
                "5-cols" => esc_html__("5 columns", 'tradeace-theme'),
                "4-cols" => esc_html__("4 columns", 'tradeace-theme'),
                "3-cols" => esc_html__("3 columns", 'tradeace-theme'),
                "2-cols" => esc_html__("2 columns", 'tradeace-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("portfolio Lightbox", 'tradeace-theme'),
            "id" => "portfolio_lightbox",
            "std" => 1,
            "type" => "switch"
        );
    }
}
