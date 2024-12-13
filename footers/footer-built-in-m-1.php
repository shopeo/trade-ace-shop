<?php
if (is_active_sidebar('footer-mobile')) : ?>
    <div class="row footer-mobile tradeace-border-top">
        <div class="large-12 tradeace-col columns">
            <?php
            // No.1
            dynamic_sidebar('footer-mobile'); ?>
        </div>
    </div>
<?php
endif;
