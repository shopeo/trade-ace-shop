<?php
add_action('init', 'tradeace_product_page_heading');
if (!function_exists('tradeace_product_page_heading')) {
    function tradeace_product_page_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Archive Products Page", 'tradeace-theme'),
            "target" => 'product-page',
            "type" => "heading",
        );
        
        $of_options[] = array(
            "name" => esc_html__("Shop Sidebar Layout", 'tradeace-theme'),
            "id" => "category_sidebar",
            "std" => "top",
            "type" => "select",
            "options" => array(
                "top" => esc_html__("Top Bar", 'tradeace-theme'),
                "top-2" => esc_html__("Top Bar Type 2", 'tradeace-theme'),
                "left" => esc_html__("Left Sidebar - Off-canvas", 'tradeace-theme'),
                "right" => esc_html__("Right Sidebar - Off-canvas", 'tradeace-theme'),
                "left-classic" => esc_html__("Left Sidebar - Classic", 'tradeace-theme'),
                "right-classic" => esc_html__("Right Sidebar - Classic", 'tradeace-theme'),
                "no" => esc_html__("No Sidebar", 'tradeace-theme'),
            ),
            
            'class' => 'tradeace-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Toggle Sidebar", 'tradeace-theme'),
            "id" => "toggle_sidebar_classic",
            "std" => "1",
            "type" => "switch",
            'class' => 'tradeace-category_sidebar tradeace-category_sidebar-left-classic tradeace-category_sidebar-right-classic tradeace-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Top Bar Label", 'tradeace-theme'),
            "id" => "top_bar_archive_label",
            "std" => "Filter by:",
            "type" => "text",
            'class' => 'tradeace-category_sidebar tradeace-category_sidebar-top tradeace-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Top Bar Limit widgets to Show More", 'tradeace-theme'),
            "id" => "limit_widgets_show_more",
            "desc" => esc_html__('Limit widgets to show more. (Input "All" will be show all widgets)', 'tradeace-theme'),
            "std" => "4",
            "type" => "text",
            'class' => 'tradeace-category_sidebar tradeace-category_sidebar-top tradeace-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Position filter categories", 'tradeace-theme'),
            "id" => "top_bar_cat_pos",
            "std" => "left-bar",
            "type" => "select",
            "options" => array(
                "top" => esc_html__("Top", 'tradeace-theme'),
                "left-bar" => esc_html__("Left bar", 'tradeace-theme')
            ),
            'class' => 'tradeace-category_sidebar tradeace-category_sidebar-top tradeace-theme-option-child'
        );

        $of_options[] = array(
            "name" => esc_html__("Columns", 'tradeace-theme'),
            "id" => "products_per_row",
            "std" => "4-cols",
            "type" => "select",
            "options" => array(
                "2-cols" => esc_html__("2 columns", 'tradeace-theme'),
                "3-cols" => esc_html__("3 columns", 'tradeace-theme'),
                "4-cols" => esc_html__("4 columns", 'tradeace-theme'),
                "5-cols" => esc_html__("5 columns", 'tradeace-theme'),
                "6-cols" => esc_html__("6 columns", 'tradeace-theme'),
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Mobile Columns", 'tradeace-theme'),
            "id" => "products_per_row_small",
            "std" => "1-col",
            "type" => "select",
            "options" => array(
                "1-cols" => esc_html__("1 column", 'tradeace-theme'),
                "2-cols" => esc_html__("2 columns", 'tradeace-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Tablet Columns", 'tradeace-theme'),
            "id" => "products_per_row_tablet",
            "std" => "2-cols",
            "type" => "select",
            "options" => array(
                "2-cols" => esc_html__("2 columns", 'tradeace-theme'),
                "3-cols" => esc_html__("3 columns", 'tradeace-theme'),
                "4-cols" => esc_html__("4 columns", 'tradeace-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Limit Products Per Page", 'tradeace-theme'),
            "id" => "products_pr_page",
            "std" => "16",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Default Type View", 'tradeace-theme'),
            "id" => "products_type_view",
            "std" => "grid",
            "type" => "select",
            "options" => array(
                "grid" => esc_html__("Grid view default", 'tradeace-theme'),
                "list" => esc_html__("List view default", 'tradeace-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Results info in top", 'tradeace-theme'),
            "id" => "showing_info_top",
            "desc" => esc_html__("Note: don't using for Sidebar Off-canvas and Toggle Sidebar Classic", 'tradeace-theme'),
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Change View As (Only Desktop Mode)", 'tradeace-theme'),
            "id" => "enable_change_view",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Option 2 Columns", 'tradeace-theme'),
            "id" => "option_2_cols",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Option 6 Columns", 'tradeace-theme'),
            "id" => "option_6_cols",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Layout Style", 'tradeace-theme'),
            "id" => "products_layout_style",
            "std" => "grid_row",
            "type" => "select",
            "options" => array(
                "grid-row" => esc_html__("Grid row", 'tradeace-theme'),
                "masonry-isotope" => esc_html__("Masonry Isotope", 'tradeace-theme')
            ),
            'class' => 'tradeace-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Isotope Layout Mode", 'tradeace-theme'),
            "id" => "products_masonry_mode",
            "std" => "masonry",
            "type" => "select",
            "options" => array(
                "masonry" => esc_html__("Masonry", 'tradeace-theme'),
                "fitRows" => esc_html__("Fit Rows", 'tradeace-theme')
            ),
            
            'class' => 'tradeace-products_layout_style tradeace-products_layout_style-masonry-isotope tradeace-theme-option-child'
        );

        $of_options[] = array(
            "name" => esc_html__("Pagination Layout", 'tradeace-theme'),
            "id" => "pagination_style",
            "std" => 'style-2',
            "type" => "select",
            "options" => array(
                "style-2" => esc_html__("Simple", 'tradeace-theme'),
                "style-1" => esc_html__("Full", 'tradeace-theme'),
                "infinite" => esc_html__("Infinite - Only using for Ajax", 'tradeace-theme'),
                "load-more" => esc_html__("Load More - Only using for Ajax", 'tradeace-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable Ajax Shop", 'tradeace-theme'),
            "id" => "disable_ajax_product",
            "desc" => esc_html__("Yes, Please!", 'tradeace-theme'),
            "std" => 0,
            "type" => "checkbox"
        );

        $of_options[] = array(
            "name" => esc_html__("Show Title In Line", 'tradeace-theme'),
            "id" => "cutting_product_name",
            "desc" => esc_html__("Only show title product on one line if it is too long.", 'tradeace-theme'),
            "std" => "1",
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Top - Bottom Content Products Page", 'tradeace-theme'),
            "std" => "<h4>" . esc_html__("Top - Bottom Content Products Page", 'tradeace-theme') . "</h4>",
            "type" => "info"
        );
        
        $arr_blocks =tradeace_admin_get_static_blocks();

        $of_options[] = array(
            "name" => esc_html__("Category top content", 'tradeace-theme'),
            "id" => "cat_header_content",
            "desc" => esc_html__("Please Create Static Block and Selected here to use.", 'tradeace-theme'),
            "type" => "select",
            "options" => $arr_blocks
        );
        
        $of_options[] = array(
            "name" => esc_html__("Category bottom content", 'tradeace-theme'),
            "desc" => esc_html__("Please Create Static Block and Selected here to use.", 'tradeace-theme'),
            "id" => "cat_footer_content",
            "type" => "select",
            "options" => $arr_blocks
        );
    }
}
