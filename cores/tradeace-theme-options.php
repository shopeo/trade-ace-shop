<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * VC SETUP
 */
add_action('init', 'tradeace_vc_setup');
if (!function_exists('tradeace_vc_setup')) :

    function tradeace_vc_setup() {
        if (!class_exists('WPBakeryVisualComposerAbstract')){
            return;
        }
        
        global $tradeace_opt;

        /**
         * Row (add fullwidth)
         */
        vc_add_param('vc_row', array(
            "type" => 'checkbox',
            "heading" => esc_html__("Fullwidth ?", 'tradeace-theme'),
            "param_name" => "fullwidth",
            "value" => array(
                esc_html__('Yes, Please!', 'tradeace-theme') => '1'
            )
        ));
        
        /**
         * Add params from tab element
         */
        vc_add_param('vc_tta_tabs', array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", 'tradeace-theme'),
            "param_name" => "tabs_display_type",
            "value" => array(
                esc_html__('Classic 2D - No border', 'tradeace-theme') => '2d-no-border',
                esc_html__('Classic 2D - Radius', 'tradeace-theme') => '2d-radius',
                esc_html__('Classic 2D - Radius - Dash', 'tradeace-theme') => '2d-radius-dashed',
                esc_html__('Classic 2D - Has BG color', 'tradeace-theme') => '2d-has-bg',
                esc_html__('Classic 2D', 'tradeace-theme') => '2d',
                esc_html__('Classic 3D', 'tradeace-theme') => '3d',
                esc_html__('Slide', 'tradeace-theme') => 'slide'
            ),
            "std" => '2d-no-border'
        ));
        
        vc_add_param('vc_tta_tabs', array(
            "type" => "colorpicker",
            "heading" => esc_html__("Tabs Background color", 'tradeace-theme'),
            "param_name" => "tabs_bg_color",
            "std" => '#efefef',
            "dependency" => array(
                "element" => "tabs_display_type",
                "value" => array(
                    "2d-has-bg"
                )
            )
        ));
        
        vc_add_param('vc_tta_tabs', array(
            "type" => "colorpicker",
            "heading" => esc_html__("Tabs text color", 'tradeace-theme'),
            "param_name" => "tabs_text_color",
            "std" => '',
            "dependency" => array(
                "element" => "tabs_display_type",
                "value" => array(
                    "2d-has-bg"
                )
            )
        ));
        
        vc_add_param('vc_tta_accordion', array(
            "type" => "dropdown",
            "heading" => esc_html__("Layout", 'tradeace-theme'),
            "param_name" => "accordion_layout",
            'value' => array(
                esc_html__('Border Wrapper', 'tradeace-theme') => 'has-border',
                esc_html__('Without Border Wrapper', 'tradeace-theme') => 'no-border'
            ),
            'std' => 'has-border',
            "description" => esc_html__('Only use for Accordion.', 'tradeace-theme'),
        ));
        
        vc_add_param('vc_tta_accordion', array(
            "type" => "dropdown",
            "heading" => esc_html__("Toggle Icon", 'tradeace-theme'),
            "param_name" => "accordion_icon",
            'value' => array(
                esc_html__('Plus', 'tradeace-theme') => 'plus',
                esc_html__('Arrow', 'tradeace-theme') => 'arrow'
            ),
            'std' => 'plus',
            "description" => esc_html__('Only use for Accordion.', 'tradeace-theme'),
        ));
        
        vc_add_param('vc_tta_accordion', array(
            "type" => 'checkbox',
            "heading" => esc_html__("Hide First Section ?", 'tradeace-theme'),
            "param_name" => "accordion_hide_first",
            "value" => array(
                esc_html__('Yes, Please!', 'tradeace-theme') => '1'
            )
        ));
        
        vc_add_param('vc_tta_accordion', array(
            "type" => 'checkbox',
            "heading" => esc_html__("Show Multi", 'tradeace-theme'),
            "param_name" => "accordion_show_multi",
            "value" => array(
                esc_html__('Yes, Please!', 'tradeace-theme') => '1'
            )
        ));
        
        /**
         * Add params from section tab element
         */
        vc_add_param('vc_tta_section', array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon TradeaceTheme (Using for Section of Tabs)", 'tradeace-theme'),
            "param_name" => "section_tradeace_icon",
            "std" => '',
            'readonly' => 1,
            'description' => '<a class="tradeace-chosen-icon left" data-fill="section_tradeace_icon" href="javascript:void(0);">Click Here to Add Icon TradeaceTheme</a><a class="tradeace-remove-icon right" data-id="section_tradeace_icon" href="javascript:void(0);">Remove Icon TradeaceTheme</a><p class="tradeace-clearfix"></p>'
        ));
        
        /**
         * Add param from columns element
         */
        vc_add_param('vc_column', array(
            "type" => "dropdown",
            "heading" => esc_html__("Width full side", 'tradeace-theme'),
            "param_name" => "width_side",
            'value' => array(
                esc_html__('None', 'tradeace-theme') => '',
                esc_html__('Full width to left', 'tradeace-theme') => 'left',
                esc_html__('Full width to right', 'tradeace-theme') => 'right'
            ),
            'std' => '',
            "description" => esc_html__('Only use for Visual Composer Template.', 'tradeace-theme'),
        ));
        
        /**
         * For Mobile Layout
         */
        $option_mobile = !isset($tradeace_opt['enable_tradeace_mobile']) || $tradeace_opt['enable_tradeace_mobile'] ? true : false;
        
        if ($option_mobile) {
            /**
             * Hide on mobile for Row
             */
            vc_add_param('vc_row', array(
                "type" => 'checkbox',
                "heading" => esc_html__("Ignore on Mobile", 'tradeace-theme'),
                "param_name" => "hide_in_mobile",
                "value" => array(
                    esc_html__('Yes, Please!', 'tradeace-theme') => '1'
                )
            ));
            
            /**
             * Hide on mobile for Mobile
             */
            vc_add_param('vc_column', array(
                "type" => 'checkbox',
                "heading" => esc_html__("Ignore on Mobile", 'tradeace-theme'),
                "param_name" => "hide_in_mobile",
                "value" => array(
                    esc_html__('Yes, Please!', 'tradeace-theme') => '1'
                )
            ));
        }
        
        /**
         * Custom shortcode
         */
        $param_tradeace_sc_icons = array(
            "name" => esc_html__("Header Icons", 'tradeace-theme'),
            "base" => "tradeace_sc_icons",
            'icon' => 'icon-wpb-tradeacetheme',
            'description' => esc_html__("Header icons Cart | Wishlist | Compare", 'tradeace-theme'),
            "category" => esc_html__('Header Builder', 'tradeace-theme'),
            "params" => array(

                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show Mini Cart", 'tradeace-theme'),
                    "param_name" => "show_mini_cart",
                    "value" => array(
                        esc_html__('Yes', 'tradeace-theme') => 'yes',
                        esc_html__('No', 'tradeace-theme') => 'no'
                    ),
                    "std" => 'yes',
                    "admin_label" => true
                ),

                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show Mini Compare", 'tradeace-theme'),
                    "param_name" => "show_mini_compare",
                    "value" => array(
                        esc_html__('Yes', 'tradeace-theme') => 'yes',
                        esc_html__('No', 'tradeace-theme') => 'no'
                    ),
                    "std" => 'yes',
                    "admin_label" => true
                ),

                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show Mini Wishlist", 'tradeace-theme'),
                    "param_name" => "show_mini_wishlist",
                    "value" => array(
                        esc_html__('Yes', 'tradeace-theme') => 'yes',
                        esc_html__('No', 'tradeace-theme') => 'no'
                    ),
                    "std" => 'yes',
                    "admin_label" => true
                ),

                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Extra class name", 'tradeace-theme'),
                    "param_name" => "el_class",
                    "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'tradeace-theme')
                )
            )
        );
        vc_map($param_tradeace_sc_icons);

        /**
         * Search form in header
         */
        $param_tradeace_search = array(
            "name" => esc_html__("Header Search", 'tradeace-theme'),
            "base" => "tradeace_sc_search_form",
            'icon' => 'icon-wpb-tradeacetheme',
            'description' => esc_html__("Header search form", 'tradeace-theme'),
            "category" => esc_html__('Header Builder', 'tradeace-theme'),
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Extra class name", 'tradeace-theme'),
                    "param_name" => "el_class",
                    "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'tradeace-theme')
                )
            )
        );
        
        vc_map($param_tradeace_search);
        if (function_exists('tradeace_header_icons_sc')) {
            add_shortcode('tradeace_sc_icons', 'tradeace_header_icons_sc');
        }
        
        if (function_exists('tradeace_header_search_sc')) {
            add_shortcode('tradeace_sc_search_form', 'tradeace_header_search_sc');
        }
    }

