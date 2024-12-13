<?php
if (wc_get_loop_prop('total')) :
    global $tradeace_opt;

    $_delay = $count = 0;
    $_delay_item = (isset($tradeace_opt['delay_overlay']) && (int) $tradeace_opt['delay_overlay']) ? (int) $tradeace_opt['delay_overlay'] : 100;
    
    $wrapper_class = '';
    if (isset($tradeace_opt['loop_layout_buttons']) && $tradeace_opt['loop_layout_buttons'] != '') {
        $wrapper_class = 'tradeace-' . $tradeace_opt['loop_layout_buttons'];
    }

    while (have_posts()) :
        the_post();
        
        wc_get_template(
            'content-product.php',
            array(
                '_delay' => $_delay,
                'wrapper' => 'li',
                'wrapper_class' => $wrapper_class
            )
        );
        $_delay += $_delay_item;
        $count++;
    endwhile;
    
endif;
