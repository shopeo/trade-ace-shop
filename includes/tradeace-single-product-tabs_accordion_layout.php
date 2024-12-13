<?php
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

$k_acc = 0;
$countTabs = count($tabs);
echo '<div class="row"><div class="large-12 columns">';

foreach ($tabs as $key => $tab) :
    if (!isset($tab['title']) || !isset($tab['callback'])) :
        continue;
    endif;

    $class_node = 'tradeace-single-product-tab tradeace-accordion hidden-tag tradeace-accordion-' . $key;
    $class_node .= $k_acc == 0 ? ' active first' : '';
    $class_node .= $k_acc == $countTabs ? ' last' : '';

    $class_panel = 'hidden-tag tradeace-panel tradeace-content-panel tradeace-content-' . $key;
    $class_panel .= $k_acc == 0 ? ' active first' : '';
    ?>

    <div class="tradeace-accordion-title">
        <a class="<?php echo esc_attr($class_node); ?>" href="javascript:void(0);" data-id="accordion-<?php echo esc_attr($key); ?>" rel="nofollow">
            <?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', $tab['title'], $key); ?>
        </a>
    </div>

    <div class="<?php echo esc_attr($class_panel); ?>" id="tradeace-section-accordion-<?php echo esc_attr($key); ?>">
        <?php
        call_user_func($tab['callback'], $key, $tab);
        ?>
    </div>

    <?php 
    $k_acc++;
endforeach;

echo '</div></div>';
