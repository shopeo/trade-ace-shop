<div class="header-wrapper header-type-builder">
    <?php
    /**
     * Hook - top bar header
     */
    do_action('tradeace_topbar_header');
    
    if (isset($header_builder) && $header_builder) : ?>
        <div class="header-content-builder tradeace-header-content-builder">
            <div id="masthead" class="site-header">
                <?php echo $header_builder; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
