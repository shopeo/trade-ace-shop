<?php
/**
 * The template for displaying the header
 *
 * @package tradeacetheme
 */
global $tradeace_opt;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if (function_exists('wp_site_icon')) : wp_site_icon(); ?>
<link rel="shortcut icon" href="<?php echo (isset($tradeace_opt['site_favicon']) && $tradeace_opt['site_favicon']) ? esc_attr($tradeace_opt['site_favicon']) : TRADEACE_THEME_URI . '/favicon.ico'; ?>" />
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
wp_body_open();
do_action('tradeace_theme_before_load');
?>

<!-- Start Wrapper Site -->
<div id="wrapper">

<!-- Start Header Site -->
<header id="header-content" class="site-header">
<?php do_action('tradeace_before_header_structure'); ?>
<?php do_action('tradeace_header_structure'); ?>
<?php do_action('tradeace_after_header_structure'); ?>
</header>
<!-- End Header Site -->

<!-- Start Main Content Site -->
<div id="main-content" class="site-main light">
