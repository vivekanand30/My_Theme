<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Gautam
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('listpage'); ?>>


    <?php
    if ( has_post_thumbnail() ) :
    ?>
    <div class="col-md-5">
	<?php gautam_post_thumbnail(); ?>
    </div>
    <?php
			endif;?>

    <header class="entry-header <?php echo has_post_thumbnail() ? 'col-md-7' : '' ?>">
        <?php

        if ( 'post' === get_post_type() ) :
            ?>
            <div class="entry-meta">
                <?php
                gautam_posted_on();
                gautam_posted_by();
                ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
        <?php
        if ( is_singular() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;
 ?>
    </header><!-- .entry-header -->

	<div  class="entry-content <?php echo has_post_thumbnail() ? 'col-md-6' : '' ?>">
        <?php the_excerpt(); ?>
	</div>

	<footer class="entry-content <?php echo has_post_thumbnail() ? 'col-md-7' : '' ?>">
		<?php gautam_entry_footer(); ?>
	</footer>

    <!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
