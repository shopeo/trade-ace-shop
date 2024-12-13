<?php
/**
 * The template for displaying search forms in tradeacetheme
 *
 * @package tradeacetheme
 */
global $tradeace_opt, $tradeace_search_form_id;
$_id = isset($tradeace_search_form_id) ? $tradeace_search_form_id : 1;
$GLOBALS['tradeace_search_form_id'] = $_id + 1;

$post_type = apply_filters('tradeace_search_post_type', 'post');
$classInput = 'search-field search-input';
$placeHolder = esc_attr__("Start typing ...", 'tradeace-theme');
$hotkeys = '';
$classWrap = 'tradeace-search-form';
if ($post_type === 'product') {
    $classInput .= ' live-search-input';
    $classWrap = 'tradeace-ajax-search-form';
    $placeHolder = esc_attr__("I'm shopping for ...", 'tradeace-theme');
    
    if (isset($tradeace_opt['hotkeys_search']) && trim($tradeace_opt['hotkeys_search']) !== '') {
        $hotkeys = ' data-suggestions="' . esc_attr($tradeace_opt['hotkeys_search']) . '"';
    }
}
?>
<div class="search-wrapper <?php echo esc_attr($classWrap); ?>-container">
    <form method="get" class="<?php echo esc_attr($classWrap); ?>" action="<?php echo esc_url(home_url('/')); ?>">
        <label for="tradeace-input-<?php echo esc_attr($_id); ?>" class="hidden-tag">
            <?php esc_html_e('Search here', 'tradeace-theme'); ?>
        </label>
        
        <input type="text" name="s" id="tradeace-input-<?php echo esc_attr($_id); ?>" class="<?php echo esc_attr($classInput); ?>" value="<?php echo get_search_query(); ?>" placeholder="<?php echo $placeHolder; ?>"<?php echo $hotkeys;?> />
        
        <span class="tradeace-icon-submit-page">
            <button class="tradeace-submit-search hidden-tag">
                <?php esc_attr_e('Search', 'tradeace-theme'); ?>
            </button>
        </span>
        
        <input type="hidden" name="page" value="search" />
        
        <?php if ($post_type) : ?>
            <input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" />
        <?php endif; ?>
    </form>
    
    <a href="javascript:void(0);" title="<?php esc_attr_e('Close search', 'tradeace-theme'); ?>" class="tradeace-close-search tradeace-stclose" rel="nofollow"></a>
</div>
