<?php
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

$wrap_desc = !isset($tradeace_opt['desc_product_wrap']) || $tradeace_opt['desc_product_wrap'] ? true : false;
$align_tab = isset($tradeace_opt['tab_align_info']) ? 'text-' . $tradeace_opt['tab_align_info'] : 'text-center';

if (isset($tradeace_opt['product_detail_layout']) && $tradeace_opt['product_detail_layout'] == 'full') :
    $align_tab = 'text-center';
endif;
?>
<div class="row">
    <div class="large-12 columns">
        <div class="tradeace-tab-wrap <?php echo esc_attr($align_tab); ?>">
            <ul class="<?php echo esc_attr($class_ul); ?>">
                <?php
                $k_title = 0;
                $countTabs = count($tabs);

                foreach ($tabs as $key => $tab) :
                    if (!isset($tab['title'])) :
                        continue;
                    endif;

                    $class_node = 'tradeace-single-product-tab ' . $key . '_tab tradeace-tab';
                    $class_node .= $k_title == 0 ? ' active first' : '';
                    $class_node .= $k_title == $countTabs-1 ? ' last' : '';
                    ?>
                    <li class="<?php echo esc_attr($class_node); ?>">
                        <a href="javascript:void(0);" data-id="#tradeace-tab-<?php echo esc_attr($key); ?>" rel="nofollow">
                            <?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', $tab['title'], $key); ?>
                        </a>
                    </li>
                    <?php
                    $k_title++;
                endforeach;
                ?>
            </ul>
        </div>
    </div>
</div>

<div class="tradeace-panels<?php echo $wrap_desc ? ' tradeace-desc-wrap' : ' tradeace-desc-no-wrap'; ?>">
    <?php
    $k_tab = 0;
    foreach ($tabs as $key => $tab) :
        if (!isset($tab['callback'])) :
            continue;
        endif;

        $class_panel = 'tradeace-panel tradeace-content-' . $key;
        $class_panel .= $k_tab == 0 ? ' active' : '';
        ?>
        <div class="<?php echo esc_attr($class_panel); ?>" id="tradeace-tab-<?php echo esc_attr($key); ?>">
            <?php
            echo ($wrap_desc || $key !== 'description') ? '<div class="row"><div class="large-12 columns tradeace-content-panel">' : '';
            call_user_func($tab['callback'], $key, $tab);
            echo ($wrap_desc || $key !== 'description') ? '</div></div>' : '';
            ?>
        </div>
        <?php
        $k_tab++;
    endforeach;
    ?>
</div>
