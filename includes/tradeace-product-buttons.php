<?php
/*
 * Product group button
 */
$combo_show_type = !isset($combo_show_type) || $combo_show_type == 'rowdown' ? 'rowdown' : 'popup';

do_action('tradeace_before_show_buttons_loop'); // before loop btn
do_action('tradeace_show_buttons_loop', $combo_show_type); // loop btn
do_action('tradeace_after_show_buttons_loop'); // after loop btn
