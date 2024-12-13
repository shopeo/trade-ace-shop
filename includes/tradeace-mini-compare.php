<?php $count_compare = count($tradeace_compare_list); ?>
<div class="tradeace-compare-list">
    <div class="row">
        <div class="large-12 columns">
            <table>
                <tr>
                    <td class="tradeace-td-30">
                        <h5 class="clearfix text-center tradeace-compare-label"><span class="tradeace-block"><?php esc_html_e('Compare Products', 'tradeace-theme'); ?></span><span class="color-gray tradeace-block"> (<?php echo ($count_compare); ?> <?php esc_html_e('Products', 'tradeace-theme'); ?>)</span></h5>
                    </td>
                    <td class="tradeace-td-40 tradeace-td-products-compare">
                        <div class="row padding-side-15">
                            <?php 
                            $k = 0;
                            $class_item = $max_compare == 4 ? 'large-3 small-3 columns' : 'large-4 small-4 columns';
                            if ($tradeace_compare_list) :
                                foreach ($tradeace_compare_list as $product) :
                                    if ($k > $max_compare - 1):
                                        break;
                                    endif;
                                    $productId = $product->get_id();
                                    $tradeace_title = $product->get_name();
                                    $tradeace_href = $product->get_permalink();
                                    ?>
                                    <div class="<?php echo esc_attr($class_item); ?>">
                                        <div class="tradeace-compare-wrap-item">
                                            <div class="tradeace-compare-item-hover">
                                                <div class="tradeace-compare-item-hover-wraper">
                                                    <a href="<?php echo esc_url($tradeace_href); ?>" title="<?php echo esc_attr($tradeace_title); ?>">
                                                        <?php echo $product->get_image(apply_filters('single_product_archive_thumbnail_size', 'shop_catalog'), array('alt' => esc_attr($tradeace_title))); ?>
                                                        <h5 class="margin-top-10"><?php echo ($tradeace_title); ?></h5>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="tradeace-compare-item">
                                                <a href="javascript:void(0);" class="tradeace-remove-compare" data-prod="<?php echo esc_attr($productId); ?>" rel="nofollow"><i class="pe-7s-close"></i></a>
                                                <a href="<?php echo esc_url($tradeace_href); ?>" class="tradeace-img-compare" title="<?php echo esc_attr($tradeace_title); ?>">
                                                    <?php echo $product->get_image('thumbnail', array('alt' => esc_attr($tradeace_title))); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php 
                                $k++;
                                endforeach; ?>
                            <?php endif; ?>

                            <?php if ($k < $max_compare) :
                                $tradeace_src_no_image = wc_placeholder_img_src();
                                for($i=$k; $i<$max_compare; $i++): ?>
                                    <div class="<?php echo esc_attr($class_item); ?>">
                                        <div class="tradeace-compare-wrap-item">
                                            <div class="tradeace-compare-item">
                                                <span class="tradeace-no-image">
                                                    <img src="<?php echo esc_url($tradeace_src_no_image); ?>" width="65" height="65" alt="<?php esc_attr_e("Compare Product", 'tradeace-theme'); ?>" />
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="tradeace-td-30">
                        <div class="tradeace-compare-label<?php echo !$count_compare ? ' hidden-tag' : ''; ?>">
                            <a class="tradeace-compare-clear-all tradeace-hover-underline color-gray" href="javascript:void(0);" title="<?php esc_attr_e('Clear All', 'tradeace-theme'); ?>" rel="nofollow"><?php esc_html_e('Clear All', 'tradeace-theme'); ?></a>
                            <a class="tradeace-compare-view btn button" href="<?php echo esc_url($view_href); ?>" title="<?php esc_attr_e("Let's Compare !", 'tradeace-theme'); ?>"><?php esc_html_e("LET'S COMPARE!", 'tradeace-theme'); ?></a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<a class="tradeace-close-mini-compare tradeace-stclose" href="javascript:void(0)" rel="nofollow"></a>
