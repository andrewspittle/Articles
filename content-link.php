<?php
/**
 * The template for displaying link posts.
 *
 * @package Articles
 * @since Articles 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-date">
			<?php articles_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
		
		<?php the_tags( '<div class="entry-tags">', ', ', '</div>' ); ?>
	
		<?php edit_post_link( __( 'Edit', 'articles' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
