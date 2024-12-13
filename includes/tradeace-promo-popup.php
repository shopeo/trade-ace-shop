<?php
$pp_style = isset($tradeace_opt['pp_style']) && $tradeace_opt['pp_style'] == 'full' ? 'full' : 'simple';
$class_content = 'columns large-6 medium-6 small-12 tradeace-pp-right';
$class_content .= $pp_style == 'full' ? ' large-12' : ' large-6 right';
?>
<div id="tradeace-popup" class="white-popup-block mfp-hide mfp-with-anim zoom-anim-dialog">
    <div class="row">
        <?php if ($pp_style == 'simple'): ?>
            <div class="columns large-6 medium-6 small-12 tradeace-pp-left"></div>
        <?php endif; ?>
        
        <div class="<?php echo esc_attr($class_content); ?>">
            <div class="tradeace-popup-wrap tradeace-relative">
                <div class="tradeace-popup-wrap-content">
                    <?php
                    /**
                     * Content description
                     */
                    echo isset($tradeace_opt['pp_content']) ? do_shortcode($tradeace_opt['pp_content']) : '';
                    
                    /**
                     * Content contact form 7
                     */
                    echo isset($tradeace_opt['pp_contact_form']) ? tradeace_get_newsletter_form((int) $tradeace_opt['pp_contact_form']) : '';
                    ?>
                </div>
                <hr class="tradeace-popup-hr" />
                <p class="checkbox-label align-center">
                    <input type="checkbox" value="do-not-show" name="showagain" id="showagain" class="showagain" />
                    <label for="showagain">
                        <?php esc_html_e("Don't show this popup again", 'tradeace-theme'); ?>
                    </label>
                </p>
            </div>
        </div>
    </div>
</div>
