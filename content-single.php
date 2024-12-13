<?php
/**
 * @package tradeacetheme
 */
global $tradeace_opt;

$tradeace_main_thumb = (!isset($tradeace_opt['main_single_post_image']) || $tradeace_opt['main_single_post_image']) && has_post_thumbnail() ? true : false;

$categories = !isset($tradeace_opt['single_cat_info']) || $tradeace_opt['single_cat_info'] ? get_the_category_list(esc_html__(', ', 'tradeace-theme')) : null;

$tags = !isset($tradeace_opt['show_tags_info']) || $tradeace_opt['show_tags_info'] ? get_the_tag_list() : null;

$shares = null;
if (!isset($tradeace_opt['show_share_icons_info']) || $tradeace_opt['show_share_icons_info']) :
    $shares = shortcode_exists('tradeace_share') ? do_shortcode('[tradeace_share el_class="text-right mobile-text-left rtl-mobile-text-right rtl-text-left"]') : null;
endif;

do_action('tradeace_before_single_post');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ($tradeace_main_thumb) : ?>
        <div class="entry-image text-center margin-bottom-30">
            <?php the_post_thumbnail(); ?>
        </div>
    <?php endif; ?>
    
    <header class="entry-header margin-bottom-15 text-center">
        <?php if ($categories) :
            echo '<div class="tradeace-meta-categories">' . $categories . '</div>';
        endif; ?>
        <h1 class="entry-title tradeace-title-single-post"><?php the_title(); ?></h1>
        
        <?php if (!isset($tradeace_opt['show_author_date_info']) || $tradeace_opt['show_author_date_info']) : ?>
            <div class="entry-meta">
                <?php tradeace_posted_on(); ?>
            </div>
        <?php endif; ?>
    </header>

    <div class="entry-content">
        <?php
        the_content();
        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'tradeace-theme'),
            'after' => '</div>',
        ));
        ?>
    </div>

    <?php if ($tags || $shares) : ?>
        <footer class="entry-meta footer-entry-meta single-footer-entry-meta">
            <div class="row">
                <div class="columns large-7 medium-7 tradeace-min-height rtl-right">
                    <?php if ($tags) : ?>
                        <div class="tradeace-meta-tags rtl-text-right">
                            <?php echo $tags; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($shares) : ?>
                    <div class="columns large-5 medium-5 tradeace-meta-social mobile-margin-top-20 rtl-left">
                        <?php echo $shares; ?>
                    </div>
                <?php endif; ?>
            </div>
        </footer>
    <?php endif; ?>

</article>

<?php do_action('tradeace_after_content_single_post'); ?>

<div class="tradeace-clear-both"></div>

<?php
if (comments_open() || '0' != get_comments_number()):
    comments_template();
endif;

do_action('tradeace_after_single_post');