endif;

/**
 * HTML Loader
 */
if (!function_exists('tradeace_loader_html')) :
    function tradeace_loader_html($id_attr = null, $relative = true) {
        $id = $id_attr != null ? ' id="' . esc_attr($id_attr) . '"' : '';
        $class = $relative ? ' class="tradeace-relative tradeace-fullsize"' : '';
        return 
            '<div' . $id . $class . '>' .
                '<div class="tradeace-loader"></div>' .
            '</div>';
    }
endif;

/**
 * Start captcha
 */
if (!function_exists('tradeace_start_session')) :
    function tradeace_start_session() {
        if (!session_id()) {
            session_start();
        }
    }
endif;

/**
 * Captcha for Register form
 */
add_action('init', 'tradeace_register_field_captcha_img');
if (!function_exists('tradeace_register_field_captcha_img')) :
    function tradeace_register_field_captcha_img() {
        global $tradeace_opt;
        if (!isset($tradeace_opt['register_captcha']) || !$tradeace_opt['register_captcha']) {
            return;
        }
        
        if (isset($_REQUEST['tradeace-captcha-register']) && $_REQUEST['tradeace-captcha-register'] === '1') {
            require_once TRADEACE_THEME_PATH . '/cores/tradeace-captcha.php';

            $captcha = new Tradeace_Captcha();
            $code = $captcha->get_and_show_image();

            tradeace_start_session();

            // Save code session
            $_SESSION['tradeace_captcha_code_' . $_REQUEST['tradeace-captcha-register']] = $code;

            die();
        }

        return;
    }
