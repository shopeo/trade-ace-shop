<?php
class Trade_Ace_DF_Page_Importer {

    /**
     * Default page WPBakery
     * 
     * @global type $tradeace_current_user_id
     * @return type
     */
    public static function tradeace_wpb_default_page() {
        global $tradeace_current_user_id;

        if (!isset($tradeace_current_user_id)) {
            $tradeace_current_user_id = get_current_user_id();
            $GLOBALS['tradeace_current_user_id'] = $tradeace_current_user_id;
        }

        $time_now = current_time('mysql', 1);
        $time_now_int = time();

        $post_default = array(
            'post_author' => $tradeace_current_user_id,
            'post_date' => $time_now,
            'post_date_gmt' => $time_now,
            'post_content' => '',
            'post_title' => 'WPB - Title Page',
            'post_excerpt' => '',
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_password' => '',
            'post_name' => 'ELM - Slug Page',
            'to_ping' => '',
            'pinged' => '',
            'post_modified' => $time_now,
            'post_modified_gmt' => $time_now,
            'post_content_filtered' => '',
            'post_parent' => 0,
            'guid' => '',
            'menu_order' => 0,
            'post_type' => 'page',
            'post_mime_type' => '',
            'comment_count' => 0
        );

        $post_meta = array(
            '_edit_last' => 1,
            '_edit_lock' => $time_now_int . ':1',

            '_tradeace_plus_wide_option' => '',
            '_tradeace_plus_wide_width' => '',

            '_tradeace_custom_logo_id' => '',
            '_tradeace_custom_logo_retina_id' => '',

            '_tradeace_custom_header' => '',
            '_tradeace_header_transparent' => '',
            '_tradeace_header_block' => '',
            '_tradeace_el_class_header' => '',

            '_tradeace_topbar_default_show' => '',
            '_tradeace_topbar_toggle' => '',
            '_tradeace_text_color_topbar' => '',
            '_tradeace_text_color_hover_topbar' => '',
            '_tradeace_bg_color_topbar' => '',
            '_tradeace_bg_color_main_menu' => '',
            '_tradeace_text_color_main_menu' => '',
            '_tradeace_fullwidth_main_menu' => '',
            '_tradeace_vertical_menu_selected' => '',
            '_tradeace_vertical_menu_allways_show' => '',
            '_tradeace_fixed_nav' => '',

            '_tradeace_pri_color_flag' => '',
            '_tradeace_pri_color' => '',

            '_tradeace_footer_mode' => '',
            '_tradeace_custom_footer' => '',
            '_tradeace_custom_footer_mobile' => '',

            '_tradeace_type_font_select' => '',
            '_tradeace_type_headings' => '',
            '_tradeace_type_banner' => '',
            '_tradeace_type_nav' => '',
            '_tradeace_type_price' => '',
            '_tradeace_type_texts' => '',
            
            '_tradeace_show_breadcrumb' => '',

            '_wp_page_template' => 'page-visual-composer.php',
            '_wpb_shortcodes_custom_css' => '',
            '_wpb_vc_js_status' => 'false',
            'slide_template' => 'default',
            'rs_page_bg_color' => '#ffffff',
            
            '_tradeace_site_bg_dark' => '',
        );

        return array(
            'post' => $post_default,
            'post_meta' => $post_meta
        );
    }

