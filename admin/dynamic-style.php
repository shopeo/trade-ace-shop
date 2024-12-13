<?php
defined('ABSPATH') or die(); // Exit if accessed directly

function trade_ace_get_content_custom_css($tradeace_opt = array()) {
    ob_start();
    ?><style><?php
    echo '@charset "UTF-8";' . "\n";
    
    /**
     * Start font style
     */
    $type_font_select = isset($tradeace_opt['type_font_select']) ? $tradeace_opt['type_font_select'] : '';
    $custom_font = isset($tradeace_opt['custom_font']) ? $tradeace_opt['custom_font'] : '';
    
    $type_headings = isset($tradeace_opt['type_headings']) ? $tradeace_opt['type_headings'] : '';
    $type_texts = isset($tradeace_opt['type_texts']) ? $tradeace_opt['type_texts'] : '';
    $type_nav = isset($tradeace_opt['type_nav']) ? $tradeace_opt['type_nav'] : '';
    $type_banner = isset($tradeace_opt['type_banner']) ? $tradeace_opt['type_banner'] : '';
    $type_price = isset($tradeace_opt['type_price']) ? $tradeace_opt['type_price'] : '';
    
    echo tradeace_get_font_style(
        $type_font_select,
        $type_headings,
        $type_texts,
        $type_nav,
        $type_banner,
        $type_price,
        $custom_font
    );
    
    $type_headings_rtl = isset($tradeace_opt['type_headings_rtl']) ? $tradeace_opt['type_headings_rtl'] : '';
    $type_texts_rtl = isset($tradeace_opt['type_texts_rtl']) ? $tradeace_opt['type_texts_rtl'] : '';
    $type_nav_rtl = isset($tradeace_opt['type_nav_rtl']) ? $tradeace_opt['type_nav_rtl'] : '';
    $type_banner_rtl = isset($tradeace_opt['type_banner_rtl']) ? $tradeace_opt['type_banner_rtl'] : '';
    $type_price_rtl = isset($tradeace_opt['type_price_rtl']) ? $tradeace_opt['type_price_rtl'] : '';
    
    echo tradeace_get_font_style_rtl(
        $type_font_select,
        $type_headings_rtl,
        $type_texts_rtl,
        $type_nav_rtl,
        $type_banner_rtl,
        $type_price_rtl,
        $custom_font
    );
    
    // End font style
    
    if (isset($tradeace_opt['logo_height']) && (int) $tradeace_opt['logo_height']) :
        ?>
            body .logo .header_logo
            {
                height: <?php echo (int) $tradeace_opt['logo_height'] . 'px'; ?>;
            }
        <?php
    endif;
    
    if (isset($tradeace_opt['logo_width']) && (int) $tradeace_opt['logo_width']) :
        ?>
            body .logo .header_logo
            {
                width: <?php echo (int) $tradeace_opt['logo_width'] . 'px'; ?>;
            }
        <?php
    else :
        ?>
            body .logo .header_logo
            {
                width: auto;
            }
        <?php
    endif;
    
    if (isset($tradeace_opt['logo_height_mobile']) && (int) $tradeace_opt['logo_height_mobile']) :
        ?>
            body .mobile-menu .logo .header_logo,
            body .fixed-already .mobile-menu .logo .header_logo,
            body .tradeace-login-register-warper #tradeace-login-register-form .tradeace-form-logo-log .header_logo,
            body .tradeace-header-mobile-layout .logo .header_logo
            {
                height: <?php echo (int) $tradeace_opt['logo_height_mobile'] . 'px'; ?>;
            }
        <?php
    endif;
    
    if (isset($tradeace_opt['logo_width_mobile']) && (int) $tradeace_opt['logo_width_mobile']) :
        ?>
            body .mobile-menu .logo .header_logo,
            body .fixed-already .mobile-menu .logo .header_logo,
            body .tradeace-login-register-warper #tradeace-login-register-form .tradeace-form-logo-log .header_logo,
            body .tradeace-header-mobile-layout .logo .header_logo
            {
                width: <?php echo (int) $tradeace_opt['logo_width_mobile'] . 'px'; ?>;
            }
        <?php
    else :
        ?>
            body .mobile-menu .logo .header_logo,
            body .fixed-already .mobile-menu .logo .header_logo,
            body .tradeace-login-register-warper #tradeace-login-register-form .tradeace-form-logo-log .header_logo,
            body .tradeace-header-mobile-layout .logo .header_logo
            {
                width: auto;
            }
        <?php
    endif;
    
    if (isset($tradeace_opt['logo_sticky_height']) && (int) $tradeace_opt['logo_sticky_height']) :
        ?>
            body .fixed-already .logo .header_logo
            {
                height: <?php echo (int) $tradeace_opt['logo_sticky_height'] . 'px'; ?>;
            }
        <?php
    endif;
    
    if (isset($tradeace_opt['logo_sticky_width']) && (int) $tradeace_opt['logo_sticky_width']) :
        ?>
            body .fixed-already .logo .header_logo
            {
                width: <?php echo (int) $tradeace_opt['logo_sticky_width'] . 'px'; ?>;
            }
        <?php
        
    else :
        ?>
            body .fixed-already .logo .header_logo
            {
                width: auto;
            }
        <?php
    endif;

    if (isset($tradeace_opt['max_height_logo']) && (int) $tradeace_opt['max_height_logo']) :
        ?>
            body .logo .header_logo
            {
                max-height: <?php echo (int) $tradeace_opt['max_height_logo'] . 'px'; ?>;
            }
        <?php
    endif;
    
    if (isset($tradeace_opt['max_height_mobile_logo']) && (int) $tradeace_opt['max_height_mobile_logo']) :
        ?>
            body .mobile-menu .logo .header_logo,
            body .fixed-already .mobile-menu .logo .header_logo,
            body .tradeace-login-register-warper #tradeace-login-register-form .tradeace-form-logo-log .header_logo,
            body .tradeace-header-mobile-layout .logo .header_logo
            {
                max-height: <?php echo (int) $tradeace_opt['max_height_mobile_logo'] . 'px'; ?>;
            }
        <?php
    endif;
    
    if (isset($tradeace_opt['max_height_sticky_logo']) && (int) $tradeace_opt['max_height_sticky_logo']) :
        ?>
            body .fixed-already .logo .header_logo
            {
                max-height: <?php echo (int) $tradeace_opt['max_height_sticky_logo'] . 'px'; ?>;
            }
        <?php
    endif;

    if (isset($tradeace_opt['site_layout']) && $tradeace_opt['site_layout'] == 'boxed') :
        $tradeace_opt['site_bg_image'] = isset($tradeace_opt['site_bg_image']) && $tradeace_opt['site_bg_image'] ? str_replace(
            array(
                '[site_url]',
                '[site_url_secure]',
            ), array(
                site_url('', 'http'),
                site_url('', 'https'),
            ), $tradeace_opt['site_bg_image']
        ) : false;
        ?> 
            body.boxed,
            body
            {
            <?php if ($tradeace_opt['site_bg_color']) : ?>
                background-color: <?php echo esc_attr($tradeace_opt['site_bg_color']); ?>;
            <?php endif; ?>
            <?php if ($tradeace_opt['site_bg_image']) : ?>
                background-image: url("<?php echo esc_url($tradeace_opt['site_bg_image']); ?>");
                background-attachment: fixed;
            <?php endif; ?>
            }
        <?php
    endif;

    /* COLOR PRIMARY */
    if (isset($tradeace_opt['color_primary'])) :
        echo tradeace_get_style_primary_color($tradeace_opt['color_primary']);
    endif;

    /* COLOR SUCCESS */
    if (isset($tradeace_opt['color_success']) && $tradeace_opt['color_success'] != '') :
        ?> 
            .woocommerce-message {
                color: #FFF !important;
                background-color: <?php echo esc_attr($tradeace_opt['color_success']); ?> !important;
            }
            body .woocommerce-message,
            body .tradeace-compare-list-bottom .tradeace-compare-mess
            {
                border-color: <?php echo esc_attr($tradeace_opt['color_success']); ?>;
            }
            body .added i.tradeace-df-plus:before,
            body .added i.tradeace-df-plus:after
            {
                border-color: <?php echo esc_attr($tradeace_opt['color_success']) ?> !important;
            }
            .added .tradeace-icon,
            .tradeace-added .tradeace-icon
            {
                color: <?php echo esc_attr($tradeace_opt['color_success']); ?> !important;
            }
            body #tradeace-content-ask-a-quetion div.wpcf7-response-output.wpcf7-mail-sent-ok
            {
                color: <?php echo esc_attr($tradeace_opt['color_success']); ?>;
            }
            body #yith-wcwl-popup-message #yith-wcwl-message
            {
                background-color: <?php echo esc_attr($tradeace_opt['color_success']); ?>;
            }
        <?php
    endif;

    /* COLOR SALE */
    if (isset($tradeace_opt['color_sale_label']) && $tradeace_opt['color_sale_label'] != '') :
        ?>
            body .badge.sale-label
            {
                background: <?php echo esc_attr($tradeace_opt['color_sale_label']); ?>;
            }
        <?php
    endif;

    /* COLOR HOT */
    if (isset($tradeace_opt['color_hot_label']) && $tradeace_opt['color_hot_label'] != '') :
        ?>
            body .badge.hot-label
            {
                background: <?php echo esc_attr($tradeace_opt['color_hot_label']); ?>;
            }
        <?php
    endif;
    
    /* COLOR Featured */
    if (isset($tradeace_opt['color_featured_label']) && $tradeace_opt['color_featured_label'] != '') :
        ?>
            body .badge.featured-label
            {
                background: <?php echo esc_attr($tradeace_opt['color_featured_label']); ?>;
            }
        <?php
    endif;
    
    /* COLOR VIDEO */
    if (isset($tradeace_opt['color_video_label']) && $tradeace_opt['color_video_label'] != '') :
        ?>
            body .badge.video-label
            {
                background: <?php echo esc_attr($tradeace_opt['color_video_label']); ?>;
            }
        <?php
    endif;
    
    /* COLOR 360 */
    if (isset($tradeace_opt['color_360_label']) && $tradeace_opt['color_360_label'] != '') :
        ?>
            body .badge.b360-label
            {
                background: <?php echo esc_attr($tradeace_opt['color_360_label']); ?>;
            }
        <?php
    endif;
    
    /* COLOR DEAL */
    if (isset($tradeace_opt['color_deal_label']) && $tradeace_opt['color_deal_label'] != '') :
        ?>
        body .badge.deal-label
        {
            background: <?php echo esc_attr($tradeace_opt['color_deal_label']); ?>;
        }
        <?php
    endif;
    
    /* COLOR SALE */
    if (isset($tradeace_opt['color_variants_label']) && $tradeace_opt['color_variants_label'] != '') :
        ?>
            body .badge.tradeace-variants
            {
                background: <?php echo esc_attr($tradeace_opt['color_variants_label']); ?>;
            }
        <?php
    endif;

    /* COLOR PRICE */
    if (isset($tradeace_opt['color_price_label']) && $tradeace_opt['color_price_label'] != '') :
        ?>
        body .product-price, 
        body .price.tradeace-sc-p-price,
        body .price,
        body .product-item .info .price,
        body .countdown .countdown-row .countdown-amount,
        body .columns.tradeace-column-custom-4 .tradeace-sc-p-deal-countdown .countdown-row.countdown-show4 .countdown-section .countdown-amount,
        body .item-product-widget .product-meta .price,
        html body .tradeace-after-add-to-cart-subtotal-price,
        html body .tradeace-total-condition-desc .woocommerce-Price-amount,
        html body .woocommerce-table--order-details tfoot tr:last-child td > .amount
        {
            color: <?php echo esc_attr($tradeace_opt['color_price_label']); ?>;
        }
        .amount,
        .tradeace-total-condition-desc .woocommerce-Price-amount
        {
            color: <?php echo esc_attr($tradeace_opt['color_price_label']); ?> !important;
        }
        <?php
    endif;

    /* COLOR BUTTON */
    if (isset($tradeace_opt['color_button']) && $tradeace_opt['color_button'] != '') :
        ?> 
            form.cart .button,
            .checkout-button,
            input#place_order,
            .btn-viewcart,
            input#submit,
            .add_to_cart,
            button,
            .button,
            body input[type="submit"].dokan-btn,
            body a.dokan-btn,
            body .dokan-btn,
            body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn,
            input[type="submit"].dokan-btn-theme,
            a.dokan-btn-theme,
            .dokan-btn-theme
            {
                background-color: <?php echo esc_attr($tradeace_opt['color_button']); ?> !important;
            }
        <?php
    endif;

    /* COLOR HOVER */
    if (isset($tradeace_opt['color_hover']) && $tradeace_opt['color_hover'] != '') :
        ?>
            form.cart .button:hover,
            a.primary.trans-button:hover,
            .form-submit input:hover,
            #payment .place-order input:hover,
            input#submit:hover,
            .product-list .product-img .quick-view.fa-search:hover,
            .footer-type-2 input.button,
            button:hover,
            .button:hover,
            .checkout-button:hover,
            input#place_order:hover,
            .btn-viewcart:hover,
            input#submit:hover,
            .add_to_cart:hover
            {
                background-color: <?php echo esc_attr($tradeace_opt['color_hover']); ?>!important;
            }
        <?php
    endif;

    /* COLOR BORDER BUTTON ============================================================== */
    if (isset($tradeace_opt['button_border_color']) && $tradeace_opt['button_border_color'] != '') :
        ?>
            #submit, 
            button, 
            .button, 
            input[type="submit"],
            .widget.woocommerce li.tradeace-li-filter-size a,
            .widget.widget_categories li.tradeace-li-filter-size a,
            .widget.widget_archive li.tradeace-li-filter-size a
            {
                border-color: <?php echo esc_attr($tradeace_opt['button_border_color']); ?> !important;
            }
            body .group-btn-in-list .add-to-cart-grid .add_to_cart_text,
            html body input[type="submit"].dokan-btn,
            html body a.dokan-btn,
            html body .dokan-btn,
            html body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn,
            body input[type="submit"].dokan-btn-theme,
            body a.dokan-btn-theme,
            body .dokan-btn-theme
            {
                border-color: <?php echo esc_attr($tradeace_opt['button_border_color']); ?>;
            }
        <?php
    endif;

    /* COLOR BORDER BUTTON HOVER */
    if (isset($tradeace_opt['button_border_color_hover']) && $tradeace_opt['button_border_color_hover'] != '') :
        ?>
            #submit:hover, 
            button:hover, 
            .button:hover, 
            input[type="submit"]:hover,
            .widget.woocommerce li.tradeace-li-filter-size.chosen a,
            .widget.woocommerce li.tradeace-li-filter-size.tradeace-chosen a,
            .widget.woocommerce li.tradeace-li-filter-size:hover a,
            .widget.widget_categories li.tradeace-li-filter-size.chosen a,
            .widget.widget_categories li.tradeace-li-filter-size.tradeace-chosen a,
            .widget.widget_categories li.tradeace-li-filter-size:hover a,
            .widget.widget_archive li.tradeace-li-filter-size.chosen a,
            .widget.widget_archive li.tradeace-li-filter-size.tradeace-chosen a,
            .widget.widget_archive li.tradeace-li-filter-size:hover a
            {
                border-color: <?php echo esc_attr($tradeace_opt['button_border_color_hover']); ?> !important;
            }
            body .group-btn-in-list add-to-cart-grid:hover .add_to_cart_text,
            html body input[type="submit"].dokan-btn:hover,
            html body a.dokan-btn:hover,
            html body .dokan-btn:hover,
            html body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn,
            body input[type="submit"].dokan-btn-theme:hover,
            body a.dokan-btn-theme:hover,
            body .dokan-btn-theme:hover
            {
                border-color: <?php echo esc_attr($tradeace_opt['button_border_color_hover']); ?>;
            }
        <?php
    endif;

    /* COLOR TEXT BUTTON */
    if (isset($tradeace_opt['button_text_color']) && $tradeace_opt['button_text_color'] != '') :
        ?>
            #submit, 
            button, 
            .button, 
            input[type="submit"],
            body input[type="submit"].dokan-btn,
            body a.dokan-btn,
            body .dokan-btn,
            html body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn,
            body input[type="submit"].dokan-btn-theme,
            body a.dokan-btn-theme,
            body .dokan-btn-theme
            {
                color: <?php echo esc_attr($tradeace_opt['button_text_color']); ?> !important;
            }
        <?php
    endif;

    /* COLOR HOVER TEXT BUTTON */
    if (isset($tradeace_opt['button_text_color_hover']) && $tradeace_opt['button_text_color_hover'] != '') :
        ?>
            #submit:hover, 
            button:hover, 
            .button:hover, 
            input[type="submit"]:hover
            {
                color: <?php echo esc_attr($tradeace_opt['button_text_color_hover']); ?> !important;
            }
            html body input[type="submit"].dokan-btn:hover,
            html body a.dokan-btn:hover,
            html body .dokan-btn:hover,
            html body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn:hover,
            body input[type="submit"].dokan-btn-theme:hover,
            body a.dokan-btn-theme:hover,
            body .dokan-btn-theme:hover
            {
                color: <?php echo esc_attr($tradeace_opt['button_text_color_hover']); ?>;
            }
        <?php
    endif;

    if (isset($tradeace_opt['button_radius'])) :
        ?>
            body .product-item .product-deal-special-buttons .tradeace-product-grid .add-to-cart-grid,
            body .wishlist_table .add_to_cart,
            body .yith-wcwl-add-button > a.button.alt,
            body #submit,
            body #submit.disabled,
            body #submit[disabled],
            body button,
            body button.disabled,
            body button[disabled],
            body .button,
            body .button.disabled,
            body .button[disabled],
            body input[type="submit"],
            body input[type="submit"].disabled,
            body input[type="submit"][disabled],
            html body input[type="submit"].dokan-btn,
            html body a.dokan-btn,
            html body .dokan-btn,
            html body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn,
            body input[type="submit"].dokan-btn-theme,
            body a.dokan-btn-theme,
            body .dokan-btn-theme
            {
                border-radius: <?php echo (int) $tradeace_opt['button_radius']; ?>px;
                -webkit-border-radius: <?php echo (int) $tradeace_opt['button_radius']; ?>px;
                -o-border-radius: <?php echo (int) $tradeace_opt['button_radius']; ?>px;
                -moz-border-radius: <?php echo (int) $tradeace_opt['button_radius']; ?>px;
            }
        <?php
    endif;

    if (isset($tradeace_opt['button_border']) && (int) $tradeace_opt['button_border']) :
        ?>
            body #submit, 
            body button, 
            body .button,
            body input[type="submit"],
            html body input[type="submit"].dokan-btn,
            html body a.dokan-btn,
            html body .dokan-btn,
            html body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn,
            body input[type="submit"].dokan-btn-theme,
            body a.dokan-btn-theme,
            body .dokan-btn-theme
            {
                border-width: <?php echo (int) $tradeace_opt['button_border']; ?>px;
            }
        <?php
    endif;

    if (isset($tradeace_opt['input_radius'])) :
        ?>
            body textarea,
            body select,
            body input[type="text"],
            body input[type="password"],
            body input[type="date"], 
            body input[type="datetime"],
            body input[type="datetime-local"],
            body input[type="month"],
            body input[type="week"],
            body input[type="email"],
            body input[type="number"],
            body input[type="search"],
            body input[type="tel"],
            body input[type="time"],
            body input[type="url"],
            body .category-page .sort-bar .select-wrapper
            {
                border-radius: <?php echo (int) $tradeace_opt['input_radius']; ?>px;
                -webkit-border-radius: <?php echo (int) $tradeace_opt['input_radius']; ?>px;
                -o-border-radius: <?php echo (int) $tradeace_opt['input_radius']; ?>px;
                -moz-border-radius: <?php echo (int) $tradeace_opt['input_radius']; ?>px;
            }
        <?php
    endif;
    
    /* BG COLOR BUTTON BUY NOW */
    if (isset($tradeace_opt['buy_now_bg_color']) && $tradeace_opt['buy_now_bg_color'] != '') :
        ?>
            body .tradeace-buy-now
            {
                background-color: <?php echo esc_attr($tradeace_opt['buy_now_bg_color']); ?> !important;
                border-color: <?php echo esc_attr($tradeace_opt['buy_now_bg_color']); ?> !important;
            }
        <?php
    endif;
    
    /* BG COLOR BUTTON HOVER BUY NOW */
    if (isset($tradeace_opt['buy_now_bg_color_hover']) && $tradeace_opt['buy_now_bg_color_hover'] != '') :
        ?>
            body .tradeace-buy-now:hover
            {
                background-color: <?php echo esc_attr($tradeace_opt['buy_now_bg_color_hover']); ?> !important;
                border-color: <?php echo esc_attr($tradeace_opt['buy_now_bg_color_hover']); ?> !important;
            }
        <?php
    endif;
    
    /* SHADOW COLOR BUTTON BUY NOW */
    if (isset($tradeace_opt['buy_now_color_shadow']) && $tradeace_opt['buy_now_color_shadow'] != '') :
        ?>
            body .tradeace-buy-now
            {
                -webkit-box-shadow: 0 2px 0 <?php echo esc_attr($tradeace_opt['buy_now_color_shadow']); ?> !important;
                -moz-box-shadow: 0 2px 0 <?php echo esc_attr($tradeace_opt['buy_now_color_shadow']); ?> !important;
                box-shadow: 0 2px 0 <?php echo esc_attr($tradeace_opt['buy_now_color_shadow']); ?> !important;
            }
        <?php
    endif;
    
    $custom_percentage_left = isset($tradeace_opt['percentage-header-1']) && $tradeace_opt['percentage-header-1'] != 70 ? $tradeace_opt['percentage-header-1'] : false;
    if ($custom_percentage_left) :
        $custom_percentage_right = 100 - $custom_percentage_left;
        ?>
            body .tradeace-left-main-header {
                width: <?php echo (int) $custom_percentage_left . '%'; ?>;
            }
            body .tradeace-right-main-header {
                width: <?php echo (int) $custom_percentage_right . '%'; ?>;
            }
        <?php
    endif;
    
    /**
     * Color of header
     */
    $bg_color = (isset($tradeace_opt['bg_color_header']) && $tradeace_opt['bg_color_header']) ? $tradeace_opt['bg_color_header'] : '';
    $text_color = (isset($tradeace_opt['text_color_header']) && $tradeace_opt['text_color_header']) ? $tradeace_opt['text_color_header'] : '';
    $text_color_hover = (isset($tradeace_opt['text_color_hover_header']) && $tradeace_opt['text_color_hover_header']) ? $tradeace_opt['text_color_hover_header'] : '';

    echo tradeace_get_style_header_color($bg_color, $text_color, $text_color_hover);

    /**
     * Color of main menu
     */
    $bg_color = isset($tradeace_opt['bg_color_main_menu']) ? $tradeace_opt['bg_color_main_menu'] : '';
    $text_color = (isset($tradeace_opt['text_color_main_menu']) && $tradeace_opt['text_color_main_menu']) ? $tradeace_opt['text_color_main_menu'] : '';
    $text_color_hover = (isset($tradeace_opt['text_color_hover_main_menu']) && $tradeace_opt['text_color_hover_main_menu']) ? $tradeace_opt['text_color_hover_main_menu'] : '';

    echo tradeace_get_style_main_menu_color($bg_color, $text_color, $text_color_hover);

    /**
     * Color of Top bar
     */
    if (!isset($tradeace_opt['topbar_show']) || $tradeace_opt['topbar_show']) {
        $bg_color = (isset($tradeace_opt['bg_color_topbar']) && $tradeace_opt['bg_color_topbar']) ? $tradeace_opt['bg_color_topbar'] : '';
        $text_color = (isset($tradeace_opt['text_color_topbar']) && $tradeace_opt['text_color_topbar']) ? $tradeace_opt['text_color_topbar'] : '';
        $text_color_hover = (isset($tradeace_opt['text_color_hover_topbar']) && $tradeace_opt['text_color_hover_topbar']) ? $tradeace_opt['text_color_hover_topbar'] : '';

        echo tradeace_get_style_topbar_color($bg_color, $text_color, $text_color_hover);
    }

    /**
     * Add width to site
     */
    if (isset($tradeace_opt['plus_wide_width']) && (int) $tradeace_opt['plus_wide_width'] > 0) :
        global $content_width;
        $content_width = !isset($content_width) ? 1200 : $content_width;
        $max_width = ($content_width + (int) $tradeace_opt['plus_wide_width']);
        
        echo tradeace_get_style_plus_wide_width($max_width);
    endif;
    
    /**
     * Promo Popup
     */
    if (isset($tradeace_opt['promo_popup']) && $tradeace_opt['promo_popup']) :
        if (!isset($tradeace_opt['pp_background_image'])) :
            $tradeace_opt['pp_background_image'] = TRADEACE_THEME_URI . '/assets/images/newsletter_bg.jpg';
        endif;
        
        $tradeace_opt['pp_background_image'] = $tradeace_opt['pp_background_image'] ? str_replace(
            array(
                '[site_url]',
                '[site_url_secure]',
            ), array(
                site_url('', 'http'),
                site_url('', 'https'),
            ), $tradeace_opt['pp_background_image']
        ) : false;
        ?>
            #tradeace-popup
            {
                width: <?php echo isset($tradeace_opt['pp_width']) ? (int) $tradeace_opt['pp_width'] : 724; ?>px;
                background-color: <?php echo isset($tradeace_opt['pp_background_color']) ? esc_url($tradeace_opt['pp_background_color']) : 'transparent' ?>;
                <?php if ($tradeace_opt['pp_background_image']) : ?>
                    background-image: url('<?php echo esc_url($tradeace_opt['pp_background_image']); ?>');
                <?php endif; ?>
                background-repeat: no-repeat;
                background-size: auto;
            }
            #tradeace-popup,
            #tradeace-popup .tradeace-popup-wrap
            {
                height: <?php echo isset($tradeace_opt['pp_height']) ? (int) $tradeace_opt['pp_height'] : 501; ?>px;
            }
            .tradeace-pp-left
            {
                min-height: 1px;
            }
        <?php
    endif;
    
    ?></style><?php
    $css = ob_get_clean();
    
    return tradeace_convert_css($css);
}
