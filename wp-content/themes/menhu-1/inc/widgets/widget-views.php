<?php
/**
 * Most Views Posts with Thumbnail widget.
 *
 * @package    menhu_1
 * @author     Zhutibaba
 * @copyright  Copyright (c) 2016, Zhutibaba
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 * @since      1.0.0
 */
class menhu_1_Views_Widget extends WP_Widget {

	/**
	 * Sets up the widgets.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		// Set up the widget options.
		$widget_options = array(
			'classname'   => 'widget-menhu-1-views widget_posts_thumbnail',
			'description' => __( '显示浏览次数最多的文章', 'menhu-1' )
		);

		// Create the widget.
		parent::__construct(
			'menhu_1-views',                                        // $this->id_base
			__( '&raquo; 浏览最多的文章', 'menhu-1' ), // $this->name
			$widget_options                                          // $this->widget_options
		);

	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 1.0.0
	 */
	function widget( $args, $instance ) {
		extract( $args );

		// Output the theme's $before_widget wrapper.
		echo $before_widget;

		// If the title not empty, display it.
		if ( $instance['title'] ) {
			echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;
		}

		// Posts query arguments.
		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => $instance['limit'],
			'orderby'        => 'meta_value_num',
			'meta_key'       => 'post_views_count',
			'post__not_in' => get_option( 'sticky_posts' )			
		);

		// globalize $wp_query
		global $wp_query;

		// process the query
		query_posts( $args );

		$i = 1;

		if ( have_posts() ) {
			echo '<ul>';

				while ( have_posts() ) : the_post();

					if($i < 2) {

					echo '<li class="clear">';
						if ( has_post_thumbnail() ) {

							echo '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . '<div class="thumbnail-wrap">';
								the_post_thumbnail('widget_thumb');  
							echo '</div>' . '</a>';
							
						} else {

							echo '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . '<div class="thumbnail-wrap">';
							echo '<img src="'. get_template_directory_uri() . '/thumb.php?src=' . catch_that_image() . '&w=300&h=150" alt="<?php the_title(); ?>"/>';
							echo '</div>' . '</a>';

						}

						echo '<div class="entry-wrap"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . esc_attr( wp_trim_words( get_the_title(), 30, '...' )) . '</a>'; 

					echo '</div></li>';

					} else {

						echo '<li class="post-list"><span>' . ($i - 1) . '</span>';
							echo '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . esc_attr( get_the_title() ) . '</a>'; 
						echo '</li>';

					}

					$i++;

				endwhile;

			echo '</ul>';
		}

		wp_reset_query();
		wp_reset_postdata();

		// Close the theme's widget wrapper.
		echo $after_widget;

	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 1.0.0
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $new_instance;
		$instance['title']     = strip_tags( $new_instance['title'] );
		$instance['limit']     = (int) $new_instance['limit'];

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 1.0.0
	 */
	function form( $instance ) {

		// Default value.
		$defaults = array(
			'title'     => esc_html__( '浏览最多的文章', 'menhu-1' ),
			'limit'     => 6
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( '标题', 'menhu-1' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>">
				<?php _e( '要显示的文章数', 'menhu-1' ); ?>
			</label>
			<input class="small-text" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="number" step="1" min="0" value="<?php echo (int)( $instance['limit'] ); ?>" />
		</p>

	<?php

	}

}
