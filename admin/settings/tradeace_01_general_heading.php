<?php
add_action('init', 'tradeace_general_heading');
if (!function_exists('tradeace_general_heading')) {
    function tradeace_general_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("General", 'tradeace-theme'),
            "target" => 'general',
            "type" => "heading"
        );

        $of_options[] = array(
            "name" => esc_html__("Site Layout", 'tradeace-theme'),
            "id" => "site_layout",
            "std" => "wide",
            "type" => "select",
            "options" => array(
                "wide" => esc_html__("Wide", 'tradeace-theme'),
                "boxed" => esc_html__("Boxed", 'tradeace-theme')
            ),
            'class' => 'tradeace-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Add more width site (px)", 'tradeace-theme'),
            "desc" => esc_html__("The max-width of your site will be INPUT + 1200 (pixel).", 'tradeace-theme'),
            "id" => "plus_wide_width",
            "std" => "",
            "type" => "text"
        );

        $of_options[] = array(
            "name" => esc_html__("Site Background Color - Only use for Site Layout => Boxed", 'tradeace-theme'),
            "id" => "site_bg_color",
            "std" => "#eee",
            "type" => "color",
            'class' => 'tradeace-site_layout tradeace-site_layout-boxed tradeace-theme-option-child'
        );

        $of_options[] = array(
            "name" => esc_html__("Site Background Image - Only use for Site Layout => Boxed", 'tradeace-theme'),
            "id" => "site_bg_image",
            "std" => TRADEACE_THEME_URI . "/assets/images/bkgd1.jpg",
            "type" => "media",
            'class' => 'tradeace-site_layout tradeace-site_layout-boxed tradeace-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Dark Version", 'tradeace-theme'),
            "id" => "site_bg_dark",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable Login/Register Menu in Topbar", 'tradeace-theme'),
            "desc" => esc_html__("Yes, Please!", 'tradeace-theme'),
            "id" => "hide_tini_menu_acc",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Login/Register by Ajax form", 'tradeace-theme'),
            "id" => "login_ajax",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Account On Main Screen - Mobile Layout", 'tradeace-theme'),
            "id" => "main_screen_acc_mobile",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Captcha For Register Form", 'tradeace-theme'),
            "id" => "register_captcha",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Mobile Menu Layout", 'tradeace-theme'),
            "id" => "mobile_menu_layout",
            "std" => "light-new",
            "type" => "select",
            "options" => array(
                "light-new" => esc_html__("Light - Default", 'tradeace-theme'),
                "light" => esc_html__("Light - 2", 'tradeace-theme'),
                "dark" => esc_html__("Dark", 'tradeace-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Disable Transition Loading", 'tradeace-theme'),
            "desc" => esc_html__("Yes, Please!", 'tradeace-theme'),
            "id" => "disable_wow",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Delay Overlay (ms)", 'tradeace-theme'),
            "id" => "delay_overlay",
            "std" => "100",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Effect Before Load Site", 'tradeace-theme'),
            "id" => "effect_before_load",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Toggle Widgets Content", 'tradeace-theme'),
            "id" => "toggle_widgets",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Include Theme Version when call Main js", 'tradeace-theme'),
            "id" => "js_theme_version",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("GDPR Options", 'tradeace-theme'),
            "std" => "<h4>" . esc_html__("GDPR Options", 'tradeace-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("GDPR Notice", 'tradeace-theme'),
            "id" => "tradeace_gdpr_notice",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("GDPR Policies Link", 'tradeace-theme'),
            "id" => "tradeace_gdpr_policies",
            "std" => "https://policies.google.com",
            "type" => "text"
        );
        
        $list_css = tradeace_get_list_css_files_call();
        if (!empty($list_css)) {
            $actived = array();
            foreach ($list_css as $key => $value) {
                $actived[$key] = 1;
            }
            
            $of_options[] = array(
                "name" => esc_html__("CSS Files Manager", 'tradeace-theme'),
                "std" => "<h4>" . esc_html__("CSS Files Manager", 'tradeace-theme') . "</h4>",
                "type" => "info"
            );

            $of_options[] = array(
                "name" => esc_html__("List Files CSS Called", 'tradeace-theme'),
                "desc" => esc_html__("You could uncheck if you don't want your site call it.", 'tradeace-theme'),
                "id" => "css_files",
                "std" => $actived,
                "type" => "multicheck",
                "options" => $list_css,
            );
        }
    }
}
