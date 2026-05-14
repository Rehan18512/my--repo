<?php
/**
 * Cosmic Schema — JSON-LD helpers
 *
 * Each calculator plugin already emits its own SoftwareApplication + FAQPage
 * schema. This file ADDS:
 *   - BreadcrumbList for tool pages
 *   - WebSite + SearchAction for the home page
 *   - Organization for the site
 *
 * It NEVER touches or overrides the plugin's existing JSON-LD.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* WebSite + Organization on every page (header) */
add_action( 'wp_head', function () {
	if ( ! is_singular() && ! is_home() && ! is_front_page() ) return;

	$site_url  = home_url( '/' );
	$site_name = get_bloginfo( 'name' );

	$schema = array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'  => 'WebSite',
				'@id'    => $site_url . '#website',
				'url'    => $site_url,
				'name'   => $site_name,
				'potentialAction' => array(
					'@type'       => 'SearchAction',
					'target'      => $site_url . '?s={query}',
					'query-input' => 'required name=query',
				),
			),
			array(
				'@type'  => 'Organization',
				'@id'    => $site_url . '#organization',
				'name'   => $site_name,
				'url'    => $site_url,
				'logo'   => array( '@type' => 'ImageObject', 'url' => get_stylesheet_directory_uri() . '/assets/img/logo.png' ),
				'sameAs' => array(
					'https://www.instagram.com/cosmiccalculators',
					'https://www.tiktok.com/@cosmiccalculators',
				),
			),
		),
	);
	echo "\n<script id=\"cosmic-site-schema\" type=\"application/ld+json\">"
		. wp_json_encode( $schema, JSON_UNESCAPED_SLASHES )
		. "</script>\n";
}, 5 );

/* Breadcrumb schema for tool pages — emitted alongside the visible breadcrumb */
add_action( 'wp_head', function () {
	if ( ! is_singular() ) return;
	global $post;
	if ( ! $post ) return;

	$tool_shortcodes = array( 'love_calculator', 'love_calculator_pro', 'flames_calculator', 'flames_calculator_pro', 'crush_calculator', 'friendship_calculator', 'mulank_calculator', 'love_calculator_cosmic', 'flames_calculator_cosmic', 'crush_calculator_cosmic', 'friendship_calculator_cosmic', 'mulank_calculator_cosmic' );
	$is_tool = false;
	foreach ( $tool_shortcodes as $sc ) { if ( has_shortcode( $post->post_content, $sc ) ) { $is_tool = true; break; } }
	if ( ! $is_tool ) return;

	$crumbs = array(
		array( 'name' => 'Home',        'item' => home_url( '/' ) ),
		array( 'name' => 'Calculators', 'item' => home_url( '/calculators/' ) ),
		array( 'name' => get_the_title( $post ), 'item' => get_permalink( $post ) ),
	);
	$items = array();
	foreach ( $crumbs as $i => $c ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $i + 1,
			'name'     => $c['name'],
			'item'     => $c['item'],
		);
	}
	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	);
	echo "\n<script id=\"cosmic-breadcrumb-schema\" type=\"application/ld+json\">"
		. wp_json_encode( $schema, JSON_UNESCAPED_SLASHES )
		. "</script>\n";
}, 5 );
