<?php
/**
 * Checkout coupon form
 * 
 * @author  TradeaceTheme
 * @package Tradeace-theme/WooCommerce
 * @version 3.4.4
 */
defined('ABSPATH') || exit;

if (!wc_coupons_enabled()) { // @codingStandardsIgnoreLine.
    return;
}
?>
<div class="woocommerce-form-coupon-toggle tradeace-toggle-coupon-checkout">
    <?php wc_print_notice(apply_filters('woocommerce_checkout_coupon_message', __('Have a coupon?', 'tradeace-theme') . ' <a href="#" class="showcoupon">' . __('Click here to enter your code', 'tradeace-theme') . '</a>'), 'notice'); ?>
</div>

<form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">
    <p><?php esc_html_e('If you have a coupon code, please apply it below.', 'tradeace-theme'); ?></p>

    <div class="form-row form-row-first coupon">
        <input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e('Coupon code', 'tradeace-theme'); ?>" id="coupon_code" value="" />
        <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'tradeace-theme'); ?>"><?php esc_html_e('Apply coupon', 'tradeace-theme'); ?></button>
    </div>
</form>