    /**
     * Default page Elementor
     * 
     * @global type $tradeace_current_user_id
     * @return type
     */
    public static function tradeace_elm_default_page() {
        global $tradeace_current_user_id;

        if (!isset($tradeace_current_user_id)) {
            $tradeace_current_user_id = get_current_user_id();
            $GLOBALS['tradeace_current_user_id'] = $tradeace_current_user_id;
        }

        $time_now = current_time('mysql', 1);
        $time_now_int = time();

        $post_default = array(
            'post_author' => $tradeace_current_user_id,
            'post_date' => $time_now,
            'post_date_gmt' => $time_now,
            'post_content' => '',
            'post_title' => 'ELM - Title Page',
            'post_excerpt' => '',
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_password' => '',
            'post_name' => 'ELM - Slug Page',
            'to_ping' => '',
            'pinged' => '',
            'post_modified' => $time_now,
            'post_modified_gmt' => $time_now,
            'post_content_filtered' => '',
            'post_parent' => 0,
            'guid' => '',
            'menu_order' => 0,
            'post_type' => 'page',
            'post_mime_type' => '',
            'comment_count' => 0
        );

        $post_meta = array(
            '_edit_last' => 1,
            '_edit_lock' => $time_now_int . ':1',
            '_elementor_edit_mode' => 'builder',
            '_elementor_template_type' => 'wp-page',
            '_elementor_version' => ELEMENTOR_VERSION,
            '_wp_page_template' => 'default',
            '_elementor_data' => 'elm-data-serialize',
            'slide_template' => '',
            'rs_page_bg_color' => '',
            '_elementor_controls_usage' => '',
            '_elementor_css' => '',

            '_tradeace_plus_wide_option' => '',
            '_tradeace_plus_wide_width' => '',

            '_tradeace_custom_logo_id' => '',
            '_tradeace_custom_logo_retina_id' => '',

            '_tradeace_custom_header' => '',
            '_tradeace_header_transparent' => '',
            '_tradeace_header_block' => '',
            '_tradeace_el_class_header' => '',

            '_tradeace_topbar_default_show' => '',
            '_tradeace_topbar_toggle' => '',
            '_tradeace_text_color_topbar' => '',
            '_tradeace_text_color_hover_topbar' => '',
            '_tradeace_bg_color_topbar' => '',
            '_tradeace_bg_color_main_menu' => '',
            '_tradeace_text_color_main_menu' => '',
            '_tradeace_fullwidth_main_menu' => '',
            '_tradeace_vertical_menu_selected' => '',
            '_tradeace_vertical_menu_allways_show' => '',
            '_tradeace_fixed_nav' => '',

            '_tradeace_pri_color_flag' => '',
            '_tradeace_pri_color' => '',

            '_tradeace_footer_mode' => '',
            '_tradeace_footer_build_in' => '',
            '_tradeace_footer_build_in_mobile' => '',

            '_tradeace_type_font_select' => '',
            '_tradeace_type_headings' => '',
            '_tradeace_type_banner' => '',
            '_tradeace_type_nav' => '',
            '_tradeace_type_price' => '',
            '_tradeace_type_texts' => '',
            
            '_tradeace_show_breadcrumb' => '',
            
            '_tradeace_site_bg_dark' => '',
        );

        return array(
            'post' => $post_default,
            'post_meta' => $post_meta,
            'css' => ''
        );
    }
    
    /**
     * Default page Elementor Footer Builder
     * 
     * @global type $tradeace_current_user_id
     * @return type
     */
    public static function tradeace_elm_default_footer() {
        global $tradeace_current_user_id;

        if (!isset($tradeace_current_user_id)) {
            $tradeace_current_user_id = get_current_user_id();
            $GLOBALS['tradeace_current_user_id'] = $tradeace_current_user_id;
        }

        $time_now = current_time('mysql', 1);
        $time_now_int = time();

        $post_default = array(
            'post_author' => $tradeace_current_user_id,
            'post_date' => $time_now,
            'post_date_gmt' => $time_now,
            'post_content' => '',
            'post_title' => 'ELM - Title Footer',
            'post_excerpt' => '',
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_password' => '',
            'post_name' => 'ELM - Slug Footer',
            'to_ping' => '',
            'pinged' => '',
            'post_modified' => $time_now,
            'post_modified_gmt' => $time_now,
            'post_content_filtered' => '',
            'post_parent' => 0,
            'guid' => '',
            'menu_order' => 0,
            'post_type' => 'elementor-hf',
            'post_mime_type' => '',
            'comment_count' => 0
        );

        $post_meta = array(
            '_edit_last' => 1,
            '_edit_lock' => $time_now_int . ':1',
            '_elementor_edit_mode' => 'builder',
            '_elementor_template_type' => 'wp-post',
            '_elementor_version' => ELEMENTOR_VERSION,
            '_wp_page_template' => 'default',
            '_elementor_data' => 'elm-data-serialize',
            '_elementor_controls_usage' => '',
            'ehf_target_include_locations' => 'a:0:{}',
            'ehf_target_exclude_locations' => 'a:0:{}',
            'ehf_target_user_roles' => 'a:1:{i:0;s:0:"";}',
            'ehf_template_type' => '',

            'rs_page_bg_color' => '',
        );

        return array(
            'post' => $post_default,
            'post_meta' => $post_meta,
            'css' => ''
        );
    }

    /**
     * Render data
     * 
     * @param type $type
     * @param type $data
     * @return type
     */
    public static function tradeace_render_page_data($type, $data) {
        if (!in_array($type, array('wpb', 'elm', 'hfe'))) {
            return null;
        }
        
        switch ($type) {
            case 'wpb':
                $default_data = self::tradeace_wpb_default_page();
                break;
            
            case 'elm':
                $default_data = self::tradeace_elm_default_page();
                break;
            
            case 'hfe':
                $default_data = self::tradeace_elm_default_footer();
                break;
        } 

        foreach ($default_data as $name => $res) {
            if (isset($data[$name])) {
                if ($name !== 'css') {
                    foreach ($res as $key => $value) {
                        if (isset($data[$name][$key])) {
                            $default_data[$name][$key] = $data[$name][$key];
                        }
                    }
                } else {
                    $default_data[$name] = $data[$name];
                }
            }
        }

        return $default_data;
    }

    /**
     * Insert Page
     * 
     * @global type $wpdb
     * @param type $data
     * @return string|int
     */
    public static function tradeace_insert_page_data($data = array()) {
        if (!isset($data['post']) || empty($data['post'])) {
            return false;
        }

        global $wpdb;

        if (false === $wpdb->insert($wpdb->posts, $data['post'])) {
            return 0;
        }

        return (int) $wpdb->insert_id;
    }

