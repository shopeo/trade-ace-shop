<?php
/*
  Template name: Tradeace View Compare
  This templates View products in compare.
 */
global $yith_woocompare;
if (!$yith_woocompare) :
    wp_redirect(esc_url(home_url('/')));
endif;

get_header(); ?>

<div class="page-wrapper tradeace-view-compare">
    <div class="row">
        <div id="content" class="large-12 columns">
            <!-- Compare products -->
            <?php
            tradeace_products_compare_content(true);
            
            while (have_posts()) :
                the_post();
                the_content();
            endwhile;
            ?>
        </div><!-- end #content large-12 -->
    </div><!-- end row -->
</div><!-- end page-view-compare wrapper -->

<?php
get_footer();
