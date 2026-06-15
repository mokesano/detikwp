<?php
/**
 * Widget API: WpBerita_RecentPosts_Widget class
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
 * Add the RPSL widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class WpBerita_RecentPosts_Widget extends WP_Widget {
	/**
	 * Sets up a Recent Posts widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'wpberita-recent',
			'description' => __( 'Recent Posts With Thumbnail.', 'wpberita' ),
		);
		parent::__construct( 'wpberita-rp', __( 'Recent Posts (WpBerita)', 'wpberita' ), $widget_ops );
	}

	/**
	 * Outputs the content for Recent Posts.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for Recent Posts.
	 */
	public function widget( $args, $instance ) {

		global $post;

		// Title.
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		// URL.
		$link_title = ( ! empty( $instance['link_title'] ) ) ? esc_url( $instance['link_title'] ) : '';
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
		// Category ID.
		$wpb_category_ids = ( ! empty( $instance['wpb_category_ids'] ) ) ? array_map( 'absint', $instance['wpb_category_ids'] ) : array( 0 );
		// Excerpt Length.
		$wpb_number_posts = ( ! empty( $instance['wpb_number_posts'] ) ) ? absint( $instance['wpb_number_posts'] ) : absint( 6 );
		// Style.
		$wpb_style = ( ! empty( $instance['wpb_style'] ) ) ? wp_strip_all_tags( $instance['wpb_style'] ) : wp_strip_all_tags( 'style_1' );
		// Tag id.
		$wpb_idtag = ( ! empty( $instance['wpb_idtag'] ) ) ? array_map( 'absint', explode( ',', esc_attr( $instance['wpb_idtag'] ) ) ) : array( 0 );

		// if 'all categories' was selected ignore other selections of categories.
		if ( in_array( 0, $wpb_category_ids, true ) ) {
			$wpb_category_ids = array( 0 );
		}

		// if 'all tags' was selected ignore other selections of categories.
		if ( in_array( 0, $wpb_idtag, true ) ) {
			$wpb_idtag = array( 0 );
		}

		// standard params.
		$query_args = array(
			'posts_per_page'         => $wpb_number_posts,
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			// make it fast withour update term cache and cache results.
			// https://thomasgriffin.io/optimize-worspless-queries/.
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		);

		$query_args['ignore_sticky_posts'] = true;

		// set order of posts in widget.
		$query_args['orderby'] = 'date';
		$query_args['order']   = 'DESC';

		// add categories param only if 'all categories' was not selected.
		if ( ! in_array( 0, $wpb_category_ids, true ) ) {
			$query_args['category__in'] = $wpb_category_ids;
		}

		// Add tag option.
		if ( ! in_array( 0, $wpb_idtag, true ) ) {
			$query_args['tag__in'] = $wpb_idtag;
		}

		// run the query: get the latest posts.
		$rp = new WP_Query( apply_filters( 'wpb_rp_widget_posts_args', $query_args ) );
		if ( $rp->have_posts() ) {
			if ( 'style_3' === $wpb_style ) {
				?>
				<div class="wpberita-list-gallery">
					<?php
					while ( $rp->have_posts() ) :
						$rp->the_post();
						?>
						<div class="list-gallery">
							<?php
							if ( has_post_thumbnail() ) {
								?>
								<a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true" tabindex="-1">
									<?php
										the_post_thumbnail(
											'medium-new',
											array(
												'alt' => the_title_attribute(
													array(
														'echo' => false,
													)
												),
											)
										);
									if ( has_post_format( 'video' ) ) {
										echo '<span class="gmr-format gmr-format-video"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="#fff" width="1.17em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" height="1em"><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"></path></svg><svg class="u-hide" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1200 1200"><path d="M600 1200C268.65 1200 0 931.35 0 600S268.65 0 600 0s600 268.65 600 600s-268.65 600-600 600zM450 300.45v599.1L900 600L450 300.45z" fill="#626262"/><rect x="0" y="0" width="1200" height="1200" fill="rgba(0, 0, 0, 0)" /></svg></span>';

									} elseif ( has_post_format( 'gallery' ) ) {
										echo '<span class="gmr-format gmr-format-gallery"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="#626262"/><rect x="0" y="0" width="1024" height="1024" fill="rgba(0, 0, 0, 0)" /></svg></span>';
									}
									?>
								</a>
								<?php
							}
							?>
							<div class="list-gallery-title">
								<?php the_title( '<a class="recent-title heading-text" href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '" rel="bookmark">', '</a>' ); ?>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
					?>

				</div>
				<?php
			} else {
				?>
				<ul class="<?php echo ( 'style_2' === $wpb_style || 'style_4' === $wpb_style ) ? 'wpberita-list-widget' : 'wpberita-rp-widget'; ?>">
					<?php
					$count = 0;
					while ( $rp->have_posts() ) :
						$rp->the_post();
						$count++;
						?>
						<li>
							<?php
							$class = '';
							if ( 'style_2' !== $wpb_style && 'style_4' !== $wpb_style ) {
								if ( has_post_thumbnail() ) {
									?>
									<a class="post-thumbnail pull-left" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true" tabindex="-1">
										<?php
											the_post_thumbnail(
												'thumbnail',
												array(
													'alt' => the_title_attribute(
														array(
															'echo' => false,
														)
													),
												)
											);
										if ( has_post_format( 'video' ) ) {
											echo '<span class="gmr-format gmr-format-video"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="#fff" width="1.17em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" height="1em"><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"></path></svg><svg class="u-hide" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1200 1200"><path d="M600 1200C268.65 1200 0 931.35 0 600S268.65 0 600 0s600 268.65 600 600s-268.65 600-600 600zM450 300.45v599.1L900 600L450 300.45z" fill="#626262"/><rect x="0" y="0" width="1200" height="1200" fill="rgba(0, 0, 0, 0)" /></svg></span>';

										} elseif ( has_post_format( 'gallery' ) ) {
											echo '<span class="gmr-format gmr-format-gallery"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="#626262"/><rect x="0" y="0" width="1024" height="1024" fill="rgba(0, 0, 0, 0)" /></svg></span>';
										}
										?>
									</a>
									<?php
								}
								if ( has_post_thumbnail() ) {
									$class = ' has-thumbnail';
								} else {
									$class = ' no-thumbnail';
								}
							}
							if ( 'style_4' === $wpb_style ) {
								echo '<div class="rp-number pull-left heading-text">#' . absint( $count ) . '</div>';
							}
							if ( 'style_2' !== $wpb_style ) {
								if ( 'style_4' === $wpb_style ) {
									$classrc = 'numberstyle';
								} else {
									$classrc = $class;
								}
								?>
							<div class="recent-content <?php echo esc_html( $classrc ); ?>">
								<?php
							}
								the_title( '<a class="recent-title heading-text" href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '" rel="bookmark">', '</a>' );
								echo '<div class="clearfix meta-content">';
									wpberita_posted_on();
								echo '</div>';
							if ( 'style_2' !== $wpb_style ) {
								?>
							</div>
								<?php
							}
							?>
						</li>
						<?php

					endwhile;
					wp_reset_postdata();
					?>
				</ul>
				<?php
			}
		}
		if ( ! empty( $link_title ) ) {
			echo '<div class="module-linktitle text-center">';
			echo '<a class="heading-text" href="' . esc_url( $link_title ) . '" title="' . esc_html__( 'View More', 'wpberita' ) . '">' . esc_html__( 'View More', 'wpberita' ) . ' <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="18" height="18" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><g fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.293 3.293a1 1 0 0 1 1.414 0l6 6a1 1 0 0 1 0 1.414l-6 6a1 1 0 0 1-1.414-1.414L14.586 11H3a1 1 0 1 1 0-2h11.586l-4.293-4.293a1 1 0 0 1 0-1.414z" fill="#888888"/></g><rect x="0" y="0" width="20" height="20" fill="rgba(0, 0, 0, 0)" /></svg></a>';
			echo '</div>';
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
				'link_title'       => '',
				'subtitle'         => '',
				'wpb_category_ids' => array( 0 ),
				'wpb_number_posts' => 6,
				'wpb_style'        => 'style_1',
				'wpb_idtag'        => '',
			)
		);

		// Title.
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		// Link Title.
		$instance['link_title'] = esc_url( $new_instance['link_title'] );
		// SubTitle.
		$instance['subtitle'] = sanitize_text_field( $new_instance['subtitle'] );
		// Category IDs.
		$instance['wpb_category_ids'] = array_map( 'absint', $new_instance['wpb_category_ids'] );
		// Number posts.
		$instance['wpb_number_posts'] = absint( $new_instance['wpb_number_posts'] );
		// Style.
		$instance['wpb_style'] = wp_strip_all_tags( $new_instance['wpb_style'] );
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
				'title'            => 'Recent Post',
				'link_title'       => '',
				'subtitle'         => '',
				'wpb_category_ids' => array( 0 ),
				'wpb_number_posts' => 6,
				'wpb_style'        => 'style_1',
				'wpb_idtag'        => '',
			)
		);
		// Title.
		$title = sanitize_text_field( $instance['title'] );
		// Link Title.
		$link_title = esc_url( $instance['link_title'] );
		// SubTitle.
		$subtitle = sanitize_text_field( $instance['subtitle'] );
		// Category ID.
		$wpb_category_ids = array_map( 'absint', $instance['wpb_category_ids'] );
		// Number posts.
		$wpb_number_posts = absint( $instance['wpb_number_posts'] );
		// Style.
		$wpb_style = wp_strip_all_tags( $instance['wpb_style'] );
		// tag id.
		$wpb_idtag = wp_strip_all_tags( $instance['wpb_idtag'] );

		// get categories.
		$categories     = get_categories(
			array(
				'hide_empty'   => 0,
				'hierarchical' => 1,
			)
		);
		$number_of_cats = count( $categories );

		// get size (number of rows to display) of selection box: not more than 10.
		$number_of_rows = ( 10 > $number_of_cats ) ? $number_of_cats + 1 : 10;

		// if 'all categories' was selected ignore other selections of categories.
		if ( in_array( 0, $wpb_category_ids, true ) ) {
			$wpb_category_ids = array( 0 );
		}

		// start selection box.
		$selection_category  = sprintf(
			'<select name="%s[]" id="%s" class="cat-select widefat" multiple size="%d">',
			$this->get_field_name( 'wpb_category_ids' ),
			$this->get_field_id( 'wpb_category_ids' ),
			$number_of_rows
		);
		$selection_category .= "\n";

		// make selection box entries.
		$cat_list = array();
		if ( 0 < $number_of_cats ) {

			// make a hierarchical list of categories.
			while ( $categories ) {
				// go on with the first element in the categories list:.
				// if there is no parent.
				if ( '0' == $categories[0]->parent ) {
					// get and remove it from the categories list.
					$current_entry = array_shift( $categories );
					// append the current entry to the new list.
					$cat_list[] = array(
						'id'    => absint( $current_entry->term_id ),
						'name'  => esc_html( $current_entry->name ),
						'depth' => 0,
					);
					// go on looping.
					continue;
				}
				// if there is a parent:
				// try to find parent in new list and get its array index.
				$parent_index = $this->get_cat_parent_index( $cat_list, $categories[0]->parent );
				// if parent is not yet in the new list: try to find the parent later in the loop.
				if ( false === $parent_index ) {
					// get and remove current entry from the categories list.
					$current_entry = array_shift( $categories );
					// append it at the end of the categories list.
					$categories[] = $current_entry;
					// go on looping.
					continue;
				}
				// if there is a parent and parent is in new list:
				// set depth of current item: +1 of parent's depth.
				$depth = $cat_list[ $parent_index ]['depth'] + 1;
				// set new index as next to parent index.
				$new_index = $parent_index + 1;
				// find the correct index where to insert the current item.
				foreach ( $cat_list as $entry ) {
					// if there are items with same or higher depth than current item.
					if ( $depth <= $entry['depth'] ) {
						// increase new index.
						$new_index++;
						// go on looping in foreach().
						continue;
					}
					// if the correct index is found:
					// get current entry and remove it from the categories list.
					$current_entry = array_shift( $categories );
					// insert current item into the new list at correct index.
					$end_array  = array_splice( $cat_list, $new_index ); // $cat_list is changed, too.
					$cat_list[] = array(
						'id'    => absint( $current_entry->term_id ),
						'name'  => esc_html( $current_entry->name ),
						'depth' => $depth,
					);
					$cat_list   = array_merge( $cat_list, $end_array );
					// quit foreach(), go on while-looping.
					break;
				}
			}

			// make HTML of selection box.
			$selected            = ( in_array( 0, $wpb_category_ids, true ) ) ? ' selected="selected"' : '';
			$selection_category .= "\t";
			$selection_category .= '<option value="0"' . $selected . '>' . __( 'All Categories', 'wpberita' ) . '</option>';
			$selection_category .= "\n";

			foreach ( $cat_list as $category ) {
				$cat_name            = apply_filters( 'wpb_list_cats', $category['name'], $category );
				$pad                 = ( 0 < $category['depth'] ) ? str_repeat( '&ndash;&nbsp;', $category['depth'] ) : '';
				$selection_category .= "\t";
				$selection_category .= '<option value="' . $category['id'] . '"';
				$selection_category .= ( in_array( $category['id'], $wpb_category_ids, true ) ) ? ' selected="selected"' : '';
				$selection_category .= '>' . $pad . $cat_name . '</option>';
				$selection_category .= "\n";
			}
		}

		// close selection box.
		$selection_category .= "</select>\n";

		?>

		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wpberita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'link_title' ) ); ?>"><?php esc_html_e( 'Link Title:', 'wpberita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'link_title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'link_title' ) ); ?>" type="url" value="<?php echo esc_attr( $link_title ); ?>" />
			<br />
			<small><?php esc_html_e( 'Target url for title (example: https://www.domain.com/target), leave blank if you want using title without link.', 'wpberita' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'subtitle' ) ); ?>"><?php esc_html_e( 'Description Title:', 'wpberita' ); ?></label>
			<textarea class="widefat" rows="3" id="<?php echo esc_html( $this->get_field_id( 'subtitle' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'subtitle' ) ); ?>"><?php echo esc_textarea( $instance['subtitle'] ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'wpb_category_ids' ) ); ?>"><?php esc_html_e( 'Selected categories', 'wpberita' ); ?></label>
			<?php echo $selection_category; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<br />
			<small><?php esc_html_e( 'Click on the categories with pressed CTRL key to select multiple categories. If All Categories was selected then other selections will be ignored.', 'wpberita' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'wpb_number_posts' ) ); ?>"><?php esc_html_e( 'Number post', 'wpberita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'wpb_number_posts' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'wpb_number_posts' ) ); ?>" type="number" value="<?php echo esc_attr( $wpb_number_posts ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'wpb_style' ) ); ?>"><?php esc_html_e( 'Style', 'wpberita' ); ?></label>
			<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'wpb_style', 'wpberita' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'wpb_style' ) ); ?>">
				<option value="style_1" <?php echo selected( $instance['wpb_style'], 'style_1', false ); ?>><?php esc_html_e( 'Default Style', 'wpberita' ); ?></option>
				<option value="style_2" <?php echo selected( $instance['wpb_style'], 'style_2', false ); ?>><?php esc_html_e( 'Just Title Style', 'wpberita' ); ?></option>
				<option value="style_3" <?php echo selected( $instance['wpb_style'], 'style_3', false ); ?>><?php esc_html_e( 'Gallery Style', 'wpberita' ); ?></option>
				<option value="style_4" <?php echo selected( $instance['wpb_style'], 'style_4', false ); ?>><?php esc_html_e( 'Number With Title Style', 'wpberita' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'wpb_idtag' ) ); ?>"><?php esc_html_e( 'Tag:', 'wpberita' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'wpb_idtag' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'wpb_idtag' ) ); ?>" type="text" value="<?php echo esc_attr( $wpb_idtag ); ?>" />
			<br />
			<small><?php esc_html_e( 'ID Tag, separate by commas(,). Example: 1,2,3,4. Leave blank if you want display by category without tag filter', 'wpberita' ); ?></small>
		</p>
		<?php
	}

	/**
	 * Return the array index of a given ID
	 *
	 * @param Array  $arr Arr.
	 * @param Number $id Post ID.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function get_cat_parent_index( $arr, $id ) {
		$len = count( $arr );
		if ( 0 === $len ) {
			return false;
		}
		$id = absint( $id );
		for ( $i = 0; $i < $len; $i++ ) {
			if ( $id === $arr[ $i ]['id'] ) {
				return $i;
			}
		}
		return false;
	}

}

add_action(
	'widgets_init',
	function() {
		register_widget( 'WpBerita_RecentPosts_Widget' );
	}
);
