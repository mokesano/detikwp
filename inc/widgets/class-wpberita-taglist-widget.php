<?php
/**
 * Widget API: WpBerita_TagList_Widget class
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @package WpBerita
 * @subpackage Widgets
 * @since 1.0.0
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Tag List widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class WpBerita_TagList_Widget extends WP_Widget {
	/**
	 * Sets up a Tag Lists widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'wpberita-taglist',
			'description' => __( 'Display Tags By Count.', 'wpberita' ),
		);
		parent::__construct( 'wpberita-taglist', __( 'Popular Tags Widget (WpBerita)', 'wpberita' ), $widget_ops );
	}

	/**
	 * Outputs the content for Tag Lists.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for Tag Lists.
	 */
	public function widget( $args, $instance ) {

		// Title.
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		// Base Id Widget.
		$wpb_widget_id = $this->id_base . '-' . $this->number;
		// Subtitle.
		$subtitle = ( ! empty( $instance['subtitle'] ) ) ? esc_html( $instance['subtitle'] ) : '';

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( $title ) {
			echo '<div class="page-header">';
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			if ( $subtitle ) {
				echo '<div class="widget-subtitle heading-text">' . $subtitle . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			echo '</div>';
		}
		// Minimal Number Post.
		$wpb_number_posts = ( ! empty( $instance['wpb_number_posts'] ) ) ? absint( $instance['wpb_number_posts'] ) : absint( 1 );
		// Minimal Tags.
		$wpb_number_tags = ( ! empty( $instance['wpb_number_tags'] ) ) ? absint( $instance['wpb_number_tags'] ) : absint( 5 );
		// Tag id.
		$wpb_idtag = ( ! empty( $instance['wpb_idtag'] ) ) ? array_map( 'absint', explode( ',', esc_attr( $instance['wpb_idtag'] ) ) ) : array( 0 );

		// Array for get_terms.
		$query_args = array(
			'orderby'      => 'count',
			'order'        => 'DESC',
			'hide_empty'   => true,
			'count'        => true,
			'hierarchical' => false,
		);

		if ( $wpb_number_tags ) {
			$query_args['number'] = $wpb_number_tags;
		}

		// if 'all tags' was selected ignore other selections of categories.
		if ( in_array( 0, $wpb_idtag, true ) ) {
			$wpb_idtag = array( 0 );
		}
		if ( ! in_array( 0, $wpb_idtag, true ) ) {
			$query_args['include'] = $wpb_idtag;
		}

		$tags = get_tags( $query_args );

		if ( ! is_wp_error( $tags ) && is_array( $tags ) && ! empty( $tags ) ) {
			echo '<ul class="wpberita-tag-lists">';
			foreach ( $tags as $tag ) {
				if ( $tag->count >= $wpb_number_posts ) {
					// Open item.
					echo '<li><a href="' . esc_url( get_term_link( (int) $tag->term_id ) ) . '" class="heading-text" title="' . esc_attr( $tag->name ) . '">';
					// Tag name.
					echo esc_attr( $tag->name );
					// Close item.
					echo '</a></li>';
				}
			}
			echo '</ul>';
		} else {
			echo '<div class="notags">' . esc_html__( 'No Tags', 'wpberita' ) . '</div>';
		}
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Handles updating settings for the current Mailchimp widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WpBerita_Mailchimp_form::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$new_instance = wp_parse_args(
			(array) $new_instance,
			array(
				'title'            => '',
				'subtitle'         => '',
				'wpb_number_posts' => 1,
				'wpb_number_tags'  => 5,
				'wpb_idtag'        => '',
			)
		);

		// Title.
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		// SubTitle.
		$instance['subtitle'] = sanitize_text_field( $new_instance['subtitle'] );
		// Number posts.
		$instance['wpb_number_posts'] = absint( $new_instance['wpb_number_posts'] );
		// Number tags.
		$instance['wpb_number_tags'] = absint( $new_instance['wpb_number_tags'] );
		// tag id.
		$instance['wpb_idtag'] = wp_strip_all_tags( $new_instance['wpb_idtag'] );

		return $instance;
	}

	/**
	 * Outputs the settings form for the Mailchimp widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'            => __( 'Popular Tags', 'wpberita' ),
				'subtitle'         => '',
				'wpb_number_posts' => 1,
				'wpb_number_tags'  => 5,
				'wpb_idtag'        => '',
			)
		);
		// Title.
		$title = sanitize_text_field( $instance['title'] );
		// SubTitle.
		$subtitle = sanitize_text_field( $instance['subtitle'] );
		// Number posts.
		$wpb_number_posts = absint( $instance['wpb_number_posts'] );
		// Number tags.
		$wpb_number_tags = absint( $instance['wpb_number_tags'] );
		// tag id.
		$wpb_idtag = wp_strip_all_tags( $instance['wpb_idtag'] );

		?>

		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wpberita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'subtitle' ) ); ?>"><?php esc_html_e( 'Description Title:', 'wpberita' ); ?></label>
			<textarea class="widefat" rows="3" id="<?php echo esc_html( $this->get_field_id( 'subtitle' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'subtitle' ) ); ?>"><?php echo esc_textarea( $instance['subtitle'] ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'wpb_number_posts' ) ); ?>"><?php esc_html_e( 'Minimal Posts:', 'wpberita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'wpb_number_posts' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'wpb_number_posts' ) ); ?>" type="number" value="<?php echo esc_attr( $wpb_number_posts ); ?>" />
			<br />
			<small><?php esc_html_e( 'Minimal Posts For Displaying Tags. For example you want display tag if the tag have 6 posts, you can insert 6. Default is 1', 'wpberita' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'wpb_number_tags' ) ); ?>"><?php esc_html_e( 'Number Tags:', 'wpberita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'wpb_number_tags' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'wpb_number_tags' ) ); ?>" type="number" value="<?php echo esc_attr( $wpb_number_tags ); ?>" />
			<br />
			<small><?php esc_html_e( 'Number tags to displaying in your widget. Default 5, for displaying all tags you can insert 0', 'wpberita' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'wpb_idtag' ) ); ?>"><?php esc_html_e( 'Tag ID:', 'wpberita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'wpb_idtag' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'wpb_idtag' ) ); ?>" type="text" value="<?php echo esc_attr( $wpb_idtag ); ?>" />
			<br />
			<small><?php esc_html_e( 'You can include exclusive tags, just insert ID Tags separate by commas(,). Example: 1,2,3,4. Leave blank if you want display by default tags', 'wpberita' ); ?></small>
		</p>
		<?php
	}

}

add_action(
	'widgets_init',
	function() {
		register_widget( 'WpBerita_TagList_Widget' );
	}
);
