<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Tradeace Wishlist
 * 
 * Since 3.0
 */
if (!TRADEACE_WISHLIST_ENABLE && TRADEACE_WOO_ACTIVED) :

    class TRADEACE_WOO_WISHLIST {
        
        /**
         * instance of the class
         */
        protected static $instance = null;
        
        /**
         * Support multi Languages
         */
        protected $multi_langs = false;

        /**
         * Current Language
         */
        public $current_lang = '';
        
        /**
         * List Languages
         */
        public $languages = array();

        /**
         * Cookie name
         */
        public $cookie_name = 'tradeace_wishlist';
        
        /**
         * wishlist_list
         */
        public $wishlist_list = array();
        
        /**
         * expire time
         */
        public $expire = 0;

        /**
         * Init Class
         */
        public static function init() {
            global $tradeace_opt;

            if (isset($tradeace_opt['enable_tradeace_wishlist']) && !$tradeace_opt['enable_tradeace_wishlist']) {
                return null;
            }

            if (null == self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }
        
        /**
         * Constructor.
         */
        public function __construct() {
            $siteurl = get_option('siteurl');
            $this->cookie_name .= $siteurl ? '_' . md5($siteurl) : '';
            
            $this->current_lang = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : get_option('WPLANG');
            if (trim($this->current_lang) == '') {
                $this->current_lang = 'default';
            }
            
            $this->languages = array($this->current_lang);
            
            /**
             * Support Multi Languages
             */
            if (function_exists('icl_get_languages')) {
                $this->multi_langs = true;
                $wpml_langs = icl_get_languages('skip_missing=0&orderby=code');
                
                if (!empty($wpml_langs)) {
                    foreach ($wpml_langs as $lang) {
                        if (isset($lang['language_code']) && !in_array($lang['language_code'], $this->languages)) {
                            $this->languages[] = $lang['language_code'];
                        }
                    }
                }
            }
            
            $this->wishlist_list = $this->get_wishlist_list();
            
            $this->expire = TRADEACE_TIME_NOW + (60*60*24*30); // 30 days
            
            add_action('tradeace_show_buttons_loop', array($this, 'btn_in_list'), 20);
            add_action('tradeace_single_buttons', array($this, 'btn_in_detail'), 10);
        }
        
        /**
         * get Cookie Name
         * 
         * @return type
         */
        public function get_cookie_name($_lang = null) {
            $lang = !$_lang ? $this->current_lang : $_lang;
            return $this->cookie_name . '_' . $lang;
        }
        
        /**
         * Get Wishlist items id
         */
        public function get_wishlist_list($_lang = null) {
            $wishlists = isset($_COOKIE[$this->get_cookie_name($_lang)]) ? json_decode($_COOKIE[$this->get_cookie_name($_lang)]) : array();
            
            if (!is_array($wishlists)) {
                $wishlists = array();
            }
            
            return $wishlists;
        }
        
        /**
         * Get Wishlist items id of Current language
         */
        public function get_current_wishlist() {
            return $this->wishlist_list;
        }

        /**
         * btn wishlist in list
         * 
         * @global type $product
         */
        public function btn_wishlist($tip = 'left') {
            global $product;
            
            $variation = false;
            $productId = $product->get_id();
            $productType = $product->get_type();
            if ($productType == 'variation') {
                $variation_product = $product;
                $productId = wp_get_post_parent_id($productId);
                $parentProduct = wc_get_product($productId);
                $productType = $parentProduct->get_type();
                
                $GLOBALS['product'] = $parentProduct;
                $variation = true;
            }
            
            $class_btn = 'btn-wishlist btn-link wishlist-icon btn-tradeace-wishlist tradeace-tip';
            $class_btn .= ' tradeace-tip-' . $tip;
            ?>

            <a href="javascript:void(0);" class="<?php echo esc_attr($class_btn); ?>" data-prod="<?php echo (int) $productId; ?>" data-prod_type="<?php echo esc_attr($productType); ?>" data-icon-text="<?php esc_attr_e('Wishlist', 'tradeace-theme'); ?>" title="<?php esc_attr_e('Wishlist', 'tradeace-theme'); ?>" rel="nofollow">
                <i class="tradeace-icon icon-tradeace-like"></i>
            </a>

            <?php
            if ($variation) {
                $GLOBALS['product'] = $variation_product;
            }
        }
        
        /**
         * btn wishlist in list
         * 
         * @global type $product
         */
        public function btn_in_list() {
            $this->btn_wishlist('left');
        }
        
        /**
         * btn wishlist in detail
         * 
         * @global type $product
         */
        public function btn_in_detail() {
            $this->btn_wishlist('right');
        }

        /**
         * Add Wishlist
         */
        public function add_to_wishlist($_product_id) {
            $product_id = intval($_product_id);
            
            if (!$product_id) {
                return false;
            }
            
            if ($this->languages) {
                foreach ($this->languages as $lang) {
                    $wishlists = $this->get_wishlist_list($lang);
                    
                    if ($this->current_lang == $lang) {
                        $wishlists[] = $product_id;
                        $this->wishlist_list = $wishlists;
                    }
                    
                    /**
                     * Support Multi Languages
                     */
                    else {
                        if ($this->multi_langs) {
                            $product_langID = icl_object_id($product_id, 'product', true, $lang);
                            $wishlists[] = $product_langID;
                        }
                    }
                    
                    $this->set_cookie_wishlist($lang, $wishlists);
                }
            }
            
            return true;
        }
        
        /**
         * Remove from Wishlist
         */
        public function remove_from_wishlist($_product_id) {
            $product_id = intval($_product_id);
            
            if (!$product_id) {
                return false;
            }
            
            if ($this->languages) {
                foreach ($this->languages as $lang) {
                    if ($this->current_lang == $lang) {
                        $wishlists = $this->wishlist_list;
                        
                        if ($wishlists) {
                            foreach ($wishlists as $k => $v) {
                                if ($v == $product_id) {
                                    unset($wishlists[$k]);
                                }
                            }
                        }
                        
                        $this->wishlist_list = $wishlists;
                    }
                    
                    /**
                     * Support WPML
                     */
                    else {
                        $wishlists = $this->get_wishlist_list($lang);
                        if ($this->multi_langs) {
                            if ($wishlists) {
                                $product_langID = icl_object_id($product_id, 'product', true, $lang);
                                
                                foreach ($wishlists as $k => $v) {
                                    if ($v == $product_langID) {
                                        unset($wishlists[$k]);
                                    }
                                }
                            }
                        }
                    }
                    
                    $this->set_cookie_wishlist($lang, $wishlists);
                }
            }
            
            return true;
        }
        
        /**
         * Count wishlist items
         * 
         * @return type
         */
        public function count_items() {
            return count($this->wishlist_list);
        }

        /**
         * Set cookie wishlist
         */
        protected function set_cookie_wishlist($lang = null, $wishlists = array()) {
            setcookie($this->get_cookie_name($lang), json_encode(array_values($wishlists)), $this->expire, COOKIEPATH, COOKIE_DOMAIN, false, false);
        }
        
        /**
         * Wishlist html
         */
        public function wishlist_html() {
            global $tradeace_opt;
            
            $wishlist_items = $this->wishlist_list;
            
            $file = TRADEACE_CHILD_PATH . '/includes/tradeace-sidebar-wishlist_html.php';
            include is_file($file) ? $file : TRADEACE_THEME_PATH . '/includes/tradeace-sidebar-wishlist_html.php';
        }
    }

    /**
     * Init TradeaceTheme Wishlist
     */
    add_action('init', 'tradeace_woo_wishlist');
    if (!function_exists('tradeace_woo_wishlist')) :
        function tradeace_woo_wishlist() {
            return TRADEACE_WOO_WISHLIST::init();
        }
    endif;
endif;
