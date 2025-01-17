<?php
/**
 * Thankyou page
 * 
 * @author  TradeaceTheme
 * @package Tradeace-theme/WooCommerce
 * @version 3.7.0
 */

defined('ABSPATH') or exit;

echo '<div class="woocommerce-order">';

if ($order) : ?>
<div class="row tradeace-order-received">
    <div class="large-12 columns tradeace-order-received-left">
        <div class="tradeace-warper-order margin-bottom-20">
            <?php if ($order->has_status('failed')) : ?>
                <p class="woocommerce-thankyou-order-failed"><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'tradeace-theme'); ?></p>

                <p class="woocommerce-thankyou-order-failed-actions">
                    <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="button pay"><?php esc_html_e('Pay', 'tradeace-theme') ?></a>
                    <?php if (TRADEACE_CORE_USER_LOGGED) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button pay"><?php esc_html_e('My Account', 'tradeace-theme'); ?></a>
                    <?php endif; ?>
                </p>
            <?php else : ?>
                <p class="woocommerce-thankyou-order-received"><?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'tradeace-theme'), $order); ?></p>
                <ul class="woocommerce-thankyou-order-details order_details">
                    <li class="order">
                        <?php esc_html_e('Order Number:', 'tradeace-theme'); ?>
                        <strong><?php echo (int) $order->get_order_number(); ?></strong>
                    </li>
                    <li class="date">
                        <?php esc_html_e('Date:', 'tradeace-theme'); ?>
                        <strong><?php echo wc_format_datetime($order->get_date_created()); ?></strong>
                    </li>
                    <li class="total">
                        <?php esc_html_e('Total:', 'tradeace-theme'); ?>
                        <strong><?php echo ($order->get_formatted_order_total()); ?></strong>
                    </li>
                    <?php if ($order->get_payment_method_title()) : ?>
                        <li class="method">
                            <?php esc_html_e('Payment Method:', 'tradeace-theme'); ?>
                            <strong><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="clear"></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="large-12 columns tradeace-order-received-right">
        <div class="tradeace-warper-order">
            <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
            <?php do_action('woocommerce_thankyou', $order->get_id()); ?>
        </div>
    </div>
</div>
<?php else : ?>
    <p class="woocommerce-thankyou-order-received"><?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'tradeace-theme'), null); ?></p>
<?php
endif;

echo '</div>';
