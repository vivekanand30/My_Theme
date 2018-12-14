<?php

function create_tabs( $current = 'general' ) {
	$tabs = array(
		'general' => 'General',
		'style'   => 'Style',
		'blog'    => 'Blog',
		'seo'     => 'SEO'
	);

	?>
    <h2 class="nav-tab-wrapper">
        <div id="icon-themes" class="icon32"></div>

        <div>
            <h1>Theme Options</h1>
        </div>

		<?php
		foreach ( $tabs as $tab => $name ) {
			$class = ( $tab == $current ) ? ' nav-tab-active' : "";

			echo "<a class='nav-tab$class' href='?page=theme-options&tab=$tab'>$name</a>";
		}
		?>
    </h2>
	<?php
}


/* ============================================================================================================================================ */


function theme_options_page() {
	global $pagenow;

	?>
    <div class="wrap wrap2">
        <div class="status">
            <img alt="..." src="<?php echo get_template_directory_uri(); ?>/admin/ajax-loader.gif">

            <strong></strong>
        </div>


        <script>
            jQuery(document).ready(function ($) {
                // -------------------------------------------------------------------------

                var uploadID = '',
                    uploadImg = '';

                jQuery('.upload-button').click(function () {
                    uploadID = jQuery(this).prev('input');
                    uploadImg = jQuery(this).next('img');
                    formfield = jQuery('.upload').attr('name');
                    tb_show("", 'media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true');
                    return false;
                });

                window.send_to_editor = function (html) {
                    imgurl = jQuery('img', html).attr('src');
                    uploadID.val(imgurl);
                    uploadImg.attr('src', imgurl);
                    tb_remove();
                }


                // -------------------------------------------------------------------------


                $(".alert-success p").click(function () {
                    $(this).fadeOut("slow", function () {
                        $(".alert-success").slideUp("slow");
                    });
                });


                // -------------------------------------------------------------------------


                $('.color').change(function () {
                    var myColor = $(this).val();

                    $(this).prev('div').find('div').css('backgroundColor', '#' + myColor);
                });


                $('.color').keypress(function () {
                    var myColor = $(this).val();

                    $(this).prev('div').find('div').css('backgroundColor', '#' + myColor);
                });


                // -------------------------------------------------------------------------


                $('form.ajax-form').submit(function () {
                    $.ajax(
                        {
                            data: $(this).serialize(),
                            type: "POST",
                            beforeSend: function () {
                                $('.status').removeClass('status-done');
                                $('.status img').show();
                                $('.status strong').html('Saving...');
                                $('.status').fadeIn();
                            },
                            success: function (data) {
                                $('.status img').hide();
                                $('.status').addClass('status-done');
                                $('.status strong').html('Done.');
                                $('.status').delay(1000).fadeOut();
                            }
                        });

                    return false;
                });


                // -------------------------------------------------------------------------
            });
        </script>


		<?php

		if ( isset( $_GET['tab'] ) ) {
			create_tabs( $_GET['tab'] );
		} else {
			create_tabs( 'general' );
		}

		?>


        <div id="poststuff">
			<?php

			// theme options page
			if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-options' ) {
				// tab from url
				if ( isset( $_GET['tab'] ) ) {
					$tab = $_GET['tab'];
				} else {
					$tab = 'general';
				}


				switch ( $tab ) {
					case 'general' :

						if ( esc_attr( @$_GET['saved'] ) == 'true' ) {
							echo '<div class="alert-success" title="Click to close"><p><strong>Saved.</strong></p></div>';
						}

						?>
                        <div class="postbox">
                            <div class="inside">
                                <form method="post" class="ajax-form"
                                      action="<?php admin_url( 'themes.php?page=theme-options' ); ?>">
									<?php
									wp_nonce_field( "settings-page" );
									?>

                                    <table>

                                        <tr>
                                            <td class="option-left">
                                                <h4>Image Logo</h4>

												<?php
												$logo_image = get_option( 'logo_image' );
												?>
                                                <input type="text" id="logo_image" name="logo_image"
                                                       class="upload code2" style="width: 100%;"
                                                       value="<?php echo esc_url( $logo_image ); ?>">

                                                <input type="button" class="button upload-button"
                                                       style="margin-top: 10px;" value="Browse">

                                                <img style="margin-top: 10px; max-height: 50px;" align="right"
                                                     src="<?php echo esc_url( $logo_image ); ?>">
                                            </td>

                                            <td class="option-right">
                                                Upload a logo or specify an image address of your online logo.
                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="option-left">
                                                <h4>Favicon</h4>

												<?php
												$favicon = get_option( 'favicon', "" );
												?>
                                                <input type="text" id="favicon" name="favicon" class="upload code2"
                                                       style="width: 100%;" value="<?php echo esc_url( $favicon ); ?>">

                                                <input type="button" class="button upload-button"
                                                       style="margin-top: 10px;" value="Browse">

                                                <img style="margin-top: 10px; max-height: 16px;" align="right"
                                                     src="<?php echo esc_url( $favicon ); ?>">
                                            </td>

                                            <td class="option-right">
                                                (16x16)px ICO, PNG or GIF format.
                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="option-left">
                                                <h4>Copyright Text</h4>

												<?php
												$copyright_text = stripcslashes( get_option( 'copyright_text', "" ) );
												?>
                                                <textarea id="copyright_text" name="copyright_text" rows="5"
                                                          cols="50"><?php echo esc_url( $copyright_text ); ?></textarea>
                                            </td>

                                            <td class="option-right">
                                                Copyright text in the footer.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="option-left">
                                                <input type="submit" name="submit"
                                                       class="button button-primary button-large" value="Save Changes">

                                                <input type="hidden" name="settings-submit" value="Y">
                                            </td>

                                            <td class="option-right">

                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <!-- end .inside -->
                        </div>
                        <!-- end .postbox -->
						<?php
						break;

					case 'style' :

						if ( esc_attr( @$_GET['saved'] ) == 'true' ) {
							echo '<div class="alert-success" title="Click to close"><p><strong>Saved.</strong></p></div>';
						}

						?>
                        <div class="postbox">
                            <div class="inside">
                                <form class="ajax-form" method="post"
                                      action="<?php admin_url( 'themes.php?page=theme-options' ); ?>">
									<?php
									wp_nonce_field( "settings-page" );
									?>

                                    <table>
                                        <tr>
                                            <td class="option-left">
                                                <h4>Fonts and Colors</h4>

												<?php
												echo '<a href="' . admin_url( 'customize.php' ) . '">Customize</a>';
												?>
                                            </td>

                                            <td class="option-right">
                                                Select from theme customizer.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="option-left">
                                                <h4>Fixed Header</h4>

												<?php
												$fixed_header = get_option( 'fixed_header', 'Yes' );
												?>
                                                <select id="fixed_header" name="fixed_header" style="width: 100%;">
                                                    <option <?php if ( $fixed_header == 'Yes' ) {
														echo 'selected="selected"';
													} ?>>Yes
                                                    </option>

                                                    <option <?php if ( $fixed_header == 'No' ) {
														echo 'selected="selected"';
													} ?>>No
                                                    </option>
                                                </select>
                                            </td>

                                            <td class="option-right">
                                                Enable/disable.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="option-left">
                                                <h4>Boxed Layout</h4>

												<?php
												$boxed_layout = get_option( 'boxed_layout', 'Yes' );
												?>
                                                <select id="boxed_layout" name="boxed_layout" style="width: 100%;">
                                                    <option <?php if ( $boxed_layout == 'Yes' ) {
														echo 'selected="selected"';
													} ?>>Yes
                                                    </option>

                                                    <option <?php if ( $boxed_layout == 'No' ) {
														echo 'selected="selected"';
													} ?>>No
                                                    </option>
                                                </select>
                                            </td>

                                            <td class="option-right">
                                                Enable/disable.
                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="option-left">
                                                <h4>Header Search</h4>

												<?php
												$nav_menu_search = get_option( 'nav_menu_search', 'No' );
												?>
                                                <select id="nav_menu_search" name="nav_menu_search"
                                                        style="width: 100%;">
                                                    <option <?php if ( $nav_menu_search == 'Yes' ) {
														echo 'selected="selected"';
													} ?>>Yes
                                                    </option>

                                                    <option <?php if ( $nav_menu_search == 'No' ) {
														echo 'selected="selected"';
													} ?>>No
                                                    </option>
                                                </select>
                                            </td>

                                            <td class="option-right">
                                                Show/hide.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="option-left">
                                                <h4>Footer Widget Locations</h4>

												<?php
												$footer_widget_locations = get_option( 'footer_widget_locations', 'No' );
												?>
                                                <select id="footer_widget_locations" name="footer_widget_locations"
                                                        style="width: 100%;">
                                                    <option <?php if ( $footer_widget_locations == 'Yes' ) {
														echo 'selected="selected"';
													} ?>>Yes
                                                    </option>

                                                    <option <?php if ( $footer_widget_locations == 'No' ) {
														echo 'selected="selected"';
													} ?>>No
                                                    </option>
                                                </select>
                                            </td>

                                            <td class="option-right">
                                                Enable/disable.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="option-left">
                                                <h4>Custom CSS</h4>

												<?php
												$custom_css = stripcslashes( get_option( 'custom_css', "" ) );
												?>
                                                <textarea id="custom_css" name="custom_css" class="code2" rows="8"
                                                          cols="50"><?php echo esc_url( $custom_css ); ?></textarea>
                                            </td>

                                            <td class="option-right">
                                                Quickly add custom css.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="option-left">
                                                <input type="submit" name="submit"
                                                       class="button button-primary button-large" value="Save Changes">

                                                <input type="hidden" name="settings-submit" value="Y">
                                            </td>

                                            <td class="option-right">

                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <!-- end .inside -->
                        </div>
                        <!-- end .postbox -->
						<?php

						break;

					case 'blog' :

						if ( esc_attr( @$_GET['saved'] ) == 'true' ) {
							echo '<div class="alert-success" title="Click to close"><p><strong>Saved.</strong></p></div>';
						}


						?>
                        <div class="postbox">
                            <div class="inside">
                                <form class="ajax-form" method="post"
                                      action="<?php admin_url( 'themes.php?page=theme-options' ); ?>">
									<?php
									wp_nonce_field( 'settings-page' );
									?>


                                    <table>
                                        <tr>
                                            <td class="option-left">
                                                <h4>Blog Type</h4>

												<?php
												$blog_type = get_option( 'blog_type', 'Regular' );
												?>

                                                <select id="blog_type" name="blog_type" style="width: 100%;">
                                                    <option <?php if ( $blog_type == 'Regular' ) {
														echo 'selected="selected"';
													} ?>>Regular
                                                    </option>

                                                    <option <?php if ( $blog_type == 'Simple' ) {
														echo 'selected="selected"';
													} ?>>Simple
                                                    </option>

                                                    <option <?php if ( $blog_type == 'Alternate' ) {
														echo 'selected="selected"';
													} ?>>Alternate
                                                    </option>

                                                    <option <?php if ( $blog_type == 'Masonry' ) {
														echo 'selected="selected"';
													} ?>>Masonry
                                                    </option>

                                                    <option <?php if ( $blog_type == 'Masonry Alternate' ) {
														echo 'selected="selected"';
													} ?>>Masonry Alternate
                                                    </option>
                                                </select>

                                                <h4>Search Result Type</h4>

												<?php
												$search_result_type = get_option( 'search_result_type', 'Regular' );
												?>

                                                <select id="search_result_type" name="search_result_type"
                                                        style="width: 100%;">
                                                    <option <?php if ( $search_result_type == 'Regular' ) {
														echo 'selected="selected"';
													} ?>>Regular
                                                    </option>

                                                    <option <?php if ( $search_result_type == 'Simple' ) {
														echo 'selected="selected"';
													} ?>>Simple
                                                    </option>

                                                    <option <?php if ( $search_result_type == 'Alternate' ) {
														echo 'selected="selected"';
													} ?>>Alternate
                                                    </option>

                                                    <option <?php if ( $search_result_type == 'Masonry' ) {
														echo 'selected="selected"';
													} ?>>Masonry
                                                    </option>

                                                    <option <?php if ( $search_result_type == 'Masonry Alternate' ) {
														echo 'selected="selected"';
													} ?>>Masonry Alternate
                                                    </option>
                                                </select>
                                            </td>
                                            <td class="option-right">
                                                Select layout type.
                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="option-left">
                                                <h4>Blog Sidebar</h4>

												<?php
												$blog_sidebar = get_option( 'blog_sidebar', 'Yes' );
												?>

                                                <select id="blog_sidebar" name="blog_sidebar" style="width: 100%;">
                                                    <option <?php if ( $blog_sidebar == 'Yes' ) {
														echo 'selected="selected"';
													} ?>>Yes
                                                    </option>

                                                    <option <?php if ( $blog_sidebar == 'No' ) {
														echo 'selected="selected"';
													} ?>>No
                                                    </option>
                                                </select>


                                                <h4>Post Sidebar</h4>

												<?php
												$post_sidebar = get_option( 'post_sidebar', 'Yes' );
												?>

                                                <select id="post_sidebar" name="post_sidebar" style="width: 100%;">
                                                    <option <?php if ( $post_sidebar == 'Yes' ) {
														echo 'selected="selected"';
													} ?>>Yes
                                                    </option>

                                                    <option <?php if ( $post_sidebar == 'No' ) {
														echo 'selected="selected"';
													} ?>>No
                                                    </option>
                                                </select>
                                            </td>

                                            <td class="option-right">
                                                Enable/disable.
                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="option-left">
                                                <h4>Automatic Excerpt</h4>
												<?php
												$theme_excerpt = get_option( 'theme_excerpt', 'No' );
												?>
                                                <select name="theme_excerpt">
                                                    <option <?php if ( $theme_excerpt == 'No' ) {
														echo 'selected="selected"';
													} ?>>No
                                                    </option>
                                                    <option <?php if ( $theme_excerpt == 'Yes' ) {
														echo 'selected="selected"';
													} ?> value="Yes">Yes
                                                    </option>
                                                </select>

                                                <h4>Excerpt Length</h4>
												<?php
												$pixelwars__excerpt_length = get_option( 'pixelwars__excerpt_length', '55' );
												?>
                                                <input type="number" min="5" max="100" step="5"
                                                       name="pixelwars__excerpt_length"
                                                       value="<?php echo esc_attr( $pixelwars__excerpt_length ); ?>">

                                                <span style="font-size: 11px; color: #666;">Default: 55 words</span>
                                            </td>
                                            <td class="option-right">
                                                Generates an excerpt from the post content.
                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="option-left">
                                                <h4>Post Featured Image (for Single)</h4>

												<?php
												$post_featured_image_style = get_option( 'post_featured_image_style', 'Full-width' );
												?>
                                                <select id="post_featured_image_style" name="post_featured_image_style"
                                                        style="width: 100%;">
                                                    <option <?php if ( $post_featured_image_style == 'Full-width' ) {
														echo 'selected="selected"';
													} ?>>Full-width
                                                    </option>

                                                    <option <?php if ( $post_featured_image_style == 'Fixed' ) {
														echo 'selected="selected"';
													} ?>>Fixed
                                                    </option>
                                                </select>
                                            </td>
                                            <td class="option-right">
                                                Select image style. This setting may be overridden for individual
                                                articles.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="option-left">
                                                <h4>About The Author Module</h4>
												<?php
												$about_the_author_module = get_option( 'about_the_author_module', 'Yes' );
												?>
                                                <select name="about_the_author_module" style="width: 100%;">
                                                    <option <?php if ( $about_the_author_module == 'Yes' ) {
														echo 'selected="selected"';
													} ?>>Yes
                                                    </option>
                                                    <option <?php if ( $about_the_author_module == 'No' ) {
														echo 'selected="selected"';
													} ?>>No
                                                    </option>
                                                </select>
                                            </td>
                                            <td class="option-right">
                                                Enable/disable.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="option-left">
                                                <h4>Share Links</h4>
												<?php
												$readme_share_links = get_option( 'readme_share_links', 'Yes' );
												?>
                                                <select name="readme_share_links" style="width: 100%;">
                                                    <option <?php if ( $readme_share_links == 'Yes' ) {
														echo 'selected="selected"';
													} ?>>Yes
                                                    </option>
                                                    <option <?php if ( $readme_share_links == 'No' ) {
														echo 'selected="selected"';
													} ?>>No
                                                    </option>
                                                </select>
                                            </td>
                                            <td class="option-right">
                                                Enable/disable.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="option-left">
                                                <input type="submit" name="submit"
                                                       class="button button-primary button-large" value="Save Changes">

                                                <input type="hidden" name="settings-submit" value="Y">
                                            </td>
                                            <td class="option-right">

                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
						<?php
						break;

					case 'seo' :

						if ( esc_attr( @$_GET['saved'] ) == 'true' ) {
							echo '<div class="alert-success" title="Click to close"><p><strong>Saved.</strong></p></div>';
						}

						?>
                        <div class="postbox">
                            <div class="inside">
                                <form class="ajax-form" method="post"
                                      action="<?php admin_url( 'themes.php?page=theme-options' ); ?>">
									<?php
									wp_nonce_field( "settings-page" );
									?>

                                    <table>

                                        <tr>
                                            <td class="option-left">
                                                <h4>Tracking Code (/head)</h4>

												<?php
												$tracking_code_head = stripcslashes( get_option( 'tracking_code_head' ) );
												?>
                                                <textarea id="tracking_code_head" name="tracking_code_head"
                                                          class="code2" rows="8"
                                                          cols="50"><?php echo esc_url( $tracking_code_head ); ?></textarea>
                                            </td>

                                            <td class="option-right">
                                                Paste your Google Analytics (or other) tracking code here. It will be
                                                inserted before the closing head tag.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="option-left">
                                                <h4> Code (/body)</h4>

												<?php
												$tracking_code_body = stripcslashes( get_option( 'tracking_code_body' ) );
												?>
                                                <textarea id="tracking_code_body" name="tracking_code_body"
                                                          class="code2" rows="8"
                                                          cols="50"><?php echo esc_url( $tracking_code_body ); ?></textarea>
                                            </td>

                                            <td class="option-right">
                                                Paste your Google Analytics (or other) tracking code here. It will be
                                                inserted before the closing body tag.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="option-left">
                                                <input type="submit" name="submit"
                                                       class="button button-primary button-large" value="Save Changes">

                                                <input type="hidden" name="settings-submit" value="Y">
                                            </td>

                                            <td class="option-right">

                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <!-- end .inside -->
                        </div>
                        <!-- end .postbox -->
						<?php
						break;
				}
				// end tab content
			}
			// end settings page
			?>
        </div>
        <!-- end #poststuff -->
    </div>
    <!-- end .wrap2 -->
	<?php
}

