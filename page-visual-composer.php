<?php
/*
  Template name: Visual Composer Template
 */

get_header();

/* Hook Display popup window */
do_action('tradeace_before_page_wrapper');

while (have_posts()) :
    the_post();
    the_content();
endwhile;

do_action('tradeace_after_page_wrapper');

get_footer();
