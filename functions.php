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
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'link' ) );

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
	add_image_size( 'media-feature-single', 1200, 9999, false ); //1200 pixels wide, unlimited height
	add_image_size( 'media-feature', 1200, 625, true ); //1200 pixels wide, 625 pixel tall

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
 * Filter images out of the_content
 * Since images are pulled separately for Image Format posts we'll remove them from the_content
 */
function articles_remove_images( $content ) {
	if ( 'image' == get_post_format() ) :
		return preg_replace( '/<img[^>]+./', '', $content );
	else :
		return $content;
	endif;
}
add_filter( 'the_content', 'articles_remove_images', 2 );
