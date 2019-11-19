<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package m-site
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main clear">

		<div id="recent-content" class="content-list">

			<div class="breadcrumbs clear">
				<h1>
					<span class="title">
						<?php 
							/* translators: %s: search term */
							printf( esc_html__( '"%s" 的搜索结果', 'm-site' ), '<span>' . get_search_query() . '</span>' ); 
						?>	
					</span>
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

				get_template_part( 'template-parts/content', 'list' );

				$i++;

				endwhile;

				else :

					get_template_part( 'template-parts/content', 'none' );

				?>

			<?php endif; ?>

		</div>

		</main><!-- .site-main -->

		<?php
			//if( $i > get_option( 'posts_per_page' ) ) {
				get_template_part( 'template-parts/pagination', '' ); 
			//} 
		?>

	</div><!-- #primary -->

<?php get_footer(); ?>

