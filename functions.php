<?php
/**
 * Articles functions and definitions
 *
 * @package Articles
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 565; /* pixels */

if ( ! function_exists( 'articles_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function articles_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Articles, use a find and replace
	 * to change 'articles' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'articles', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	
	/**
	 * Add support for a variety of post formats
	 */
	add_theme_support( 'post-formats', array( 'link', 'image' ) );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	
	/**
	 * Register custom image sizes
	 */
	add_image_size( 'featured-single', 565, 9999 ); //565 pixels wide, unlimited height
	add_image_size( 'featured-thumbnail', 100, 100, true ); //100 pixels square
	add_image_size( 'image-format', 1200, 625, true ); //1200 pixels wide, 625 pixel tall
	add_image_size( 'image-format-single', 1200, 9999, false ); //1200 pixels wide, unlimited height

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'articles' ),
	) );
}
endif; // articles_setup
add_action( 'after_setup_theme', 'articles_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function articles_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'articles' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'articles_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function articles_scripts() {
	wp_enqueue_style( 'articles-style', get_stylesheet_uri() );

	wp_enqueue_script( 'articles-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'articles-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'articles-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'articles_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Remove URL field from the comment form
 */
add_filter( 'comment_form_default_fields', 'articles_remove_url' );

function articles_remove_url( $arg ) {
    $arg['url'] = '';
    return $arg;
}

/**
 * Hide non-standard post formats from the main loop
 * Feels hacky, probably a better way to do this...
 */
function exclude_non_standard_post_formats_from_loop( &$wp_query ) {
	
	// Do this for the home page
	if ( $wp_query->is_home() ) {
		
		// Array of post formats to exclude, by slug,
		// e.g. "post-format-{format}"
		$post_formats_to_exclude = array(
			'post-format-quote',
			'post-format-aside',
			'post-format-link',
			'post-format-image'
		);
		
		// Attach this to the $wp_query object:
		$extra_tax_query = array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => $post_formats_to_exclude,
			'operator' => 'NOT IN'
		);
		
		$tax_query = $wp_query->get( 'tax_query' );
		if ( is_array( $tax_query ) ) {
			$tax_query = $tax_query + $extra_tax_query;
		} else {
			$tax_query = array( $extra_tax_query );
		}
		$wp_query->set( 'tax_query', $tax_query );
	}
}

// Call our above action before each WP query
add_action( 'pre_get_posts', 'exclude_non_standard_post_formats_from_loop' );