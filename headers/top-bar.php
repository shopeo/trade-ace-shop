<?php 
$topbar_left = !isset($topbar_left) ? '' : $topbar_left;
$class_topbar = !isset($class_topbar) ? '' : $class_topbar;
$class_topbar .= trim($topbar_left) != '' ? '' : ' hide-for-mobile';
?>
<div class="tradeace-topbar-wrap<?php echo esc_attr($class_topbar); ?>">
    <div id="top-bar" class="top-bar">
        <?php if (!$mobile) : ?>
            <!-- Desktop | Responsive Top-bar -->
            <div class="row">
                <div class="large-12 columns">
                    <div class="left-text left rtl-right">
                        <?php echo $topbar_left; ?>
                    </div>
                    <div class="right-text tradeace-hide-for-mobile right rtl-left">
                        <div class="topbar-menu-container">
                            <?php do_action('tradeace_topbar_menu'); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <!-- Mobile Top-bar -->
            <div class="topbar-mobile-text">
                <?php echo $topbar_left; ?>
            </div>
            <div class="topbar-menu-container hidden-tag">
                <?php do_action('tradeace_mobile_topbar_menu'); ?>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if (!$mobile) : ?>
        <div class="tradeace-hide-for-mobile">
            <a class="tradeace-icon-toggle" href="javascript:void(0);" rel="nofollow">
                <i class="tradeace-topbar-up pe-7s-angle-up"></i>
                <i class="tradeace-topbar-down pe-7s-angle-down"></i>
            </a>
        </div>
    <?php endif; ?>
</div>
