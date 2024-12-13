<?php
/*
  Template name: Page Checkout
 */

get_header();
?>

<div class="container-wrap page-checkout">
    <div class="order-steps">
        <div class="row">
            <div class="large-12 columns">
                <?php if (function_exists('is_wc_endpoint_url')) : ?>
                    <?php if (!is_wc_endpoint_url('order-received')) : ?>
                        <div class="checkout-breadcrumb">
                            <div class="title-cart">
                                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('Shopping Cart', 'tradeace-theme'); ?>">
                                    <h3 class="hide-for-small hide-for-medium ct-1st">01</h3>
                                    <h4 class="ct-2nd"><?php esc_html_e('Shopping Cart', 'tradeace-theme'); ?></h4>
                                    <p class="hide-for-small ct-3th"><?php esc_html_e('Manage Your Items List', 'tradeace-theme'); ?></p>
                                </a>
                            </div>

                            <div class="title-checkout">
                                <h3 class="hide-for-small hide-for-medium ct-1st">02</h3>
                                <h4 class="ct-2nd"><?php esc_html_e('Checkout Details', 'tradeace-theme'); ?></h4>
                                <p class="hide-for-small ct-3th"><?php esc_html_e('Checkout Your Items List', 'tradeace-theme'); ?></p>
                            </div>
                            
                            <div class="title-thankyou">
                                <h3 class="hide-for-small hide-for-medium ct-1st">03</h3>
                                <h4 class="ct-2nd"><?php esc_html_e('Order Complete', 'tradeace-theme'); ?></h4>
                                <p class="hide-for-small ct-3th"><?php esc_html_e('Review Your Order', 'tradeace-theme'); ?></p>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="checkout-breadcrumb">
                            <div class="title-cart">
                                <h3 class="hide-for-small hide-for-medium ct-1st">01</h3>
                                <h4 class="ct-2nd"><?php esc_html_e('Shopping Cart', 'tradeace-theme'); ?></h4>
                                <p class="hide-for-small ct-3th"><?php esc_html_e('Manage Your Items List', 'tradeace-theme'); ?></p>
                                <span class="pe-7s-angle-right"></span>
                            </div>
                            <div class="title-checkout">
                                <h3 class="hide-for-small hide-for-medium ct-1st">02</h3>
                                <h4 class="ct-2nd"><?php esc_html_e('Checkout Details', 'tradeace-theme'); ?></h4>
                                <p class="hide-for-small ct-3th"><?php esc_html_e('Checkout Your Items List', 'tradeace-theme'); ?></p>
                                <span class="pe-7s-angle-right"></span>
                            </div>
                            <div class="title-thankyou tradeace-complete">
                                <h3 class="hide-for-small hide-for-medium ct-1st">03</h3>
                                <h4 class="ct-2nd"><?php esc_html_e('Order Complete', 'tradeace-theme'); ?></h4>
                                <p class="hide-for-small ct-3th"><?php esc_html_e('Review Your Order', 'tradeace-theme'); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?> 
            </div>
        </div>
    </div>
    <div class="row">
        <div id="content" class="large-12 columns">
            <?php
            if (shortcode_exists('woocommerce_checkout')):
                global $post;
                echo !isset($post->post_content) || !has_shortcode($post->post_content, 'woocommerce_checkout') ? do_shortcode('[woocommerce_checkout]') : '';
            endif;
            
            while (have_posts()) :
                the_post();
                the_content();
            endwhile;
            
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
