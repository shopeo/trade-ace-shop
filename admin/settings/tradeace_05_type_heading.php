<?php
add_action('init', 'tradeace_type_heading');
if (!function_exists('tradeace_type_heading')) {
    function tradeace_type_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $google_fonts = tradeace_get_google_fonts();
	
        $custom_fonts = tradeace_get_custom_fonts();
        
        $of_options[] = array(
            "name" => esc_html__("Fonts", 'tradeace-theme'),
            "target" => 'fonts',
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Type Font", 'tradeace-theme'),
            "id" => "type_font_select",
            "std" => "google",
            "type" => "select",
            "options" => array(
                "" => esc_html__("Default font", 'tradeace-theme'),
                "custom" => esc_html__("Custom font", 'tradeace-theme'),
                "google" => esc_html__("Google font", 'tradeace-theme')
            ),
            'class' => 'tradeace-type-font'
        );

        $of_options[] = array(
            "name" => esc_html__("Heading fonts (H1, H2, H3, H4, H5, H6)", 'tradeace-theme'),
            "id" => "type_headings",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => '<strong>' . esc_html__("TradeaceTheme", 'tradeace-theme') . '</strong><br /><span style="font-size:60%!important">' . esc_html__("UPPERCASE TEXT", 'tradeace-theme') . '</span>',
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag tradeace-type-font-glb tradeace-type-font-google'
        );
        
        $of_options[] = array(
            "name" => esc_html__("RTL - Heading fonts (H1, H2, H3, H4, H5, H6)", 'tradeace-theme'),
            "id" => "type_headings_rtl",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => '<strong>' . esc_html__("TradeaceTheme", 'tradeace-theme') . '</strong><br /><span style="font-size:60%!important">' . esc_html__("UPPERCASE TEXT", 'tradeace-theme') . '</span>',
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag tradeace-d-rtl tradeace-type-font-glb tradeace-type-font-google'
        );

        $of_options[] = array(
            "name" => esc_html__("Text fonts (paragraphs, etc..)", 'tradeace-theme'),
            "id" => "type_texts",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => esc_html__("Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum dolor sit amet, consectetur Nulla fringilla purus at leo dignissim congue. Mauris elementum accumsan leo vel tempor. Sit amet cursus nisl aliquam. Aliquam et elit eu nunc rhoncus viverra quis at felis..", 'tradeace-theme'),
                "size" => "14px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag tradeace-type-font-glb tradeace-type-font-google'
        );
        
        $of_options[] = array(
            "name" => esc_html__("RTL - Text fonts (paragraphs, etc..)", 'tradeace-theme'),
            "id" => "type_texts_rtl",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => esc_html__("Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum dolor sit amet, consectetur Nulla fringilla purus at leo dignissim congue. Mauris elementum accumsan leo vel tempor. Sit amet cursus nisl aliquam. Aliquam et elit eu nunc rhoncus viverra quis at felis..", 'tradeace-theme'),
                "size" => "14px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag tradeace-d-rtl tradeace-type-font-glb tradeace-type-font-google'
        );

        $of_options[] = array(
            "name" => esc_html__("Main navigation", 'tradeace-theme'),
            "id" => "type_nav",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => "<span style='font-size:45%'>" . esc_html__("THIS IS THE TEXT.", 'tradeace-theme') . "</span>",
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag tradeace-type-font-glb tradeace-type-font-google'
        );
        
        $of_options[] = array(
            "name" => esc_html__("RTL - Main navigation", 'tradeace-theme'),
            "id" => "type_nav_rtl",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => "<span style='font-size:45%'>" . esc_html__("THIS IS THE TEXT.", 'tradeace-theme') . "</span>",
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag tradeace-d-rtl tradeace-type-font-glb tradeace-type-font-google'
        );

        $of_options[] = array(
            "name" => esc_html__("Banner font", 'tradeace-theme'),
            "id" => "type_banner",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => esc_html__("This is the text.", 'tradeace-theme'),
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag tradeace-type-font-glb tradeace-type-font-google'
        );
        
        $of_options[] = array(
            "name" => esc_html__("RTL - Banner font", 'tradeace-theme'),
            "id" => "type_banner_rtl",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => esc_html__("This is the text.", 'tradeace-theme'),
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag tradeace-d-rtl tradeace-type-font-glb tradeace-type-font-google'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Price font", 'tradeace-theme'),
            "id" => "type_price",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => esc_html__("$999.", 'tradeace-theme'),
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag tradeace-type-font-glb tradeace-type-font-google'
        );
        
        $of_options[] = array(
            "name" => esc_html__("RTL - Price font", 'tradeace-theme'),
            "id" => "type_price_rtl",
            "std" => "Nunito Sans",
            "type" => "select_google_font",
            "preview" => array(
                "text" => esc_html__("$999.", 'tradeace-theme'),
                "size" => "30px"
            ),
            "options" => $google_fonts,
            'class' => 'hidden-tag tradeace-d-rtl tradeace-type-font-glb tradeace-type-font-google'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Google Max Font-Weight", 'tradeace-theme'),
            "id" => "max_font_weight",
            "std" => "900",
            "type" => "select",
            "options" => array(
                '900' => esc_html__("Bold - 900", 'tradeace-theme'),
                '800' => esc_html__("Bold - 800", 'tradeace-theme'),
                '700' => esc_html__("Bold - 700", 'tradeace-theme'),
                '600' => esc_html__("Bold - 600", 'tradeace-theme')
            ),
            'override_numberic' => true,
            'class' => 'hidden-tag tradeace-type-font-glb tradeace-type-font-google'
        );

        $of_options[] = array(
            "name" => esc_html__("Character Sub-sets", 'tradeace-theme'),
            "id" => "type_subset",
            "std" => array("latin"),
            "type" => "multicheck",
            "options" => array(
                "latin"         => esc_html__("Latin", 'tradeace-theme'),
                "arabic"        => esc_html__("Arabic", 'tradeace-theme'),
                "cyrillic"      => esc_html__("Cyrillic", 'tradeace-theme'),
                "cyrillic-ext"  => esc_html__("Cyrillic Extended", 'tradeace-theme'),
                "greek"         => esc_html__("Greek", 'tradeace-theme'),
                "greek-ext"     => esc_html__("Greek Extended", 'tradeace-theme'),
                "vietnamese"    => esc_html__("Vietnamese", 'tradeace-theme'),
                "latin-ext"     => esc_html__("Latin Extended", 'tradeace-theme')
            ),
            'class' => 'hidden-tag tradeace-type-font-glb tradeace-type-font-google'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Upload Custom Font", 'tradeace-theme'),
            "std" => "",
            "type" => "tradeace_upload_custom_font",
            'class' => 'hidden-tag tradeace-type-font-glb tradeace-type-font-custom'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Select Custom Font", 'tradeace-theme'),
            "id" => "custom_font",
            "std" => "",
            "type" => "select",
            "options" => $custom_fonts,
            'class' => 'hidden-tag tradeace-type-font-glb tradeace-type-font-custom'
        );
        
        $of_options[] = array(
            "name" => esc_html__("RTL - Select Custom Font", 'tradeace-theme'),
            "id" => "custom_font_rtl",
            "std" => "",
            "type" => "select",
            "options" => $custom_fonts,
            'class' => 'hidden-tag tradeace-type-font-glb tradeace-type-font-custom'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Minify Fonts Icons", 'tradeace-theme'),
            "id" => "minify_font_icons",
            "std" => 1,
            "type" => "switch",
            "desc" => "Include: Font Tradeace Icons, Font Awesome 4.7.0, Font Pe-icon-7-stroke"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Include FontAwesome 5.0.13 (Note: You only can use Free icons)", 'tradeace-theme'),
            "id" => "include_font_awesome_new",
            "std" => 0,
            "type" => "switch"
        );
    }
}
