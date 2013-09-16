<?php
/**
 * @package Articles
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<section class="hero-image">
			<?php
				if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
				  the_post_thumbnail( 'featured-single' ); // use the custom image size we've set in functions.php
				}
			?>
		</section>
		
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php articles_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'articles' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php the_tags( '', ', ', '' ); ?>

		<?php edit_post_link( __( 'Edit', 'articles' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
