<?php
add_action('init', 'tradeace_header_footer_heading');
if (!function_exists('tradeace_header_footer_heading')) {
    function tradeace_header_footer_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $header_blocks = tradeace_admin_get_static_blocks();
        
        $of_options[] = array(
            "name" => esc_html__("Header and Footer", 'tradeace-theme'),
            "target" => 'header-footer',
            "type" => "heading"
        );

        $of_options[] = array(
            "name" => esc_html__("Header Option", 'tradeace-theme'),
            "std" => "<h4>" . esc_html__("Header Option", 'tradeace-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Header Layout", 'tradeace-theme'),
            "id" => "header-type",
            "std" => "1",
            "type" => "images",
            "options" => array(
                '1' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/header-1.jpg',
                '2' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/header-2.jpg',
                '3' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/header-3.jpg',
                '4' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/header-4.jpg',
                '5' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/header-5.jpg',
                'tradeace-custom' => TRADE_ACE_ADMIN_DIR_URI . 'assets/images/header-builder.gif'
            ),
            
            'class' => 'tradeace-header-type-select tradeace-theme-option-parent'
        );
        
    
        
        /**
         * Header Builder
         */
        $header_builder = tradeace_admin_get_header_builder();
        $header_options = array_merge(
            array('default' => esc_html__('Select the Header Builder', 'tradeace-theme')),
            $header_builder
        );
        
        $of_options[] = array(
            "name" => esc_html__("Header Builder", 'tradeace-theme'),
            "id" => "header-custom",
            "type" => "select",
            'override_numberic' => true,
            "options" => $header_options,
            'std' => '',
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-tradeace-custom tradeace-header-custom'
        );
        
        $option_menu =tradeace_admin_get_menu_options();
        
        $of_options[] = array(
            "name" => esc_html__("Vertical Menu", 'tradeace-theme'),
            "id" => "vertical_menu_selected",
            "std" => "",
            "type" => "select",
            'override_numberic' => true,
            "options" => $option_menu,
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-4'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Ordering Mobile Menu", 'tradeace-theme'),
            "id" => "order_mobile_menus",
            "std" => "",
            "type" => "select",
            'override_numberic' => true,
            "options" => array(
                '' => esc_html__("Main Menu > Vertical Menu", 'tradeace-theme'),
                'v-focus' => esc_html__("Vertical Menu > Main Menu", 'tradeace-theme'),
            ),
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-4'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Fullwidth Main Menu", 'tradeace-theme'),
            "id" => "fullwidth_main_menu",
            "std" => 1,
            "type" => "switch",
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-2 tradeace-header-type-select-3 tradeace-fullwidth_main_menu'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Transparent Header", 'tradeace-theme'),
            "id" => "header_transparent",
            "std" => 0,
            "type" => "switch",
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-1 tradeace-header-type-select-2 tradeace-header-type-select-3 tradeace-header_transparent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("The Block Under Header", 'tradeace-theme'),
            "desc" => esc_html__("Please Create Static Block and Selected here to use.", 'tradeace-theme'),
            "id" => "header-block",
            "type" => "select",
            "options" => $header_blocks,
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-1 tradeace-header-type-select-2 tradeace-header-type-select-3 tradeace-header-type-select-4 tradeace-header-block'
        );

        $of_options[] = array(
            "name" => esc_html__("Sticky", 'tradeace-theme'),
            "id" => "fixed_nav",
            "std" => 1,
            "type" => "switch",
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-1 tradeace-header-type-select-2 tradeace-header-type-select-3 tradeace-header-type-select-4 tradeace-fixed_nav'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Search Bar Effect", 'tradeace-theme'),
            "id" => "search_effect",
            "std" => "right-to-left",
            "type" => "select",
            "options" => array(
                "rightToLeft" => esc_html__("Right To Left", 'tradeace-theme'),
                "fadeInDown" => esc_html__("Fade In Down", 'tradeace-theme'),
                "fadeInUp" => esc_html__("Fade In Up", 'tradeace-theme'),
                "leftToRight" => esc_html__("Left To Right", 'tradeace-theme'),
                "fadeIn" => esc_html__("Fade In", 'tradeace-theme'),
                "noEffect" => esc_html__("No Effect", 'tradeace-theme')
            ),
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-1 tradeace-header-type-select-2 tradeace-search_effect'
        );

        $of_options[] = array(
            "name" => esc_html__("Toggle Top Bar", 'tradeace-theme'),
            "id" => "topbar_toggle",
            "std" => 0,
            "type" => "switch",
            'class' => 'hidden-tag tradeace-topbar_toggle tradeace-header-type-child tradeace-header-type-select-1 tradeace-header-type-select-2 tradeace-header-type-select-3 tradeace-header-type-select-4 tradeace-fixed_nav'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Default Top Bar Show", 'tradeace-theme'),
            "id" => "topbar_default_show",
            "std" => 1,
            "type" => "switch",
            'class' => 'hidden-tag tradeace-topbar_df-show'
        );

        $of_options[] = array(
            "name" => esc_html__("Languages Switcher - Requires WPML", 'tradeace-theme'),
            "id" => "switch_lang",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Currencies Switcher - Requires WPML", 'tradeace-theme'),
            "id" => "switch_currency",
            "std" => 0,
            "type" => "switch"
        );
        
        //(%symbol%) %code%
        $of_options[] = array(
            "name" => esc_html__("Format Currency", 'tradeace-theme'),
            "desc" => esc_html__("Default (%symbol%) %code%. You can custom for this. Ex (%name% (%symbol%) - %code%)", 'tradeace-theme'),
            "id" => "switch_currency_format",
            "std" => "",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Topbar Content", 'tradeace-theme'),
            "desc" => esc_html__("Please Create Static Block and Selected here to use.", 'tradeace-theme'),
            "id" => "topbar_content",
            "type" => "select",
            "options" => $header_blocks,
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-1 tradeace-header-type-select-2 tradeace-header-type-select-3 tradeace-header-type-select-4 tradeace-topbar_content'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Toggle Header Icons - Responsive mode", 'tradeace-theme'),
            "id" => "topbar_mobile_icons_toggle",
            "std" => 0,
            "type" => "switch",
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-1 tradeace-header-type-select-2 tradeace-header-type-select-3 tradeace-header-type-select-4 tradeace-topbar_mobile_icons_toggle'
        );

        $of_options[] = array(
            "name" => esc_html__("Header Elements", 'tradeace-theme'),
            "std" => "<h4>" . esc_html__("Header Elements", 'tradeace-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Topbar Background", 'tradeace-theme'),
            "id" => "bg_color_topbar",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Topbar Text color", 'tradeace-theme'),
            "id" => "text_color_topbar",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Topbar Text color hover", 'tradeace-theme'),
            "id" => "text_color_hover_topbar",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Background Color Header", 'tradeace-theme'),
            "id" => "bg_color_header",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-1 tradeace-header-type-select-2 tradeace-header-type-select-3 tradeace-header-type-select-4 tradeace-bg_color_header'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Header Icons", 'tradeace-theme'),
            "id" => "text_color_header",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-1 tradeace-header-type-select-2 tradeace-header-type-select-3 tradeace-header-type-select-4 tradeace-text_color_header'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Header Icons Hover", 'tradeace-theme'),
            "id" => "text_color_hover_header",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-1 tradeace-header-type-select-2 tradeace-header-type-select-3 tradeace-header-type-select-4 tradeace-text_color_hover_header'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Main Menu Background Color", 'tradeace-theme'),
            "id" => "bg_color_main_menu",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-2 tradeace-header-type-select-3 tradeace-header-type-select-4 tradeace-bg_color_main_menu'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Main Menu Text Color", 'tradeace-theme'),
            "id" => "text_color_main_menu",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag tradeace-header-type-child tradeace-header-type-select-1 tradeace-header-type-select-2 tradeace-header-type-select-3 tradeace-header-type-select-4 tradeace-text_color_main_menu'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Footer Option", 'tradeace-theme'),
            "std" => "<h4>" . esc_html__("Footer Option", 'tradeace-theme') . "</h4>",
            "type" => "info"
        );
        
        $footer_mode = TRADEACE_ELEMENTOR_ACTIVE ? "build-in" : "builder";
        $modes = array(
            "build-in" => esc_html__("Build-in", 'tradeace-theme'),
            "builder" => esc_html__("Builder", 'tradeace-theme')
        );
        if (TRADEACE_ELEMENTOR_ACTIVE && TRADEACE_HF_BUILDER) {
            $modes["builder-e"] = esc_html__("Elementor Builder", 'tradeace-theme');
        }
        
        $of_options[] = array(
            "name" => esc_html__("Mode", 'tradeace-theme'),
            "id" => "footer_mode",
            "std" => $footer_mode,
            "type" => "select",
            "options" => $modes,
            'class' => 'tradeace-theme-option-parent'
        );
        
        /**
         * Footer Build-in Desktop
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Layout", 'tradeace-theme'),
            "id" => "footer_build_in",
            "type" => "select",
            'override_numberic' => true,
            "options" => array(
                '1' => esc_html__("Build-in Light 1", 'tradeace-theme'),
                '2' => esc_html__("Build-in Light 2", 'tradeace-theme'),
                '3' => esc_html__("Build-in Light 3", 'tradeace-theme'),
                '4' => esc_html__("Build-in Dark", 'tradeace-theme')
            ),
            'std' => '2',
            'class' => 'tradeace-footer_mode tradeace-footer_mode-build-in tradeace-theme-option-child'
        );
        
        /**
         * Footer Build-in Mobile
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Mobile Layout", 'tradeace-theme'),
            "id" => "footer_build_in_mobile",
            "type" => "select",
            'override_numberic' => true,
            "options" => array(
                '' => esc_html__("Extends from Desktop", 'tradeace-theme'),
                'm-1' => esc_html__("Build-in Mobile", 'tradeace-theme')
            ),
            'std' => '',
            'class' => 'tradeace-footer_mode tradeace-footer_mode-build-in tradeace-theme-option-child'
        );
        
        /**
         * Footers Builder
         */
        $footers_options = tradeace_admin_get_footer_builder();
        
        $footers_desk = array_merge(
            array('default' => esc_html__('Select the Footer Type', 'tradeace-theme')),
            $footers_options
        );
        $footers_mobile = array_merge(
            array('default' => esc_html__('Extends from Desktop', 'tradeace-theme')),
            $footers_options
        );
        
        /**
         * Footer Desktop
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Layout", 'tradeace-theme'),
            "id" => "footer-type",
            "type" => "select",
            'override_numberic' => true,
            "options" => $footers_desk,
            'std' => 'default',
            'class' => 'tradeace-footer_mode tradeace-footer_mode-builder tradeace-theme-option-child'
        );
        
        /**
         * Footer Mobile
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Mobile Layout", 'tradeace-theme'),
            "id" => "footer-mobile",
            "type" => "select",
            'override_numberic' => true,
            "options" => $footers_mobile,
            'std' => 'default',
            'class' => 'tradeace-footer_mode tradeace-footer_mode-builder tradeace-theme-option-child'
        );
        
        /**
         * Footers Elementor Builder
         */
        $footers_options = tradeace_admin_get_footer_elementor();
        $footers_desk = $footers_options;
        $footers_desk['0'] = esc_html__('Select the Footer Elementor', 'tradeace-theme');
        $footers_mobile = $footers_options;
        $footers_mobile['0'] = esc_html__('Extends from Desktop', 'tradeace-theme');
        
        /**
         * Footer Desktop
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Layout", 'tradeace-theme'),
            "id" => "footer_elm",
            "type" => "select",
            'override_numberic' => true,
            "options" => $footers_desk,
            'std' => 'default',
            'class' => 'tradeace-footer_mode tradeace-footer_mode-builder-e tradeace-theme-option-child'
        );
        
        /**
         * Footer Mobile
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Mobile Layout", 'tradeace-theme'),
            "id" => "footer_elm_mobile",
            "type" => "select",
            'override_numberic' => true,
            "options" => $footers_mobile,
            'std' => 'default',
            'class' => 'tradeace-footer_mode tradeace-footer_mode-builder-e tradeace-theme-option-child'
        );
    }
}
