<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Widget Tradeace Reset Filter
 */
if (TRADEACE_WOO_ACTIVED) {

    /**
     * Register Widget
     */
    add_action('widgets_init', 'tradeace_reset_filter_widget');
    function tradeace_reset_filter_widget() {
        register_widget('Trade_Ace_WC_Widget_Reset_Filters');
    }

    /**
     * Reset Filter Widget and related functions
     *
     * @author   TradeaceThemes
     * @category Widgets
     * @version  1.0.0
     * @extends  WC_Widget
     */
    class Trade_Ace_WC_Widget_Reset_Filters extends WC_Widget {

        /**
         * Constructor.
         */
        public function __construct() {
            $this->widget_cssclass = 'woocommerce widget_reset_filters tradeace-slick-remove tradeace-no-toggle tradeace-widget-has-active tradeace-widget-hidden';
            $this->widget_description = __('Display button reset filter.', 'tradeace-theme');
            $this->widget_id = 'tradeace_woocommerce_reset_filter';
            $this->widget_name = __('Tradeace Reset Filters', 'tradeace-theme');
            $this->settings = array(
                'title' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Title', 'tradeace-theme'),
                ),
            );

            parent::__construct();
        }

        /**
         * Output widget.
         *
         * @see WP_Widget
         * @param array $args     Arguments.
         * @param array $instance Widget instance.
         */
        public function widget($args, $instance) {
            if (!is_shop() && !is_product_taxonomy()) {
                return;
            }

            $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
            $min_price = isset($_GET['min_price']) ? wc_clean(wp_unslash($_GET['min_price'])) : 0;
            $max_price = isset($_GET['max_price']) ? wc_clean(wp_unslash($_GET['max_price'])) : 0;
            $rating_filter = isset($_GET['rating_filter']) ? array_filter(array_map('absint', explode(',', wp_unslash($_GET['rating_filter'])))) : array();
            $status_filter = false;
            if (class_exists('Trade_Ace_WC_Widget_Status_Filter')) {
                foreach (Trade_Ace_WC_Widget_Status_Filter::$_status as $status) {
                    if (isset($_REQUEST[$status]) && $_REQUEST[$status] === '1') {
                        $status_filter = true;
                        break;
                    }
                }
            }
            
            $tags_filter = false;
            if (class_exists('Trade_Ace_WC_Widget_Tags_Filter')) {
                if (isset($_REQUEST[Trade_Ace_WC_Widget_Tags_Filter::$_request_name]) && !empty($_REQUEST[Trade_Ace_WC_Widget_Tags_Filter::$_request_name])) {
                    $tags_filter = true;
                }
            }

            if (0 < count($_chosen_attributes) || 0 < $min_price || 0 < $max_price || !empty($rating_filter) || $status_filter || $tags_filter) {
                global $wp_query;
                
                $title = isset($instance['title']) ? $instance['title'] : esc_html__('Reset', 'tradeace-theme');
                
                $tradeace_href_page = tradeace_get_origin_url_paging();
                
                // Reset Price, Rating Filter
                $reset_arrays = array('min_price', 'max_price', 'rating_filter');
                
                // Reset Status Filter
                if ($status_filter) {
                    $reset_arrays = array_merge($reset_arrays, Trade_Ace_WC_Widget_Status_Filter::$_status);
                }
                
                // Reset Multi Tags Filter
                if ($tags_filter) {
                    $reset_arrays[] = Trade_Ace_WC_Widget_Tags_Filter::$_request_name;
                }
                
                // Reset Attributes Filter
                $array_add = array();
                if (!empty($_GET) && count($_chosen_attributes)) {
                    foreach ($_GET as $key => $value) {
                        if (0 === strpos($key, 'filter_')) {
                            $attribute = wc_sanitize_taxonomy_name(str_replace('filter_', '', $key));
                            $reset_arrays[] = $key;
                            $reset_arrays[] = 'query_type_' . $attribute;
                        } else {
                            if (!in_array($key, $reset_arrays)) {
                                $array_add[$key] = $value;
                            }
                        }
                    }
                }
                
                $tradeace_href_page = remove_query_arg($reset_arrays, add_query_arg($array_add, $tradeace_href_page));
                
                $tradeace_cat_obj = $wp_query->get_queried_object();
                
                if (isset($tradeace_cat_obj->term_id) && isset($tradeace_cat_obj->taxonomy)) {
                    $tradeace_term_id = (int) $tradeace_cat_obj->term_id;
                    $tradeace_type_page = $tradeace_cat_obj->taxonomy;
                } else {
                    $tradeace_term_id = 0;
                    $tradeace_type_page = 'product_cat';
                }

                $this->widget_start($args, $instance);

                echo '<a data-id="' . $tradeace_term_id . '" data-taxonomy="' . $tradeace_type_page . '" class="tradeace-reset-filters-btn" href="' . esc_url($tradeace_href_page) . '" title="' . $title . '">' . $title . '</a>';

                $this->widget_end($args);
            }
        }

    }

}
