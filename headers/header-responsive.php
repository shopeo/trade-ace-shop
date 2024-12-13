

<div class="mobile-menu header-responsive">
    <div class="mini-icon-mobile">
        <a href="javascript:void(0);" class="tradeace-icon tradeace-mobile-menu_toggle mobile_toggle tradeace-mobile-menu-icon pe-7s-menu" rel="nofollow"></a>
        <a class="tradeace-icon icon pe-7s-search mobile-search" href="javascript:void(0);" rel="nofollow"></a>
    </div>

    <div class="logo-wrapper">
        <?php echo tradeace_logo(); ?>
    </div>

    <?php
    $show_icons = isset($tradeace_opt['topbar_mobile_icons_toggle']) && $tradeace_opt['topbar_mobile_icons_toggle'] ? false : true;
    $class_icons_wrap = '';
    $toggle_icon = '';

    if (!$show_icons) :
        $class_icons_wrap .= ' tradeace-absolute-icons tradeace-hide-icons';
        $toggle_icon .= '<a class="tradeace-toggle-mobile_icons" href="javascript:void(0);" rel="nofollow"><span class="tradeace-icon"></span></a>';
    endif;

    echo '<div class="tradeace-mobile-icons-wrap' . $class_icons_wrap . '">';
    echo $toggle_icon;
    echo tradeace_header_icons(true, true, true, true, false);
    echo '</div>';
    ?>
</div>
