<?php
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

$tradeace_gdpr_policies = isset($tradeace_opt['tradeace_gdpr_policies']) && $tradeace_opt['tradeace_gdpr_policies'] ? $tradeace_opt['tradeace_gdpr_policies'] : false;
?>

<div class="tradeace-cookie-notice-container">
    <div class="tradeace-cookie-notice-centent">
        <span class="tradeace-notice-text">
            <?php echo esc_html__('We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it.', 'tradeace-theme'); ?>
        </span>

        <?php if ($tradeace_gdpr_policies) : ?>
            <a href="<?php echo esc_url($tradeace_gdpr_policies); ?>" target="_blank" class="tradeace-policies-cookie" title="<?php echo esc_attr__('Privacy Policy', 'tradeace-theme'); ?>"><?php echo esc_html__('Privacy Policy', 'tradeace-theme'); ?></a>
        <?php endif; ?>

        <a href="javascript:void(0);" class="tradeace-accept-cookie" title="<?php echo esc_attr__('Accept', 'tradeace-theme'); ?>" class="button" rel="nofollow"><?php echo esc_html__('Accept', 'tradeace-theme'); ?></a>
    </div>
</div>