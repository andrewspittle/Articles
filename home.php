<?php
/**
 * The homepage template file.
 *
 * This template file sets the layout for our homepage.
 * It filters out non-Standard post formats so that the homepage
 * is a showcase of article-length, text-oriented posts.
 *
 * @package Articles
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>
			
			<?php
				// Display our recent posts, showing excerpts, ignoring non-Standard post formats.
				$recent_args = array(
					'order' => 'DESC',
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'terms' => array(
								'post-format-quote',
								'post-format-aside',
								'post-format-link',
								'post-format-image',
								'post-format-gallery',
								'post-format-status'
							),
							'field' => 'slug',
							'operator' => 'NOT IN',
						),
					),
					'no_found_rows' => true,
					'paged' => get_query_var( 'paged' ),
				);
			
				// Our new query for the homepage.
				$recent = new WP_Query( $recent_args );
			
				// The first Recent post is displayed normally
				while ( $recent->have_posts() ) : $recent->the_post();
			?>

				<?php get_template_part( 'content', 'home' ); ?>

			<?php endwhile; ?>

			<?php articles_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>