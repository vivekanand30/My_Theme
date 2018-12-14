<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Gautam
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
$boxed_layout = get_option( 'boxed_layout', "" )

?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'gautam' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="site-branding">
			<?php
			//			the_custom_logo();
			$logo_image = get_option( 'logo_image', "" );

			if ( $logo_image == '' ) :
				if ( is_front_page() && is_home() ) :
					?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                                              rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
				else :
					?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                                             rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif;

			else :
				?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( $logo_image ); ?>">
                </a>
			<?php
			endif;

			//            ?>
            <!--            <a href="--><?php //echo esc_url( home_url( '/' ) ); ?><!--" rel="home">-->
            <!--                <img alt="--><?php //bloginfo( 'name' ); ?><!--" src="-->
			<?php //echo esc_url($logo_image); ?><!--">-->
            <!--            </a>-->
            <!--            --><?php


			//			$gautam_description = get_bloginfo( 'description', 'display' );
			//			if ( $gautam_description || is_customize_preview() ) :
			//				?>
            <!--				<p class="site-description">-->
			<?php //echo $gautam_description; /* WPCS: xss ok. */ ?><!--</p>-->
            <!--			--><?php //endif; ?>

        </div><!-- .site-branding -->

        <nav id="site-navigation" class="main-navigation">
            <button class="menu-toggle" aria-controls="primary-menu"
                    aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'gautam' ); ?></button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
        </nav><!-- #site-navigation -->
    </header><!-- #masthead -->

    <div id="content" class="site-content">
