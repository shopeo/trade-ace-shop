<?php
/**
 * Login Form
 *
 * @author  TradeaceTheme
 * @package Tradeace-theme/WooCommerce
 * @version 4.1.0
 */
defined('ABSPATH') or exit; // Exit if accessed directly

do_action('woocommerce_before_customer_login_form');
do_action('tradeace_login_register_form');
do_action('woocommerce_after_customer_login_form');
