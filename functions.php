<?php
/*
 *
 * @package tradeacetheme - tradeace-theme
 */

defined('TRADEACE_VERSION') or define('TRADEACE_VERSION', '4.3.0');

/* Define DIR AND URI OF THEME */
define('TRADEACE_THEME_PATH', get_template_directory());
define('TRADEACE_CHILD_PATH', get_stylesheet_directory());
define('TRADEACE_THEME_URI', get_template_directory_uri());

/* Global $content_width */
if (!isset($content_width)){
    $content_width = 1200; /* pixels */
}

/**
 * Options theme
 */
require TRADEACE_THEME_PATH . '/options/tradeace-options.php';

/**
 * After Setup theme
 */
add_action('after_setup_theme', 'tradeace_setup');
if (!function_exists('tradeace_setup')) :
    function tradeace_setup() {
        /**
         * Load Text Domain
         */
        load_theme_textdomain('tradeace-theme', TRADEACE_THEME_PATH . '/languages');
        
        /**
         * Theme Support
         */
        add_theme_support('woocommerce');
        add_theme_support('automatic-feed-links');

        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('custom-background');
        add_theme_support('custom-header');
        
		add_theme_support('custom-logo');
        /**
         * Remove Theme Support
         */
        remove_theme_support('wc-product-gallery-lightbox');
        remove_theme_support('wc-product-gallery-zoom');

        /**
         * Register Menu locations
         */
        register_nav_menus(
            array(
                'primary' => esc_html__('Main Menu', 'tradeace-theme'),
                'vetical-menu' => esc_html__('Vertical Menu', 'tradeace-theme'),
                'topbar-menu' => esc_html__('Top Menu - Only show level 1', 'tradeace-theme')
            )
        );
        
        /**
         * Set Theme Options
         */
        if (!did_action('tradeace_set_options')) {
            do_action('tradeace_set_options');
        }
        
        /**
         * Register Font family
         */
        require TRADEACE_THEME_PATH . '/cores/tradeace-register-fonts.php';

        /**
         * Libraries of theme
         */
        require TRADEACE_THEME_PATH . '/cores/tradeace-custom-wc-ajax.php';
        require TRADEACE_THEME_PATH . '/cores/tradeace-dynamic-style.php';
        require TRADEACE_THEME_PATH . '/cores/tradeace-widget-functions.php';
        require TRADEACE_THEME_PATH . '/cores/tradeace-theme-options.php';
        require TRADEACE_THEME_PATH . '/cores/tradeace-theme-functions.php';
        require TRADEACE_THEME_PATH . '/cores/tradeace-woo-functions.php';
        require TRADEACE_THEME_PATH . '/cores/tradeace-woo-actions.php';
        require TRADEACE_THEME_PATH . '/cores/tradeace-shop-ajax.php';
        require TRADEACE_THEME_PATH . '/cores/tradeace-theme-headers.php';
        require TRADEACE_THEME_PATH . '/cores/tradeace-theme-footers.php';
        require TRADEACE_THEME_PATH . '/cores/tradeace-yith-wcwl-ext.php';
        require TRADEACE_THEME_PATH . '/cores/tradeace-wishlist.php';
        require TRADEACE_THEME_PATH . '/cores/tradeace-outdate-functions.php';

        /**
         * Includes widgets
         */
        require TRADEACE_THEME_PATH . '/widgets/wg-tradeace-recent-posts.php';
        require TRADEACE_THEME_PATH . '/widgets/wg-tradeace-product-categories.php';
        require TRADEACE_THEME_PATH . '/widgets/wg-tradeace-product-brands.php';
        require TRADEACE_THEME_PATH . '/widgets/wg-tradeace-product-filter-price.php';
        require TRADEACE_THEME_PATH . '/widgets/wg-tradeace-product-filter-price-list.php';
        require TRADEACE_THEME_PATH . '/widgets/wg-tradeace-product-filter-variations.php';
        require TRADEACE_THEME_PATH . '/widgets/wg-tradeace-tag-cloud.php';
        require TRADEACE_THEME_PATH . '/widgets/wg-tradeace-product-filter-status.php';
        require TRADEACE_THEME_PATH . '/widgets/wg-tradeace-product-filter-multi-tags.php';
        require TRADEACE_THEME_PATH . '/widgets/wg-tradeace-reset-filter.php';
    }
endif;
