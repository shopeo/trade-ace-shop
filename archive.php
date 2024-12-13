<?php
/**
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package tradeacetheme
 */

$tradeace_sidebar = isset($tradeace_opt['blog_layout']) ? $tradeace_opt['blog_layout'] : 'left';
$hasSidebar = true;
$left = true;
switch ($tradeace_sidebar):
    case 'right':
        $left = false;
        $attr = 'large-9 desktop-padding-right-30 left columns';
        break;
    
    case 'no':
        $hasSidebar = false;
        $left = false;
        $attr = 'large-12 columns';
        break;
    
    case 'left':
    default:
        $attr = 'large-9 desktop-padding-left-30 right columns';
        break;
endswitch;

$class_wrap = 'container-wrap mobile-padding-top-10';
$class_wrap .= $tradeace_sidebar ? ' page-' . $tradeace_sidebar . '-sidebar' : ' page-left-sidebar';

if (isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile']) :
    $attr .= ' tradeace-blog-in-mobile';
endif;

$headling = !isset($tradeace_opt['blog_heading']) || $tradeace_opt['blog_heading'] ? true : false;

get_header();

/**
 * Hook: tradeace_before_archive_blog.
 */
do_action('tradeace_before_archive_blogs');
?>

<div class="<?php echo esc_attr($class_wrap); ?>">

    <?php if ($hasSidebar): ?>
        <div class="div-toggle-sidebar tradeace-blog-sidebar center">
            <a class="toggle-sidebar" href="javascript:void(0);" rel="nofollow">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    <?php endif; ?>

    <div class="row">
        <div id="content" class="<?php echo esc_attr($attr); ?>">
            <?php if (have_posts()) : ?>
                <?php if ($headling) : ?>
                    <header class="page-header">
                        <h1 class="page-title">
                            <?php
                            if (is_category()) :
                                printf(esc_html__('Category Archives: %s', 'tradeace-theme'), '<span>' . single_cat_title('', false) . '</span>');

                            elseif (is_tag()) :
                                printf(esc_html__('Tag Archives: %s', 'tradeace-theme'), '<span>' . single_tag_title('', false) . '</span>');

                            elseif (is_author()) : the_post();
                                printf(esc_html__('Author Archives: %s', 'tradeace-theme'), '<span class="vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author() . '</a></span>');
                                rewind_posts();

                            elseif (is_day()) :
                                printf(esc_html__('Daily Archives: %s', 'tradeace-theme'), '<span>' . get_the_date() . '</span>');

                            elseif (is_month()) :
                                printf(esc_html__('Monthly Archives: %s', 'tradeace-theme'), '<span>' . get_the_date('F Y') . '</span>');

                            elseif (is_year()) :
                                printf(esc_html__('Yearly Archives: %s', 'tradeace-theme'), '<span>' . get_the_date('Y') . '</span>');

                            elseif (is_tax('post_format', 'post-format-aside')) :
                                esc_html_e('Asides', 'tradeace-theme');

                            elseif (is_tax('post_format', 'post-format-image')) :
                                esc_html_e('Images', 'tradeace-theme');

                            elseif (is_tax('post_format', 'post-format-video')) :
                                esc_html_e('Videos', 'tradeace-theme');

                            elseif (is_tax('post_format', 'post-format-quote')) :
                                esc_html_e('Quotes', 'tradeace-theme');

                            elseif (is_tax('post_format', 'post-format-link')) :
                                esc_html_e('Links', 'tradeace-theme');

                            else :
                                esc_html_e('', 'tradeace-theme');

                            endif;
                            ?>
                        </h1>
                        <?php
                        if (is_category()) :
                            $category_description = category_description();
                            if (!empty($category_description)) :
                                echo apply_filters('category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>');
                            endif;

                        elseif (is_tag()) :
                            $tag_description = tag_description();
                            if (!empty($tag_description)) :
                                echo apply_filters('tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>');
                            endif;

                        endif;
                        ?>
                    </header>
                <?php endif; ?>

                <div class="page-inner">
                    <?php get_template_part('content', get_post_format()); ?>
                </div>
            <?php else : ?>
                <?php get_template_part('no-results', 'archive'); ?>
            <?php endif; ?>
        </div>

        <?php if ($tradeace_sidebar != 'no') : ?>
            <div class="large-3 columns <?php echo ($left) ? 'left desktop-padding-right-20' : 'right desktop-padding-left-20'; ?> col-sidebar">
                <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'tradeace-theme'); ?>" class="hidden-tag tradeace-close-sidebar" rel="nofollow">
                    <?php echo esc_html__('Close', 'tradeace-theme'); ?>
                </a>
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
get_footer();