endif;

/**
 * Add field captcha for Register form
 */
add_action('woocommerce_register_form', 'tradeace_register_form_field_captcha');
if (!function_exists('tradeace_register_form_field_captcha')) :
    function tradeace_register_form_field_captcha() {
        global $tradeace_opt;
        if (!isset($tradeace_opt['register_captcha']) || !$tradeace_opt['register_captcha']) {
            return;
        }
        
        echo '<p class="tradeace-form-row-captcha hidden-tag"></p>';
    }
endif;

/**
 * Check error Captcha
 */
add_filter('woocommerce_registration_errors', 'tradeace_check_captcha_registration_errors', 10, 3);
if (!function_exists('tradeace_check_captcha_registration_errors')) :
    function tradeace_check_captcha_registration_errors($errors) {
        global $tradeace_opt;
        
        /**
         * Disable check Captcha
         */
        if (!isset($tradeace_opt['register_captcha']) || !$tradeace_opt['register_captcha']) {
            return $errors;
        }
        
        /**
         * Ignore when has not nonce field value
         */
        if (!isset($_REQUEST['woocommerce-register-nonce'])) {
            return $errors;
        }

        /**
         * Init check
         */
        $input = array();

        /**
         * For Ajax form
         */
        if (isset($_REQUEST['data']) && $_REQUEST['data']) {
            foreach ($_REQUEST['data'] as $values) {
                if (isset($values['name']) && isset($values['value'])) {
                    $input[$values['name']] = $values['value'];
                }
            }
        }

        /**
         * For Default form
         */
        else {
            if (isset($_REQUEST['tradeace-captcha-key'])) {
                $input['tradeace-captcha-key'] = $_REQUEST['tradeace-captcha-key'];
            }

            if (isset($_REQUEST['tradeace-input-captcha'])) {
                $input['tradeace-input-captcha'] = $_REQUEST['tradeace-input-captcha'];
            }
        }
        
        /**
         * Check error Captcha
         */
        tradeace_start_session();
        if (
            !isset($input['tradeace-captcha-key']) ||
            !isset($input['tradeace-input-captcha']) ||
            !isset($_SESSION['tradeace_captcha_code_' . $input['tradeace-captcha-key']]) ||
            $_SESSION['tradeace_captcha_code_' . $input['tradeace-captcha-key']] != strtolower($input['tradeace-input-captcha'])) {
            $errors->add('tradeace-captcha-register', esc_html__('Captcha Error!', 'tradeace-theme'));
        }

        return $errors;
    }
endif;