    /**
     * Insert Meta
     * 
     * @param type $data
     * @return string|int
     */
    public static function tradeace_insert_page_meta($page_id, $data = array()) {
        if (!isset($data['post_meta']) || empty($data['post_meta'])) {
            return false;
        }

        try {
            global $wpdb;

            foreach ($data['post_meta'] as $key => $value) {
                if ($value !== '') {
                    $meta_data = array(
                        'post_id' => $page_id,
                        'meta_key' => $key,
                        'meta_value' => $value
                    );

                    $wpdb->insert($wpdb->postmeta, $meta_data);
                }
            }
        } catch (Exception $exc) {
            return false;
        }

        return true;
    }

    /**
     * Get wpb data Homepage
     * 
     * @param type $page
     * @return boolean
     */
    public static function tradeace_wpb_page_data($page) {
        $file = TRADE_ACE_ADMIN_PATH . 'importer/data-import/pages-wpb/tradeace_' . $page . '.php';
        if (!is_file($file)) {
            return false;
        }

        require $file;

        return call_user_func('tradeace_wpb_' . str_replace('-', '_', $page));
    }

    /**
     * Get elm data Homepage
     * 
     * @param type $page
     * @return boolean
     */
    public static function tradeace_elm_page_data($page) {
        $file = TRADE_ACE_ADMIN_PATH . 'importer/data-import/pages-elm/tradeace_' . $page . '.php';
        if (!is_file($file)) {
            return false;
        }

        require $file;

        return call_user_func('tradeace_elm_' . str_replace('-', '_', $page));
    }
    
    /**
     * Get elm data Footer HFE
     * 
     * @param type $footer
     * @return boolean
     */
    public static function tradeace_elm_footer_data($footer) {
        $file = TRADE_ACE_ADMIN_PATH . 'importer/data-import/footers-hfe/tradeace_' . $footer . '.php';
        if (!is_file($file)) {
            return false;
        }

        require $file;

        return call_user_func('tradeace_hfe_' . str_replace('-', '_', $footer));
    }

    /**
     * Elementor build post CSS file
     * 
     * @global type $wp_filesystem
     * @param type $page_id
     * @param type $data
     * @return boolean
     */
    public static function tradeace_build_page_css($page_id, $data) {
        if (!isset($data['css']) || trim($data['css']) == '') {
            return;
        }

        $content = str_replace('[inserted_id]', $page_id, $data['css']);

        global $wp_filesystem;

        // Initialize the WP filesystem, no more using 'file-put-contents' function
        if (empty($wp_filesystem)) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }

        $upload_dir = wp_upload_dir();
        $elementor_dir = $upload_dir['basedir'] . '/elementor';

        /**
         * Create elementor dir
         */
        if (!$wp_filesystem->is_dir($elementor_dir)) {
            if (!wp_mkdir_p($elementor_dir)){
                return false;
            }
        }

        $css_dir = $elementor_dir . '/css';
        if (!$wp_filesystem->is_dir($css_dir)) {   
            /**
             * Create css dir
             */
            if (!wp_mkdir_p($css_dir)){
                return false;
            }
        }

        /**
         * Create htaccess file
         */
        $css_file = $css_dir . '/post-' . $page_id . '.css';
        if (!is_file($css_file)) {
            if (!defined('FS_CHMOD_FILE')) {
                define('FS_CHMOD_FILE', (fileperms(ABSPATH . 'index.php') & 0777 | 0644));
            }

            if (!$wp_filesystem->put_contents($css_file, $content, FS_CHMOD_FILE)) {
                return false;
            }
        }

        return true;
    }
    
    /**
     * Push Demo Data
     * 
     * @param type $type
     * @param type $page
     * @return boolean
     */
    public static function tradeace_push_data_from_file($type, $page) {
        if (!in_array($type, array('wpb', 'elm', 'hfe'))) {
            return false;
        }
        
        switch ($type) {
            case 'wpb':
                $data = self::tradeace_wpb_page_data($page);
                break;
            
            case 'elm':
                $data = self::tradeace_elm_page_data($page);
                break;
            
            case 'hfe':
                $data = self::tradeace_elm_footer_data($page);
                break;
        } 

        $data_push = self::tradeace_render_page_data($type, $data);

        $insert_id = self::tradeace_insert_page_data($data_push);

        if ($insert_id) {
            $metas = self::tradeace_insert_page_meta($insert_id, $data_push);

            /**
             * Set Homepage
             */
            global $tradeace_front_page;
            if (!isset($tradeace_front_page) && $data_push['post']['post_type'] == 'page') {
                $GLOBALS['tradeace_front_page'] = $insert_id;
                update_option('page_on_front', $insert_id);
            }

            self::tradeace_build_page_css($insert_id, $data_push);
        }
    }
}
