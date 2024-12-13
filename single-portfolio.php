<?php
/**
 * The Template for displaying single portfolio project.
 *
 */

if (!TRADEACE_CORE_ACTIVED || (isset($tradeace_opt['enable_portfolio']) && !$tradeace_opt['enable_portfolio'])) :
    include_once TRADEACE_THEME_PATH . '/404.php';
    exit(); // Exit if tradeace-core has not actived OR disable Fortfolios
endif;

get_header();
?>

<div class="row">
    <div class="content large-12 columns margin-bottom-70">
        <?php if (have_posts()) :
            while (have_posts()) :
                the_post(); ?>
                <div class="portfolio-single-item">
                    <?php the_content(); ?>
                </div>
            <?php 
            endwhile;
        else : ?>
            <h3><?php esc_html_e('No pages were found!', 'tradeace-theme') ?></h3>
        <?php endif; ?>
        <div class="clear"></div>
        <?php
        if (!isset($tradeace_opt['portfolio_comments']) || $tradeace_opt['portfolio_comments']) :
            comments_template('', true);
        endif;
        if (function_exists('tradeace_get_recent_portfolio') && (!isset($tradeace_opt['recent_projects']) || $tradeace_opt['recent_projects'])) :
            echo tradeace_get_recent_portfolio(8, esc_html__('Recent Works', 'tradeace-theme'), array($post->ID));
        endif;
        ?>
    </div>
</div>
<?php

get_footer();