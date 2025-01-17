<?php

$paged = get_query_var('paged');
$k = ($k == 0 && $paged > 1) ? 1 : $k;
if ($k == 1) :
    $class_wrap = 'tradeace-posts-masonry-isotope group-blogs';
    $class_wrap .= ' large-block-grid-' . (isset($tradeace_opt['masonry_blogs_columns_desk']) && (int) $tradeace_opt['masonry_blogs_columns_desk'] ? (int) $tradeace_opt['masonry_blogs_columns_desk'] : '3');
    $class_wrap .= ' medium-block-grid-' . (isset($tradeace_opt['masonry_blogs_columns_tablet']) && (int) $tradeace_opt['masonry_blogs_columns_tablet'] ? (int) $tradeace_opt['masonry_blogs_columns_tablet'] : '2');
    $class_wrap .= ' small-block-grid-' . (isset($tradeace_opt['masonry_blogs_columns_small']) && (int) $tradeace_opt['masonry_blogs_columns_small'] ? (int) $tradeace_opt['masonry_blogs_columns_small'] : '1');
    
    echo '<ul class="' . $class_wrap . '">';
endif;

$post_type = get_post_type();
$post_blog = 'post' == $post_type ? true : false;
$show_comment = $show_comment_info && comments_open() ? true : false;
?>

<?php echo ($k == 0) ? '<div class="tradeace-posts-masonry-isotope-item tradeace-posts-sticky-item">' : '<li class="tradeace-posts-masonry-isotope-item tradeace-item-normal entry-blog">'; ?>
    <article id="post-<?php echo absint($postId); ?>" <?php post_class(); ?>>
        <?php if (has_post_thumbnail()) : ?>
            <div class="entry-image blog-image tradeace-blog-img tradeace-blog-img-masonry-isotope">
                <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
                    <div class="blog-image-attachment">
                        <?php the_post_thumbnail($k == 0 ? 'large' : 'medium'); ?>
                        <div class="image-overlay"></div>
                    </div>
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
            
            <h3 class="entry-title tradeace-archive-info">
                <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>" rel="bookmark">
                    <?php echo $title; ?>
                </a>
            </h3>

                
            <?php if ($show_author_info || $show_date_info || $show_comment) : ?>
                <div class="text-left info-wrap tradeace-archive-info">
                    <?php if ($show_author_info) : ?>
                        <a href="<?php echo esc_url($link_author); ?>" title="<?php echo esc_attr($author); ?>">
                            <span class="meta-author meta-item inline-block">
                                <i class="pe-7s-user"></i>
                                <?php echo $author; ?>
                            </span>
                        </a>
                    <?php endif; ?>

                    <?php if ($show_date_info) : ?>
                        <a href="<?php echo esc_url($link_date); ?>" title="<?php echo esc_attr($date_post); ?>">
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

            <?php if ($k == 0) : ?>
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
            <?php endif; ?>
        </header>

        <?php
        if ($k == 0) :
            $tags_list = $post_blog && $show_tag_info ? get_the_tag_list('', esc_html__(', ', 'tradeace-theme')) : false;
            if ($tags_list) : ?>
                <footer class="entry-meta footer-entry-meta">
                    <!-- Tagged -->
                    <span class="tags-links tradeace-archive-info">
                        <?php printf(esc_html__('Tagged %1$s', 'tradeace-theme'), $tags_list); ?>
                    </span>
                </footer>
            <?php endif; ?>
        <?php endif; ?>
    </article>
<?php
echo ($k == 0) ? '</div>' : '</li>';
