<?php
/**
 * The template for displaying posts in the homepage.
 *
 * @package Articles
 * @since Articles 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			if ( has_post_thumbnail() && ! is_single() ) { // check for a Post Thumbnail and a non-single template
				the_post_thumbnail( 'featured-thumbnail', array( 'class' => 'heroimage' ) );
			}
			elseif ( has_post_thumbnail() && is_single() ) { // check for a Post Thumbnail and a single template
				the_post_thumbnail( 'featured-single' );
			}
			?>
		
		<?php if ( !is_single() ) : ?>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'minimal_stream' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php else : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php endif; ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php articles_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-meta">
		<?php the_tags( '<div class="entry-tags">', ', ', '</div>' ); ?>
	
		<?php edit_post_link( __( 'Edit', 'articles' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->