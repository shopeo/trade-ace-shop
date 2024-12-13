<?php
global $product;
$products = $tradeace_compare->get_products_list();
$fields = $tradeace_compare->fields();
?>
<div class="tradeace-wrap-table-compare">
    <?php
    if ($products) :
        $add_to_cart = array(); ?>
        <table class="tradeace-table-compare">
            <?php 
            foreach ($fields as $field => $name) :
                if ($field == 'title') :
                    continue;
                endif;
                ?>
                <tr class="<?php echo esc_attr($field); ?>">
                    <th>
                        <?php echo ($field == 'image') ? esc_html__('Product', 'tradeace-theme') : $name; ?>
                        <?php echo ($field == 'image') ? '<div class="fixed-th"></div>' : ''; ?>
                    </th>

                    <?php
                    $index = 0;
                    foreach ($products as $product_id => $product) :
                        $product_class = ($index % 2 == 0 ? 'odd' : 'even') . ' tradeace-compare-view-product_' . $product_id;
                        ?>
                        <td class="<?php echo esc_attr($product_class); ?>">
                            <?php
                            switch ($field) :
                                case 'image':
                                    $tradeace_title = isset($product->fields['title']) ? $product->fields['title'] : '';
                                    $href = get_permalink($product_id);
                                    echo '<a href="' . esc_url($href) . '" title="' . esc_attr($product->fields['title']) . '">';

                                    echo '<div class="image-wrap">' . $product->get_image('thumbnail', array('alt' => esc_attr($tradeace_title))) . '</div>';
                                    echo ($tradeace_title != '') ? '<h5 class="compare-product-title">' . $tradeace_title . '</h5>' : '';
                                    echo '</a>';
                                    
                                    break;

                                case 'title':

                                    break;

                                case 'add-to-cart':
                                    $add_to_cart[$product_id] = tradeace_product_group_button('popup');
                                    echo $add_to_cart[$product_id] ? '<div class="tradeace-group-btns">' . $add_to_cart[$product_id] . '</div>' : '';
                                    
                                    break;

                                default:
                                    echo empty($product->fields[$field]) ? '&nbsp;' : $product->fields[$field];
                                    break;
                            endswitch;
                            ?>
                        </td>
                        <?php
                        ++$index;
                    endforeach;
                    ?>

                </tr>

            <?php endforeach; ?>

            <?php if (get_option('yith_woocompare_price_end') == 'yes' && isset($fields['price'])) : ?>
                <tr class="price repeated">
                    <th><?php echo ($fields['price']); ?></th>

                    <?php
                    $index = 0;
                    foreach ($products as $product_id => $product) :
                        $product_class = ($index % 2 == 0 ? 'odd' : 'even') . ' tradeace-compare-view-product_' . $product_id
                        ?>
                        <td class="<?php echo esc_attr($product_class); ?>">
                            <?php echo ($product->fields['price']); ?>
                        </td>
                        <?php
                        ++$index;
                    endforeach;
                    ?>

                </tr>
            <?php endif; ?>

            <?php if (get_option('yith_woocompare_add_to_cart_end') == 'yes' && isset($fields['add-to-cart'])) : ?>
                <tr class="add-to-cart repeated">
                    <th><?php echo ($fields['add-to-cart']); ?></th>
                    <?php
                    $index = 0;
                    foreach ($products as $product_id => $product) :
                        $product_class = ($index % 2 == 0 ? 'odd' : 'even') . ' tradeace-compare-view-product_' . $product_id
                        ?>
                        <td class="<?php echo ($product_class); ?> tradeace-group-btns">
                            <?php
                            if (isset($add_to_cart[$product_id])) :
                                echo '<div class="tradeace-group-btns">' . $add_to_cart[$product_id] . '</div>';
                            else:
                                woocommerce_template_loop_add_to_cart();
                            endif;
                            ?>
                        </td>
                        <?php
                        ++$index;
                    endforeach;
                    ?>
                </tr>
            <?php endif; ?>
            <tr class="remove-item">
                <th>&nbsp;</th>

                <?php
                $index = 0;
                foreach ($products as $product_id => $product) :
                    $product_class = ($index % 2 == 0 ? 'odd' : 'even') . ' tradeace-compare-view-product_' . $product_id
                    ?>
                    <td class="<?php echo esc_attr($product_class); ?>">
                        <a href="javascript:void(0);" class="tradeace-remove-compare" data-prod="<?php echo esc_attr($product_id); ?>" rel="nofollow"><?php echo esc_html__('Remove', 'tradeace-theme'); ?></a>
                    </td>
                    <?php
                    ++$index;
                endforeach;
                ?>
            </tr>
        </table>
    <?php
    else:
        echo '<p class="text-center padding-top-30"><i class="tradeace-empty-icon icon-tradeace-refresh"></i></p>';
        echo '<h5 class="text-center margin-bottom-30 empty woocommerce-compare__empty-message">' . esc_html__('No product added to compare !', 'tradeace-theme') . '</h5>';
        echo '<p class="text-center"><a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '" class="button tradeace-sidebar-return-shop" title="' . esc_attr__('RETURN TO SHOP', 'tradeace-theme') . '">' . esc_html__('RETURN TO SHOP', 'tradeace-theme') . '</a></p>';
    endif;
    ?>
</div>