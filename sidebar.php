<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Gautam
 */

if ( ! is_active_sidebar( 'sidebar-1' ) || get_option( 'blog_sidebar', 'No' ) == 'No' ) {
	return;
}
?>

<aside id="secondary" class="widget-area col-md-3">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
