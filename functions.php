<?php
/**
 * Gautam functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Gautam
 */

if ( ! function_exists( 'gautam_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function gautam_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Gautam, use a find and replace
		 * to change 'gautam' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'gautam', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'gautam' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'gautam_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'gautam_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gautam_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'gautam_content_width', 640 );
}

add_action( 'after_setup_theme', 'gautam_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function gautam_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'gautam' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'gautam' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'widgets_init', 'gautam_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function gautam_scripts() {
	wp_enqueue_style( 'gautam-style', get_stylesheet_uri() );

	wp_enqueue_script( 'gautam-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'gautam-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.6' );
	wp_enqueue_style( 'base', get_template_directory_uri() . '/css/base.css' );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.6', true );
	wp_enqueue_script( 'basejs', get_template_directory_uri() . '/js/base.js' );

}

add_action( 'wp_enqueue_scripts', 'gautam_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


// Add Google Fonts
function first_google_fonts() {
	wp_register_style( 'Coustard', '//fonts.googleapis.com/css?family=Coustard|Karla|Lora|Nunito+Sans:600' );
	wp_enqueue_style( 'Coustard' );
}

add_action( 'wp_print_styles', 'first_google_fonts' );


/**
 * Custom comments HTML output. It is used to display comments submitted for given post or page
 */
if ( ! function_exists( 'gautam_theme_comment' ) ) {
	function gautam_theme_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

//        $rating = intval(get_comment_meta($comment->comment_ID, 'rating', true));

		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				// Display trackbacks differently than normal comments.
				?>
                <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <p><?php esc_html_e( 'Pingback:', 'gautam' ); ?><?php comment_author_link(); ?><?php edit_comment_link( esc_html__( '(Edit)', 'gautam' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
			default :
				// Proceed with normal comments.
				global $post;
				?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <article id="comment-<?php comment_ID(); ?>" class="comment-body">
					<?php $avatar_html = get_avatar( $comment, 140 );
					if ( $avatar_html != '' ) {
						echo '<div class="commentAvatar">' . wp_kses_post( $avatar_html ) . '</div>';
					}
					?>
                    <div class="commentTxt">
						<?php if ( '0' == $comment->comment_approved ) : ?>
                            <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'gautam' ); ?></p>
						<?php endif; ?>

                        <div class="comment">

                            Yes
							<?php comment_text();

							if ( comments_open() ) {
								echo '<p class="reply test">';
								comment_reply_link( array_merge( $args, array(
									'reply_text' => esc_html__( 'Reply', 'gautam' ),
									'depth'      => $depth,
									'max_depth'  => $args['max_depth']
								) ) );
								echo '</p>';
							}
							edit_comment_link( esc_html__( 'Edit', 'gautam' ), '<p class="edit-link">', '</p>' ); ?>
                        </div>
                    </div>


                </article>
				<?php
				break;
		endswitch;
	}
}


/* Viveka : Added to customize the comment Fields. e.g. Name/URL/ email and Comment Box  */

function my_update_comment_fields( $fields ) {

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$label     = $req ? '*' : ' ' . __( '(optional)', 'gautam' );
	$aria_req  = $req ? "aria-required='true'" : '';

	$fields['author'] =
		'<p class="comment-form-author">
			<input id="author" name="author" type="text" placeholder="' . esc_attr__( "Viveka", "gautam" ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
		'" size="30" ' . $aria_req . ' />
		</p>';

	$fields['email'] =
		'<p class="comment-form-email">
			<input id="email" name="email" type="email" placeholder="' . esc_attr__( "name@email.com", "gautam" ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) .
		'" size="30" ' . $aria_req . ' />
		</p>';

	$fields['url'] =
		'<p class="comment-form-url">
			<input id="url" name="url" type="url"  placeholder="' . esc_attr__( "http://google32.com", "gautam" ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) .
		'" size="30" />
			</p>';

	return $fields;
}

add_filter( 'comment_form_default_fields', 'my_update_comment_fields' );


function my_update_comment_field( $comment_field ) {

	$comment_field =
		'<p class="comment-form-comment">
            <textarea required id="comment" name="comment" placeholder="' . esc_attr__( "Enter comment here...", "gautam" ) . '" cols="45" rows="8" aria-required="true"></textarea>
        </p>';

	return $comment_field;
}

add_filter( 'comment_form_field_comment', 'my_update_comment_field' );

//*******Theme Options Page  ****/////
if ( is_admin() ) {
	include_once 'admin/theme-options.php';
}


/*------ Favicon------ */
/* ============================================================================================================================================= */


function pixelwars_theme_favicons() {
	$favicon = get_option( 'favicon', "" );

	if ( $favicon != "" ) {
		?>

        <link rel="shortcut icon" href="<?php echo esc_url( $favicon ); ?>">

		<?php
	}

}

add_action( 'wp_head', 'pixelwars_theme_favicons' );

add_action( 'admin_head', 'pixelwars_theme_favicons' );

add_action( 'login_head', 'pixelwars_theme_favicons' );


/* ============================================================================================================================================= */


function pixelwars_theme_enqueue_admin() {
	wp_enqueue_style( 'admin', get_template_directory_uri() . '/admin/admin.css' );
	wp_enqueue_style( 'thickbox' );


	wp_enqueue_script( 'thickbox' );
	wp_enqueue_script( 'media-upload' );
}

add_action( 'admin_enqueue_scripts', 'pixelwars_theme_enqueue_admin' );


/* ============================================================================================================================================= */


function pixelwars_options_wp_head() {
	?>

    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/ie.js"></script>
    <![endif]-->

	<?php


	$custom_css = stripcslashes( get_option( 'custom_css', "" ) );

	if ( $custom_css != "" ) {
		echo '<style type="text/css">' . "\n";

		echo esc_url( $custom_css );

		echo "\n" . '</style>' . "\n";
	}


	$external_css = stripcslashes( get_option( 'external_css', "" ) );
	echo esc_url( $external_css );


	$tracking_code_head = stripcslashes( get_option( 'tracking_code_head', "" ) );
	echo esc_url( $tracking_code_head );
}

add_action( 'wp_head', 'pixelwars_options_wp_head' );


/* ============================================================================================================================================= */


function pixelwars_options_wp_footer() {
	$external_js = stripcslashes( get_option( 'external_js', "" ) );
	echo esc_url( $external_js );


	$tracking_code_body = stripcslashes( get_option( 'tracking_code_body', "" ) );
	echo esc_url( $tracking_code_body );
}

add_action( 'wp_footer', 'pixelwars_options_wp_footer' );


/*=====Adding boxed Layout class if user selected so============*/

add_filter( 'body_class', 'body_classes' );
function body_classes( $classes ) {

	$boxed_layout = get_option( 'boxed_layout', '' );
	if ( $boxed_layout != '' ) {
		$classes[] = 'boxed-layout';
	}

	$fixed_header = get_option( 'fixed_header', '' );
	if ( $fixed_header != '' ) {
		$classes[] = 'fixed-header';
	}

	$blog_sidebar = get_option( 'blog_sidebar', '' );
	if ( $blog_sidebar != '' ) {
		$classes[] = 'has-sidebar';
	}

	return $classes;
}