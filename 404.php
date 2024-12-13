<?php
/**
 * @package tradeacetheme
 */
get_header(); ?>

<div class="container-wrap">
    <div class="row">
        <div class="large-12 left columns">
            <article id="post-0" class="post error404 not-found text-center">
                <header class="entry-header">
                    <img src="<?php echo apply_filters('tradeace_404_image_src', TRADEACE_THEME_URI.'/assets/images/404.png'); ?>" alt="<?php esc_attr_e('404', 'tradeace-theme');?>" />
                    <h1 class="entry-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'tradeace-theme'); ?></h1>
                </header><!-- .entry-header -->
                <div class="entry-content">
                    <p><?php esc_html_e('Sorry, but the page you are looking for is not found. Please, make sure you have typed the current URL.', 'tradeace-theme'); ?></p>
                    <?php get_search_form(); ?>
                    <a class="button medium" href="<?php echo esc_url(home_url('/'));?>"><?php esc_html_e('GO TO HOME','tradeace-theme');?></a>
                </div>
            </article>
        </div>
    </div>
</div>

<?php
get_footer();
