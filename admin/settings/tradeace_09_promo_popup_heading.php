<?php
add_action('init', 'tradeace_promo_popup_heading');
if (!function_exists('tradeace_promo_popup_heading')) {

    function tradeace_promo_popup_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }

        $of_options[] = array(
            "name" => esc_html__("Newsletter Popup", 'tradeace-theme'),
            "target" => 'promo-popup',
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Newsletter", 'tradeace-theme'),
            "id" => "promo_popup",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hide in Mobile (width site small less 640px OR Mobile Layout)", 'tradeace-theme'),
            "desc" => esc_html__("Yes, Please!", 'tradeace-theme'),
            "id" => "disable_popup_mobile",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Only Display 1 Time", 'tradeace-theme'),
            "id" => "promo_popup_1_time",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Width", 'tradeace-theme'),
            "id" => "pp_width",
            "std" => "734",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Height", 'tradeace-theme'),
            "id" => "pp_height",
            "std" => "501",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Content", 'tradeace-theme'),
            "id" => "pp_content",
            "std" => '<h3>Newsletter</h3><p>Be the first to know about our new arrivals, exclusive offers and the latest fashion update.</p>',
            "type" => "textarea"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Select Contact Form", 'tradeace-theme'),
            "id" => "pp_contact_form",
            "type" => "select",
            'override_numberic' => true,
            "options" => tradeace_get_contact_form7()
        );
        
        $of_options[] = array(
            "name" => esc_html__("Content Width", 'tradeace-theme'),
            "id" => "pp_style",
            "std" => "simple",
            "type" => "select",
            "options" => array(
                "simple" => esc_html__("50%", 'tradeace-theme'),
                "full" => esc_html__("Full Width", 'tradeace-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Background Color", 'tradeace-theme'),
            "id" => "pp_background_color",
            "std" => "#fff",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Background", 'tradeace-theme'),
            "id" => "pp_background_image",
            "std" => TRADEACE_THEME_URI . '/assets/images/newsletter_bg.jpg',
            "type" => "media"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Delay time to show (seconds)", 'tradeace-theme'),
            "id" => "delay_promo_popup",
            "std" => 0,
            "type" => "text"
        );
    }
}

/**
 * Get list Contact Form 7
 * @return type
 */
function tradeace_get_contact_form7() {
    $contacts_form =array();
    $contacts = array('default' => esc_html__('Select the Contact Form', 'tradeace-theme'));
    
    if (!empty($contacts_form)) {
        foreach ($contacts_form as $id => $form) {
            if ($id) {
                $contacts[$id] = $form;
            }
        }
    }
    
    return $contacts;
}
