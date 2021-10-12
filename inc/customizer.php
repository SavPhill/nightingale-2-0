<?php
/**
 * Nightingale Theme Customizer
 *
 * @package   Nightingale
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version   1.1 21st August 2019
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function nightingale_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'nightingale_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'nightingale_customize_partial_blogdescription',
			)
		);
	}

	/*
	 * ------------------------------------------------------------
	 * SECTION: Header
	 * ------------------------------------------------------------
	 */
	$wp_customize->add_section(
		'section_header',
		array(
			'title'       => esc_html__( 'Header', NHSUK_DOMAIN_NAME ),
			'description' => esc_attr__( 'Customise your header display', NHSUK_DOMAIN_NAME ),
			'priority'    => 10,
		)
	);

	/*
	 * -----------------------------------------------------------
	 * SHOW / HIDE Search
	 * -----------------------------------------------------------
	 */
	$wp_customize->add_setting(
		'show_search',
		array(
			'default'           => 'yes',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'show_search',
		array(
			'label'       => esc_html__( 'Show Search Box?', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'Would you like to show a search box in the top right of your site?', NHSUK_DOMAIN_NAME ),
			'section'     => 'section_header',
			'type'        => 'radio',
			'choices'     => array(
				'yes' => esc_html__( 'Yes', NHSUK_DOMAIN_NAME ),
				'no'  => esc_html__( 'No', NHSUK_DOMAIN_NAME ),
			),
		)
	);

	/*
	 * Header Styles
	 */
	$wp_customize->add_setting(
		'header_styles',
		array(
			'default'           => 'normal',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'header_styles',
		array(
			'label'       => esc_html__( 'Header Colour', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'What background would you like for your header region?', NHSUK_DOMAIN_NAME ),
			'section'     => 'section_header',
			'type'        => 'radio',
			'choices'     => array(
				'normal'   => esc_html__( 'Solid Blue', NHSUK_DOMAIN_NAME ),
				'inverted' => esc_html__( 'White Logo Bar', NHSUK_DOMAIN_NAME ),
			),
		)
	);

	/*
	 * Show Organisation Name?
	 */
	$wp_customize->add_setting(
		'org_name_checkbox',
		array(
			'default'           => 'no',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'org_name_checkbox',
		array(
			'label'       => esc_html__( 'Do you wish to add an organisation name to the logo and copyright?', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'This is used if your oganisation name should be different from the site title. It is also picked up for the copyright statement in your footer', NHSUK_DOMAIN_NAME ),
			'section'     => 'title_tagline',
			'type'        => 'radio',
			'choices'     => array(
				'yes' => esc_html__( 'Yes', NHSUK_DOMAIN_NAME ),
				'no'  => esc_html__( 'No', NHSUK_DOMAIN_NAME ),
			),
		)
	);

	$wp_customize->add_setting(
		'org_name_field',
		array(
			'sanitize_callback' => 'nightingale_sanitize_nohtml',
		)
	);

	$wp_customize->add_control(
		'org_name_field',
		array(
			'label'           => esc_html__( 'Enter Organisation name', NHSUK_DOMAIN_NAME ),
			'section'         => 'title_tagline',
			'type'            => 'text',
			'active_callback' => function () use ( $wp_customize ) {
				return 'yes' === $wp_customize->get_setting( 'org_name_checkbox' )->value();
			},
		)
	);

	/*
	 * Show NHS Logo?
	 */
	$wp_customize->add_setting(
		'nhs_logo',
		array(
			'default'           => 'no',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'nhs_logo',
		array(
			'label'       => esc_html__( 'Do you wish to use the NHS logo?', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'this setting is ignored if you have uploaded a custom logo above. Please note the NHS logo is a trademark and should only be used by organisations that have permission to use it as part of their branding.', NHSUK_DOMAIN_NAME ),
			'section'     => 'title_tagline',
			'type'        => 'radio',
			'choices'     => array(
				'yes' => esc_html__( 'Yes', NHSUK_DOMAIN_NAME ),
				'no'  => esc_html__( 'No', NHSUK_DOMAIN_NAME ),
			),
		)
	);

	/*
	 * -----------------------------------------------------------
	 * LOGO Generation
	 * -----------------------------------------------------------
	 */
	$wp_customize->add_setting(
		'logo_type',
		array(
			'default'           => 'transactional',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'logo_type',
		array(
			'label'       => esc_html__( 'Logo Builder', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'You can create your own site logo. It is strongly recommened to use the NHS logo if you are able to. This only takes effect if you have not uploaded a site logo. Both options are accepted NHS design patterns.', NHSUK_DOMAIN_NAME ),
			'section'     => 'title_tagline',
			'type'        => 'radio',
			'choices'     => array(
				'transactional' => esc_html__( 'Inline (shows just site name to the right of logo)', NHSUK_DOMAIN_NAME ),
				'organisation'  => esc_html__( 'Block (shows both site name and tagline beneath logo)', NHSUK_DOMAIN_NAME ),
			),
		)
	);

	/*
	 * -----------------------------------------------------------
	 * Colour chooser
	 * -----------------------------------------------------------
	 */
	$wp_customize->add_setting(
		'theme_colour',
		array(
			'default'           => 'nhs_blue',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'theme_colour',
		array(
			'label'       => esc_html__( 'Theme Colour', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'If you wish to change the default colour of the theme, this is where you do it. Please note, this will disable the inline critical-css and may have a slight performance impact on your visible loadtimes. It may also affect the accessability of your site.', NHSUK_DOMAIN_NAME ),
			'section'     => 'colors',
			'type'        => 'select',
			'choices'     => nightingale_get_theme_colours(),
		)
	);

	/*
	 * ------------------------------------------------------------
	 * SECTION: Layout
	 * ------------------------------------------------------------
	 */
	$wp_customize->add_section(
		'section_layout',
		array(
			'title'       => esc_html__( 'Layout', NHSUK_DOMAIN_NAME ),
			'description' => esc_attr__( 'Customise your site layout', NHSUK_DOMAIN_NAME ),
			'priority'    => 30,
		)
	);

	/*
	 * Show Sidebar left or right?
	 */
	$wp_customize->add_setting(
		'sidebar_location',
		array(
			'default'           => 'right',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'sidebar_location',
		array(
			'label'       => esc_html__( 'Where would you like the sidebar to appear?', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'Standard layout puts the sidebar to the right. You can change this here. WARNING: if your sidebar is empty, but you have sidebar set to left, your content will be floating a third of the way across the page, which could look weird!', NHSUK_DOMAIN_NAME ),
			'section'     => 'section_layout',
			'priority'    => '100',
			'type'        => 'radio',
			'choices'     => array(
				'right' => esc_html__( 'Right', NHSUK_DOMAIN_NAME ),
				'left'  => esc_html__( 'Left', NHSUK_DOMAIN_NAME ),
			),
		)
	);

	/*
	 * Display Featured image on post / page?
	 */
	$wp_customize->add_setting(
		'featured_img_display',
		array(
			'default'           => 'true',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'featured_img_display',
		array(
			'label'       => esc_html__( 'Display Featured Image on posts / pages single view', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'Featured images are really useful for search results and listing pages. Sometimes its handy to have them for this, but you don\'t want the image to show on the individual page. If thats the case, turn them off here.', NHSUK_DOMAIN_NAME ),
			'section'     => 'section_layout',
			'priority'    => '100',
			'type'        => 'radio',
			'choices'     => array(
				'true'  => esc_html__( 'Yes', NHSUK_DOMAIN_NAME ),
				'false' => esc_html__( 'No', NHSUK_DOMAIN_NAME ),
			),
		)
	);

	$wp_customize->add_setting(
		// $id
		'blog_fimage_display',
		// $args
		array(
			'default'           => 'top',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		// $id
		'blog_fimage_display',
		// $args
		array(
			'settings'    => 'blog_fimage_display',
			'section'     => 'section_layout',
			'priority'    => '110',
			'type'        => 'radio',
			'label'       => esc_html__( 'Featured images display', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'Show Featured Image at top of individual posts, or to the side. (If Display Featured Image above is set to no, this setting is ignored)', NHSUK_DOMAIN_NAME ),
			'choices'     => array(
				'top'   => esc_html__( 'Top of post', NHSUK_DOMAIN_NAME ),
				'left'  => esc_html__( 'Floated left', NHSUK_DOMAIN_NAME ),
				'right' => esc_html__( 'Floated right', NHSUK_DOMAIN_NAME ),
			),
		)
	);

	/*
	 * Display sitemap on 404 page?
	 */
	$wp_customize->add_setting(
		'blog_404sitemap_display',
		array(
			'default'           => 'true',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		// $id
		'blog_404sitemap_display',
		// $args
		array(
			'settings'    => 'blog_404sitemap_display',
			'section'     => 'section_layout',
			'priority'    => '120',
			'type'        => 'radio',
			'label'       => esc_html__( 'Show sitemap on 404 page?', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'Choose whether or not to show the WordPress sitemap on 404 pages.', NHSUK_DOMAIN_NAME ),
			'choices'     => array(
				'true'  => esc_html__( 'Yes', NHSUK_DOMAIN_NAME ),
				'false' => esc_html__( 'No', NHSUK_DOMAIN_NAME ),
			),
		)
	);
}

add_action( 'customize_register', 'nightingale_customize_register' );

/**
 * Settings to customise blog pages.
 *
 * @param array $wp_customize all the saved settings for the theme customiser.
 */
function nightingale_add_blog_settings( $wp_customize ) {

	$wp_customize->add_section(
		'blog_panel',
		array(
			'title'          => esc_html__( 'Blog Settings', NHSUK_DOMAIN_NAME ),
			'description'    => esc_html__( 'Extra settings for the Blog page', NHSUK_DOMAIN_NAME ),
			'capability'     => 'edit_theme_options',
			'theme-supports' => '',
			'priority'       => '150',
		)
	);

	$wp_customize->add_setting(
		// $id
		'blog_sidebar',
		// $args
		array(
			'default'           => 'true',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		// $id
		'blog_sidebar',
		// $args
		array(
			'settings'    => 'blog_sidebar',
			'section'     => 'blog_panel',
			'type'        => 'radio',
			'label'       => esc_html__( 'Display Sidebar', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'Choose whether or not to display the sidebar on the blog page', NHSUK_DOMAIN_NAME ),
			'choices'     => array(
				'true'  => esc_html__( 'Sidebar', NHSUK_DOMAIN_NAME ),
				'false' => esc_html__( 'No Sidebar', NHSUK_DOMAIN_NAME ),
			),
		)
	);

	$wp_customize->add_setting(
		// $id
		'blog_author_display',
		// $args
		array(
			'default'           => 'true',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		// $id
		'blog_author_display',
		// $args
		array(
			'settings'    => 'blog_author_display',
			'section'     => 'blog_panel',
			'type'        => 'radio',
			'label'       => esc_html__( 'Show Author Name on Blog Posts?', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'Choose whether or not to display the authors name (and link) on the blog page', NHSUK_DOMAIN_NAME ),
			'choices'     => array(
				'true'  => esc_html__( 'Show author', NHSUK_DOMAIN_NAME ),
				'false' => esc_html__( 'Dont show author', NHSUK_DOMAIN_NAME ),
			),
		)
	);

	$wp_customize->add_setting(
		// $id
		'blog_date_display',
		// $args
		array(
			'default'           => 'true',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		// $id
		'blog_date_display',
		// $args
		array(
			'settings'    => 'blog_date_display',
			'section'     => 'blog_panel',
			'type'        => 'radio',
			'label'       => esc_html__( 'Show Post Date on Blog Posts?', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'Choose whether or not to display the date a post was made on the blog page', NHSUK_DOMAIN_NAME ),
			'choices'     => array(
				'true'  => esc_html__( 'Show date', NHSUK_DOMAIN_NAME ),
				'false' => esc_html__( 'Dont show date', NHSUK_DOMAIN_NAME ),
			),
		)
	);

	$wp_customize->add_setting(
		// $id
		'blog_image_display',
		// $args
		array(
			'default'           => 'default',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		// $id
		'blog_image_display',
		// $args
		array(
			'settings'    => 'blog_image_display',
			'section'     => 'blog_panel',
			'type'        => 'radio',
			'label'       => esc_html__( 'Images on Blog Listing ', NHSUK_DOMAIN_NAME ),
			'description' => esc_html__( 'Choose whether to display images on blog listing page as square or default (square will ensure all blocks are consistently laid out)', NHSUK_DOMAIN_NAME ),
			'choices'     => array(
				'default'               => esc_html__( 'Leave as default proportions', NHSUK_DOMAIN_NAME ),
				'nightingale-square-md' => esc_html__( 'Show as square (images may be cropped)', NHSUK_DOMAIN_NAME ),
			),
		)
	);

	$wp_customize->add_setting(
		// $id
		'blog_fallback',
		// $args
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'nightingale_sanitize_image',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'blog_fallback',
			array(
				'settings'    => 'blog_fallback',
				'mime_type'   => 'image',
				'section'     => 'blog_panel',
				'label'       => esc_html__( 'Blog Fallback Image', NHSUK_DOMAIN_NAME ),
				'description' => esc_html__( 'Select a fallback image if the blog post does not have a featured image. Leave blank if no fallback wanted', NHSUK_DOMAIN_NAME ),
			)
		)
	);
}

add_action( 'customize_register', 'nightingale_add_blog_settings' );


/**
 * Clean the date output up.
 *
 * @param datetime $input raw date.
 *
 * @return string.
 */
function nightingale_sanitize_date( $input ) {
	$date = new DateTime( $input );

	return $date->format( 'd-m-Y' );
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function nightingale_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function nightingale_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function nightingale_customize_preview_js() {
	wp_enqueue_script(
		'nightingale-customizer',
		get_template_directory_uri() . '/js/customizer.js',
		array(
			'jquery',
			'customize-preview',
		),
		'20151215',
		true
	);
}

add_action( 'customize_preview_init', 'nightingale_customize_preview_js' );
