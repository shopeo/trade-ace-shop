<?php
/**
 * The template for displaying Comments.
 *
 * @package tradeacetheme
 */
if (post_password_required()) :
    return;
endif;
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <?php echo esc_html__('Comments', 'tradeace-theme') . ' (' . get_comments_number() . ')'; ?>
        </h3>
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav id="comment-nav-above" class="navigation-comment" role="navigation">
                <div class="nav-previous">
                    <?php previous_comments_link(esc_html__('&larr; Older Comments', 'tradeace-theme')); ?>
                </div>
                <div class="nav-next">
                    <?php next_comments_link(esc_html__('Newer Comments &rarr;', 'tradeace-theme')); ?>
                </div>
            </nav>
        <?php endif; ?>
        <ol class="comment-list">
            <?php wp_list_comments(array('callback' => 'tradeace_comment')); ?>
        </ol>
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav id="comment-nav-below" class="navigation-comment" role="navigation">
                <h1 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'tradeace-theme'); ?></h1>
                <div class="nav-previous">
                    <?php previous_comments_link(esc_html__('&larr; Older Comments', 'tradeace-theme')); ?>
                </div>
                <div class="nav-next">
                    <?php next_comments_link(esc_html__('Newer Comments &rarr;', 'tradeace-theme')); ?>
                </div>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
    <?php
    if (!comments_open() && '0' != get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'tradeace-theme'); ?></p>
    <?php endif; ?>
    <?php comment_form(); ?>
</div>
