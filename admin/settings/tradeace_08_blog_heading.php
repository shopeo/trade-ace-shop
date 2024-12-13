<?php
add_action('init', 'tradeace_blog_heading');
if (!function_exists('tradeace_blog_heading')) {
    function tradeace_blog_heading() {
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Blog", 'tradeace-theme'),
            "target" => 'blog',
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Single Layout", 'tradeace-theme'),
            "id" => "single_blog_layout",
            "std" => "left",
            "type" => "select",
            "options" => array(
                "left" => esc_html__("Left Sidebar", 'tradeace-theme'),
                "right" => esc_html__("Right Sidebar", 'tradeace-theme'),
                "no" => esc_html__("No Sidebar (Centered)", 'tradeace-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Archive Layout", 'tradeace-theme'),
            "id" => "blog_layout",
            "std" => "left",
            "type" => "select",
            "options" => array(
                "left" => esc_html__("Left Sidebar", 'tradeace-theme'),
                "right" => esc_html__("Right Sidebar", 'tradeace-theme'),
                "no" => esc_html__("No Sidebar (Centered)", 'tradeace-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Style", 'tradeace-theme'),
            "id" => "blog_type",
            "std" => "blog-standard",
            "type" => "select",
            "options" => array(
                "blog-standard" => esc_html__("Standard", 'tradeace-theme'),
                "blog-list" => esc_html__("List", 'tradeace-theme'),
                "blog-grid" => esc_html__("Grid", 'tradeace-theme'),
                "masonry-isotope" => esc_html__("Masonry isotope", 'tradeace-theme')
            )
        );
        
        /* ======================================================================= */
        
        $of_options[] = array(
            "name" => esc_html__("Heading for Archive Page", 'tradeace-theme'),
            "id" => "blog_heading",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Masonry isotope - Grid - Blog style", 'tradeace-theme'),
            "std" => "<h4>" . esc_html__("Masonry isotope - Grid - Blog style", 'tradeace-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns in desktop", 'tradeace-theme'),
            "id" => "masonry_blogs_columns_desk",
            "std" => "3-cols",
            "type" => "select",
            "options" => array(
                "2-cols" => esc_html__("2 columns", 'tradeace-theme'),
                "3-cols" => esc_html__("3 columns", 'tradeace-theme'),
                "4-cols" => esc_html__("4 columns", 'tradeace-theme'),
                "5-cols" => esc_html__("5 columns", 'tradeace-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns in Mobile", 'tradeace-theme'),
            "id" => "masonry_blogs_columns_small",
            "std" => "1-col",
            "type" => "select",
            "options" => array(
                "1-cols" => esc_html__("1 column", 'tradeace-theme'),
                "2-cols" => esc_html__("2 columns", 'tradeace-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns in Tablet", 'tradeace-theme'),
            "id" => "masonry_blogs_columns_tablet",
            "std" => "2-cols",
            "type" => "select",
            "options" => array(
                "1-col" => esc_html__("1 column", 'tradeace-theme'),
                "2-cols" => esc_html__("2 columns", 'tradeace-theme'),
                "3-cols" => esc_html__("3 columns", 'tradeace-theme')
            )
        );
        
        /* ======================================================================= */
        
        $of_options[] = array(
            "name" => esc_html__("Meta Info - Blog Style", 'tradeace-theme'),
            "std" => "<h4>" . esc_html__("Meta info - Blog style", 'tradeace-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Author info", 'tradeace-theme'),
            "id" => "show_author_info",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Datetime info", 'tradeace-theme'),
            "id" => "show_date_info",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Categories info", 'tradeace-theme'),
            "id" => "show_cat_info",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Tags info", 'tradeace-theme'),
            "id" => "show_tag_info",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Comment Count info", 'tradeace-theme'),
            "id" => "show_comment_info",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Readmore", 'tradeace-theme'),
            "id" => "show_readmore_blog",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Short description (Only use for Blog Grid layout)", 'tradeace-theme'),
            "id" => "show_desc_blog",
            "std" => 1,
            "type" => "switch"
        );
        
        /* ======================================================================= */
        
        $of_options[] = array(
            "name" => esc_html__("Single Page", 'tradeace-theme'),
            "std" => "<h4>" . esc_html__("Single Blog page", 'tradeace-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Main Image", 'tradeace-theme'),
            "id" => "main_single_post_image",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Categories info", 'tradeace-theme'),
            "id" => "single_cat_info",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Author - Date info", 'tradeace-theme'),
            "id" => "show_author_date_info",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Tags info", 'tradeace-theme'),
            "id" => "show_tags_info",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Share icons", 'tradeace-theme'),
            "id" => "show_share_icons_info",
            "std" => 1,
            "type" => "switch"
        );
        
        if (TRADEACE_CORE_ACTIVED) {
        
            $of_options[] = array(
                "name" => esc_html__("Related", 'tradeace-theme'),
                "id" => "relate_blogs",
                "std" => 1,
                "type" => "switch"
            );

            $of_options[] = array(
                "name" => esc_html__("Number for relate blog", 'tradeace-theme'),
                "id" => "relate_blogs_number",
                "std" => "10",
                "type" => "text"
            );

            $of_options[] = array(
                "name" => esc_html__("Columns Relate in desktop", 'tradeace-theme'),
                "id" => "relate_blogs_columns_desk",
                "std" => "3-cols",
                "type" => "select",
                "options" => array(
                    "3-cols" => esc_html__("3 columns", 'tradeace-theme'),
                    "4-cols" => esc_html__("4 columns", 'tradeace-theme'),
                    "5-cols" => esc_html__("5 columns", 'tradeace-theme')
                )
            );

            $of_options[] = array(
                "name" => esc_html__("Columns Relate in mobile", 'tradeace-theme'),
                "id" => "relate_blogs_columns_small",
                "std" => "1-col",
                "type" => "select",
                "options" => array(
                    "1-cols" => esc_html__("1 column", 'tradeace-theme'),
                    "2-cols" => esc_html__("2 columns", 'tradeace-theme')
                )
            );

            $of_options[] = array(
                "name" => esc_html__("Columns Relate in Tablet", 'tradeace-theme'),
                "id" => "relate_blogs_columns_tablet",
                "std" => "2-cols",
                "type" => "select",
                "options" => array(
                    "1-col" => esc_html__("1 column", 'tradeace-theme'),
                    "2-cols" => esc_html__("2 columns", 'tradeace-theme'),
                    "3-cols" => esc_html__("3 columns", 'tradeace-theme')
                )
            );
        }
    }
}
