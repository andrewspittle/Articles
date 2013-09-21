<?php
/**
 * The template for displaying link posts.
 *
 * @package Articles
 * @since Articles 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php articles_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-meta">
		<?php the_tags( '<div class="entry-tags">', ', ', '</div>' ); ?>
	
		<?php edit_post_link( __( 'Edit', 'articles' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
