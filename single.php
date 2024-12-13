<?php
/**
 * The Template for displaying all single posts.
 *
 * @package tradeacetheme
 */
$tradeace_sidebar = isset($tradeace_opt['single_blog_layout']) ? $tradeace_opt['single_blog_layout'] : 'left';
if (!is_active_sidebar('blog-sidebar')) :
    $tradeace_sidebar = 'no';
endif;

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
        $attr = 'large-10 columns large-offset-1';
        break;
    
    case 'left':
    default:
        $attr = 'large-9 desktop-padding-left-30 right columns';
        break;
endswitch;

if (isset($tradeace_opt['tradeace_in_mobile']) && $tradeace_opt['tradeace_in_mobile']) :
    $attr .= ' tradeace-blog-in-mobile';
endif;

$class_wrap = 'container-wrap mobile-padding-top-10 tradeace-single-blog page-' . $tradeace_sidebar . '-sidebar';

get_header();
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
            <div class="page-inner">
                <?php
                while (have_posts()) : the_post();
                    include TRADEACE_THEME_PATH . '/content-single.php';
                endwhile;
                ?>
            </div>
        </div>

        <?php if ($tradeace_sidebar != 'no') : ?>
            <div class="large-3 columns <?php echo ($left) ? 'left' : 'right'; ?> col-sidebar">
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
