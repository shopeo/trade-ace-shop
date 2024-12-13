<?php
$number_slide = (isset($tradeace_opt['number_post_slide']) && (int) $tradeace_opt['number_post_slide']) ? (int) $tradeace_opt['number_post_slide'] : 1;

$style_bg = (isset($tradeace_opt['background_area']) && $tradeace_opt['background_area']) ? 'background: url(\'' . $tradeace_opt['background_area'] . '\') center center no-repeat;' : '';

$style_bg = ($style_bg != '') ? ' style="' . esc_attr($style_bg) . '"' : '';

$style_color = (isset($tradeace_opt['t_promotion_color']) && $tradeace_opt['t_promotion_color']) ? 'color:' . $tradeace_opt['t_promotion_color'] : '';

$style_color = ($style_color != '') ? ' style="' . esc_attr($style_color) . '"' : '';
?>

<div class="section-element tradeace-promotion-news tradeace-hide">
    <div class="tradeace-wapper-promotion">
        <div class="tradeace-content-promotion-news <?php echo (!isset($tradeace_opt['enable_fullwidth']) || $tradeace_opt['enable_fullwidth'] == 1) ? 'tradeace-row fullwidth' : 'row'; ?>"<?php echo $style_bg; ?>>
            <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'tradeace-theme'); ?>" class="tradeace-promotion-close tradeace-a-icon" rel="nofollow"><i class="pe-7s-close-circle"></i></a>

            <?php if ($content): ?>
                <div class="tradeace-content-promotion-custom"<?php echo $style_color; ?>>
                    <?php echo do_shortcode($content); ?>
                </div>
            <?php elseif (!empty($posts)): ?>
                <div class="tradeace-post-slider hidden-tag" data-autoplay="true" data-columns="<?php echo esc_attr($number_slide); ?>" data-columns-small="1" data-columns-tablet="1" data-switch-tablet="<?php echo tradeace_switch_tablet(); ?>" data-switch-desktop="<?php echo tradeace_switch_desktop(); ?>">
                    <?php foreach ($posts as $v): ?>
                        <div class="tradeace-post-slider-item">
                            <a href="<?php echo esc_url(get_permalink($v->ID)); ?>" title="<?php echo esc_attr($v->post_title); ?>"<?php echo $style_color; ?>><?php echo $v->post_title; ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="tradeace-position-relative"></div>
<a href="javascript:void(0);" title="<?php echo esc_attr__('Show', 'tradeace-theme'); ?>" class="tradeace-promotion-show" rel="nofollow"><i class="pe-7s-angle-down"></i></a>