// end theme_options_page


/* ============================================================================================================================================ */


function theme_save_settings() {
	global $pagenow;

	if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-options' ) {
		if ( isset ( $_GET['tab'] ) ) {
			$tab = $_GET['tab'];
		} else {
			$tab = 'general';
		}


		switch ( $tab ) {
			case 'general' :

				update_option( 'logo_image', $_POST['logo_image'] );

				update_option( 'favicon', $_POST['favicon'] );

				update_option( 'copyright_text', $_POST['copyright_text'] );

				break;


			case 'style' :

				update_option( 'boxed_layout', $_POST['boxed_layout'] );
				update_option( 'fixed_header', $_POST['fixed_header'] );
				update_option( 'nav_menu_search', $_POST['nav_menu_search'] );
				update_option( 'footer_widget_locations', $_POST['footer_widget_locations'] );

				update_option( 'custom_css', $_POST['custom_css'] );

				break;


			case 'blog' :

				update_option( 'blog_type', $_POST['blog_type'] );
				update_option( 'search_result_type', $_POST['search_result_type'] );
				update_option( 'blog_sidebar', $_POST['blog_sidebar'] );
				update_option( 'post_sidebar', $_POST['post_sidebar'] );
				update_option( 'theme_excerpt', $_POST['theme_excerpt'] );
				update_option( 'pixelwars__excerpt_length', $_POST['pixelwars__excerpt_length'] );
				update_option( 'post_featured_image_style', $_POST['post_featured_image_style'] );
				update_option( 'about_the_author_module', $_POST['about_the_author_module'] );
				update_option( 'readme_share_links', $_POST['readme_share_links'] );

				break;


			case 'seo' :
				update_option( 'tracking_code_head', $_POST['tracking_code_head'] );
				update_option( 'tracking_code_body', $_POST['tracking_code_body'] );

				break;
		}
	}
}


/* ============================================================================================================================================ */


function load_settings_page() {
	if ( isset( $_POST["settings-submit"] ) == 'Y' ) {
		check_admin_referer( "settings-page" );

		theme_save_settings();

		$url_parameters = isset( $_GET['tab'] ) ? 'tab=' . $_GET['tab'] . '&saved=true' : 'saved=true';

		wp_redirect( admin_url( 'themes.php?page=theme-options&' . $url_parameters ) );

		exit;
	}
}


/* ============================================================================================================================================ */


function my_theme_menu() {
	$settings_page = add_theme_page( 'Theme Options',
		'Theme Options',
		'edit_theme_options',
		'theme-options',
		'theme_options_page' );

	add_action( "load-{$settings_page}", 'load_settings_page' );
}

add_action( 'admin_menu', 'my_theme_menu' );


/* ============================================================================================================================================ */


?>