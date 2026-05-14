<?php
/**
 * Site header — `header.php`
 *
 * Outputs <!DOCTYPE>, <html>, <head> (with WordPress wp_head hook) and
 * the opening <body> + the Cosmic-branded site header partial.
 *
 * Every page template that calls `get_header()` starts here.
 *
 * @package Cosmic_Calculators
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<meta name="theme-color" content="#07060d">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="cosmic-page" class="cosmic-site">

	<?php get_template_part( 'template-parts/cosmic-header' ); ?>

	<main id="cosmic-content" class="cosmic-site-content" tabindex="-1">
