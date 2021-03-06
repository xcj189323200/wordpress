<?php		

	$sticky = get_option( 'sticky_posts' );

	$i = 1;

	if ( ( isset($sticky[0]) ) && (!get_query_var('paged')) ) {	

?>

<div id="featured-slider" class="clear">

	<ul class="bxslider">	

	<?php
		$custom_query_args = array( 
		    'post__in' => get_option( 'sticky_posts' ),
		    'posts_per_page' => get_theme_mod('featured-slide-num', '3'),
		    'ignore_sticky_posts' => 1
		);  

		global $wp_query;

		$merged_query_args = array_merge( $wp_query->query, $custom_query_args );

		query_posts( $merged_query_args );						
		// The Loop
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
	?>	

	<li class="featured-slide hentry">

		<a class="thumbnail-link" href="<?php the_permalink(); ?>">
			
			<div class="thumbnail-wrap">
				<?php 
					if ( has_post_thumbnail() ) {
						the_post_thumbnail('m_site_featured_large_thumb');  
					} else {	
				?>
					<img src="<?php echo get_template_directory_uri();?>/thumb.php?src=<?php echo catch_that_image(); ?>&w=750&h=375" alt="<?php the_title(); ?>"/>
				<?php
					}
				?>
			</div><!-- .thumbnail-wrap -->
			<div class="gradient"></div>				
		</a>		

		<div class="entry-header clear">			
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		</div><!-- .entry-header -->

	</li><!-- .featured-slide .hentry -->

	<?php
		$i++;
		endwhile;
		wp_reset_query();
		wp_reset_postdata();	
	?>

	</ul><!-- .bxslider -->
	
</div><!-- #featured-slider -->

<?php
	} //end if has featured posts			
?>