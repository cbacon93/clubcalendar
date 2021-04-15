<?php

class CCalWidget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'ccalwidget',
			'description' => 'Calendar for Clubs',
		);
		parent::__construct( 'ccalwidget', 'Club Calendar', $widget_ops );

    if ( is_active_widget( false, false, $this->id_base ) ) {
			wp_enqueue_style("ccal_style", CCAL__PLUGIN_URL . 'css/ccal.css');
			wp_enqueue_style('dashicons');
			wp_enqueue_script("ccal_script", CCAL__PLUGIN_URL . 'js/ccal.js');
		}

	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$upcoming_events = new WP_Query(array(
			'post_type'      => 'ccal_event',
			'posts_per_page' => 5,
			'orderby' => 'event_date',
      'order' => 'ASC',
			'meta_key' => 'event_date',
			'meta_value' => current_time("timestamp")-7200,
			'meta_compare' => ">="
		));
		require_once(CCAL__PLUGIN_DIR . "views/widget.php");
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}


add_action( 'widgets_init', function(){
	register_widget( 'CCalWidget' );
});
