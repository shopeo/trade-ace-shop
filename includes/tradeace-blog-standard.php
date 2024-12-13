<?php
$post_type = get_post_type();
$post_blog = 'post' == $post_type ? true : false;
$show_comment = $show_comment_info && comments_open() ? true : false;
?>

<article id="post-<?php echo (int) $postId; ?>" <?php post_class(); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="entry-image tradeace-blog-img">
            <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
                <?php the_post_thumbnail('large'); ?>
                <div class="image-overlay"></div>
            </a>
        </div>
    <?php endif; ?>

    <header class="entry-header">
        <?php
        $categories_list = $post_blog && $show_cat_info ? get_the_category_list(esc_html__(', ', 'tradeace-theme')) : false;
        if ($categories_list) : ?>
            <!-- Categories item -->
            <span class="cat-links-archive tradeace-archive-info">
                <?php echo $categories_list; ?>
            </span>
        <?php endif; ?>
        
        <!-- Title -->
        <h3 class="entry-title tradeace-archive-info">
            <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>" rel="bookmark">
                <?php echo $title; ?>
            </a>
        </h3>

        <?php if ($show_author_info || $show_date_info || $show_comment) : ?>
            <div class="text-left info-wrap tradeace-archive-info">
                <?php if ($show_author_info) : ?>
                    <a href="<?php echo esc_url($link_author); ?>" title="<?php echo esc_attr__('By ', 'tradeace-theme') . esc_attr($author); ?>">
                        <span class="meta-author meta-item inline-block">
                            <i class="pe-7s-user"></i>
                            <?php esc_html_e('By ', 'tradeace-theme'); ?><?php echo $author; ?>
                        </span>
                    </a>
                <?php endif; ?>

                <?php if ($show_date_info) : ?>
                    <a href="<?php echo esc_url($link_date); ?>" title="<?php echo esc_attr__('Posts in ', 'tradeace-theme') . esc_attr($date_post); ?>">
                        <span class="post-date meta-item inline-block">
                            <i class="pe-7s-date"></i>
                            <?php echo $date_post; ?>
                        </span>
                    </a>
                <?php endif; ?>
                
                <?php if ($show_comment) :
                    $count_comments = get_comments_number();
                    $class_number = 'tradeace-comment-count';
                    $class_number .= !$count_comments ? ' tradeace-empty' : '';
                    ?>
                    <a href="<?php echo esc_url($link); ?>#respond" title="<?php echo esc_attr__('Comments', 'tradeace-theme'); ?>">
                        <span class="post-comment-count meta-item inline-block">
                            <i class="pe-7s-comment"></i>
                            <span class="<?php echo esc_attr($class_number); ?>"><?php echo $count_comments; ?></span>
                        </span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($post_type !== 'page' && $show_desc_blog) : ?>
            <div class="entry-summary tradeace-archive-info"><?php the_excerpt(); ?></div>
        <?php endif; ?>

        <?php if ($show_readmore) : ?>
            <div class="entry-readmore tradeace-archive-info">
                <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr__('CONTINUE READING  &#10142;', 'tradeace-theme'); ?>">
                    <?php echo esc_html__('CONTINUE READING  &#10142;', 'tradeace-theme'); ?>
                </a>
            </div>
        <?php endif; ?>
    </header>
    
    <?php
    $tags_list = $post_blog && $show_tag_info ? get_the_tag_list('', esc_html__(', ', 'tradeace-theme')) : false;
    if ($tags_list) : ?>
        <footer class="entry-meta tradeace-archive-info">
            <!-- Tagged -->
            <span class="tags-links">
                <?php printf(esc_html__('Tagged %1$s', 'tradeace-theme'), $tags_list); ?>
            </span>
        </footer>
    <?php endif; ?>
</article>
