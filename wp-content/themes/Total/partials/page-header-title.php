<?php
/**
 * Returns the post title
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get the title
$title = wpex_title();

// Return if there isn't a title
if ( ! $title ) {
	return;
}


// Alter the heading for single blog posts and product posts to a span
if ( ( is_singular( 'post' ) && 'custom_text' == wpex_get_mod( 'blog_single_header', 'custom_text' ) ) || is_singular( 'product' ) ) {
	$tag = 'span';
	$schema_markup = null;
}

// Return default tag and schema markup
else {
	$tag = 'h1';
	$schema_markup = wpex_get_schema_markup( 'headline' );
}

// Remove schema for other post types
if ( ! in_array( get_post_type(), wpex_theme_post_types() ) ) {
	$schema_markup = null;
}
$additionalClasses = '';
$portCat = get_the_terms( get_the_ID(), 'portfolio_category'); 
//echo print_r($portCat);
//echo $portCat[0]->name;
if(!empty($portCat)) {
    $additionalClasses = $portCat[0]->slug;
}

// Display title
echo '<'. $tag .' class="page-header-title '.$additionalClasses.'"'. $schema_markup .'>'. $title .'</'. $tag .'>';
