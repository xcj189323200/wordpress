<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package zimeiti-1
 */

get_header(); ?>

	<div id="primary" class="content-area clear">

		<?php if( get_theme_mod('home-layout', 'choice-1') == 'choice-1' ) : ?>

			<?php get_template_part('sidebar', '2'); ?>

		<?php endif; ?>

		<div class="right-col">

			<main id="main" class="site-main clear">

			<div id="recent-content" class="content-search">

				<div class="breadcrumbs clear">
					<h1>
					<?php 
						/* translators: %s: search term */
						printf( esc_html__( '"%s" 的搜索结果', 'zimeiti-1' ), '<span>' . get_search_query() . '</span>' ); 
					?>	
					</h1>	
				</div><!-- .breadcrumbs -->
				<?php

				if ( have_posts() ) :	
				
				$i = 1;			
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */

					get_template_part( 'template-parts/content', 'search' );

					$i++;

					endwhile;

					else :

						get_template_part( 'template-parts/content', 'none' );

					?>

				<?php endif; ?>

			</div>

			</main><!-- .site-main -->

			<?php
				if( $i > get_option( 'posts_per_page' ) ) {
					get_template_part( 'template-parts/pagination', '' ); 
				} else {
			?>
				<style type="text/css">
					.content-search .hentry.last {
						border-bottom: none;
					}
				</style>
			<?php
				}
			?>

		</div><!-- .right-col -->

	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

