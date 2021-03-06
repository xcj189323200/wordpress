<?php
/*
 * Template Name: 所有最新文章
 *
 * The template for displaying all posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package zazhi-1
 */

get_header(); ?>

	<div id="primary" class="content-area clear">

		<div id="main" class="site-main clear">

			<div class="breadcrumbs clear">
				
				<h3>
					<?php
						esc_html_e('最新文章 ', 'zazhi-1');
					?>					
				</h3>

			</div><!-- .section-header -->

			<div id="recent-content" class="content-loop">

				<?php

					$temp = $wp_query;
					$wp_query= null;
					$wp_query = new WP_Query();
					$wp_query->query('paged='.$paged);

					if ( $wp_query->have_posts() ) :

					$i = 1;

					echo "<div class=\"posts-loop\">";

					while ($wp_query->have_posts()) : $wp_query->the_post();
					
						get_template_part('template-parts/content', 'loop');

						if ( $i == get_theme_mod('content-ad-position', '1')+1 ) {
							dynamic_sidebar( 'content-ad' );
						}
					
						$i++;

					endwhile;
					
					echo "</div><!-- .post-loop -->";

					if( $i > get_option( 'posts_per_page' ) ) :
						get_template_part( 'template-parts/pagination', '' ); 
					endif;

					else :

					get_template_part( 'template-parts/content', 'none' );

				?>

			<?php 
				endif;
			?>

			</div><!-- #recent-content -->
			
		</div><!-- #main -->

		<?php $wp_query = null; $wp_query = $temp;?>

	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
