<?php
/**
 * The template for displaying search forms mobile in tradeacetheme
 *
 * @package     tradeacetheme
 * @version     1.0.0
 */

$url = home_url('/');
$postType = apply_filters('tradeace_mobile_search_post_type', 'product');
$classInput = 'search-field search-input';
$placeHolder = esc_attr__("Start typing ...", 'tradeace-theme');
$classWrap = 'tradeace-search-form';
if ($postType === 'product') {
    $classInput .= ' live-search-input';
    $classWrap = 'tradeace-ajax-search-form';
    $placeHolder = esc_attr__("I'm shopping for ...", 'tradeace-theme');
}
?>

<div class="search-wrapper <?php echo esc_attr($classWrap); ?>-container">
    <form method="get" class="<?php echo esc_attr($classWrap); ?>" action="<?php echo esc_url($url); ?>">
        <label for="tradeace-input-mobile-search" class="hidden-tag">
            <?php esc_html_e('Search here', 'tradeace-theme'); ?>
        </label>
        
        <input id="tradeace-input-mobile-search" type="text" class="<?php echo esc_attr($classInput); ?>" value="<?php echo get_search_query();?>" name="s" placeholder="<?php echo $placeHolder; ?>" />

        <?php if ($postType) : ?>
            <input type="hidden" class="search-param" name="post_type" value="<?php echo esc_attr($postType); ?>" />
        <?php endif; ?>

        <input class="tradeace-vitual-hidden" type="submit" name="page" value="search" />
    </form>
</div>
