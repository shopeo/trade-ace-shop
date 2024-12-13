<?php
defined('ABSPATH') or die(); // Exit if accessed directly
/**
 * Get term description
 * 
 * Outdate from 2.1.4
 */
if (!function_exists('tradeace_term_description')) :
    function tradeace_term_description($term_id, $type_taxonomy) {
        if (!TRADEACE_WOO_ACTIVED) {
            return '';
        }
        
        if ((int) $term_id < 1) {
            $shop_page = get_post(wc_get_page_id('shop'));
            $desc = $shop_page ? wc_format_content($shop_page->post_content) : '';
        } else {
            $term = get_term($term_id, $type_taxonomy);
            $desc = isset($term->description) ? $term->description : '';
        }
        
        return trim($desc) != '' ? '<div class="page-description">' . do_shortcode($desc) . '</div>' : '';
    }
endif;

/**
 * Get cat header content
 * 
 * Outdate from 2.1.4
 */
if (!function_exists('tradeace_get_cat_header')):
    function tradeace_get_cat_header($catId = null) {
        global $tradeace_opt;
        
        if (isset($tradeace_opt['enable_cat_header']) && $tradeace_opt['enable_cat_header'] != '1') {
            return '';
        }

        $content = '<div class="cat-header tradeace-cat-header padding-top-20">';
        $do_content = '';
        
        if ((int) $catId > 0) {
            $shortcode = function_exists('get_term_meta') ? get_term_meta($catId, 'cat_header', false) : get_woocommerce_term_meta($catId, 'cat_header', false);
            $do_content = isset($shortcode[0]) ? do_shortcode($shortcode[0]) : '';
        }

        if (trim($do_content) === '') {
            if (isset($tradeace_opt['cat_header']) && $tradeace_opt['cat_header'] != '') {
                $do_content = do_shortcode($tradeace_opt['cat_header']);
            }
        }

        if (trim($do_content) === '') {
            return '';
        }

        $content .= $do_content . '</div>';

        return $content;
    }
endif;

/**
 * Deprecated
 * 
 * Language Flags
 */
if (!function_exists('tradeace_language_flages')) :
    function tradeace_language_flages() {
        global $tradeace_opt;
        
        if (!isset($tradeace_opt['switch_lang']) || $tradeace_opt['switch_lang'] != 1) {
            return;
        }
        
        $language_output = '<div class="tradeace-select-languages">';
        $mainLang = '';
        $selectLang = '<ul class="tradeace-list-languages">';
        
        if (function_exists('icl_get_languages')) {
            $current = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : get_option('WPLANG');
            
            $languages = icl_get_languages('skip_missing=0&orderby=code');
            if (!empty($languages)) {
                foreach ($languages as $lang) {
                    
                    /**
                     * Current Language
                     */
                    if ($current == $lang['language_code']) {
                        $mainLang .= '<a href="javascript:void(0);" class="tradeace-current-lang" rel="nofollow">';
                        
                        if (isset($lang['country_flag_url'])) {
                            $mainLang .= '<img src="' . esc_url($lang['country_flag_url']) . '" alt="' . esc_attr($lang['native_name']) . '" />';
                        }
                        
                        $mainLang .= $lang['native_name'];
                        $mainLang .= '</a>';
                    }
                    
                    /**
                     * Select Languages
                     */
                    else {
                        $selectLang .= '<li class="tradeace-item-lang"><a href="' . esc_url($lang['url']) . '" title="' . esc_attr($lang['native_name']) . '" rel="nofollow">';

                        if (isset($lang['country_flag_url'])) {
                            $selectLang .= '<img src="' . esc_url($lang['country_flag_url']) . '" alt="' . esc_attr($lang['native_name']) . '" />';
                        }

                        $selectLang .= $lang['native_name'];
                        $selectLang .= '</a></li>';
                    }
                }
            }
        }
        
        /**
         * have not installs WPML
         */
        else {
            $mainLang .= '<a href="javascript:void(0);" class="tradeace-current-lang" rel="nofollow">';
            $mainLang .= '<img src="' . esc_url(TRADEACE_THEME_URI . '/assets/images/en.png') . '" alt="' . esc_attr__('English', 'tradeace-theme') . '" />';
            $mainLang .= esc_html__('Requires WPML', 'tradeace-theme');
            $mainLang .= '</a>';
            
            /**
             * Select Languages
             */
            // English
            $selectLang .= '<li class="tradeace-item-lang"><a href="#" title="' . esc_attr__('English', 'tradeace-theme') . '">';
            $selectLang .= '<img src="' . esc_url(TRADEACE_THEME_URI . '/assets/images/en.png') . '" alt="' . esc_attr__('English', 'tradeace-theme') . '" />';

            $selectLang .= esc_html__('English', 'tradeace-theme');
            $selectLang .= '</a></li>';
            
            // German
            $selectLang .= '<li class="tradeace-item-lang"><a href="#" title="' . esc_attr__('Deutsch', 'tradeace-theme') . '">';
            $selectLang .= '<img src="' . esc_url(TRADEACE_THEME_URI . '/assets/images/de.png') . '" alt="' . esc_attr__('Deutsch', 'tradeace-theme') . '" />';

            $selectLang .= esc_html__('Deutsch', 'tradeace-theme');
            $selectLang .= '</a></li>';
            
            // French
            $selectLang .= '<li class="tradeace-item-lang"><a href="#" title="' . esc_attr__('Français', 'tradeace-theme') . '">';
            $selectLang .= '<img src="' . esc_url(TRADEACE_THEME_URI . '/assets/images/fr.png') . '" alt="' . esc_attr__('Français', 'tradeace-theme') . '" />';

            $selectLang .= esc_html__('Français', 'tradeace-theme');
            $selectLang .= '</a></li>';
        }
        
        $selectLang .= '</ul>';
        
        $language_output .= $mainLang . $selectLang . '</div>';

        echo '<ul class="header-switch-languages left rtl-right desktop-margin-right-30 rtl-desktop-margin-right-0 rtl-desktop-margin-left-30"><li>' . $language_output . '</li></ul>';
    }
endif;

/**
 * Change tradeace_product_video_btn_function => tradeace_product_video_btn
 */
if (function_exists('tradeace_product_video_btn_function')) {
    remove_action('tradeace_single_buttons', 'tradeace_product_video_btn', 25);
    add_action('tradeace_single_buttons', 'tradeace_product_video_btn_function', 25);
}

/**
 * Change tradeace_footer_layout_style_function => tradeace_footer_layout
 */
if (function_exists('tradeace_footer_layout_style_function')) {
    remove_action('tradeace_footer_layout_style', 'tradeace_footer_output');
    add_action('tradeace_footer_layout_style', 'tradeace_footer_layout_style_function');
}

/**
 * Change tradeace_get_custom_field_value => tradeace_get_product_meta_value
 */
if (!function_exists('tradeace_get_custom_field_value')) :
    function tradeace_get_custom_field_value($post_id, $field_id) {
        return tradeace_get_product_meta_value($post_id, $field_id);
    }
endif;
