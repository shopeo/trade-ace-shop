<?php
/**
 * Template field Captcha Register form
 *
 */
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;
?>
<script type="text/template" id="tmpl-captcha-field-register">
    <p class="form-row padding-top-10">
        <img src="?tradeace-captcha-register={{key}}" class="tradeace-img-captcha" />
        <a class="tradeace-reload-captcha" href="javascript:void(0);" title="<?php echo esc_attr__('Reload', 'tradeace-theme'); ?>" data-time="0" data-key="{{key}}" rel="nofollow"><i class="tradeace-icon icon-tradeace-refresh"></i></a>
        <input type="text" name="tradeace-input-captcha" class="tradeace-text-captcha" value="" placeholder="<?php echo esc_attr__('Captcha Code', 'tradeace-theme'); ?>" />
        <input type="hidden" name="tradeace-captcha-key" value="{{key}}" />
    </p>
</script>