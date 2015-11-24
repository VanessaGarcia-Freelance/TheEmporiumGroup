<?php
/**
 * Portfolio post title
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<header class="single-header clr">
	<h1 class="entry-title single-post-title">
    <?php echo "SOMETHING" . get_the_term_list( get_the_ID(), 'portfolio_category', "Category: " );  ?>
		<?php the_title(); ?>
	</h1><!-- .entry-title -->
</header><!-- .single-header -->