<?php


class CCalEvent
{
  public static function init() {
    register_post_type('ccal_event',
      array(
        'labels'      => array(
          'name'          => __('Events', 'textdomain'),
          'singular_name' => __('Event', 'textdomain'),
          'add_new_item'       => __('Neues Event erstellen', 'textdomain'),
        ),
        'public'      => false,
        'show_ui'     => true,
        'menu_icon'   => 'dashicons-calendar',
        'has_archive' => true,
        'supports'    => array(
          'title',
          'author',
          'editor',
          'custom-fields'
        ),
        'register_meta_box_cb' => 'CCalEvent::post_add_metaboxes'
      )
    );
  }

  public static function post_add_metaboxes($post)
  {
    add_meta_box('ccal-event-date', __( 'Datum und Uhrzeit', 'textdomain' ), 'CCalEvent::post_metabox_date_display_callback', 'ccal_event', 'side', "core");
  }

  public static function post_metabox_date_display_callback($post)
  {
    $event_timestamp = current_time("timestamp")+3600;
    $value = get_post_meta( $post->ID, 'event_date', true );
    if ($value && is_numeric($value)) {
      $event_timestamp = $value;
    }

    wp_nonce_field( 'ccal_inner_custom_box', 'ccal_inner_custom_box_nonce' );
    require_once(CCAL__PLUGIN_DIR . "views/datetime.php");
  }

  public static function post_metabox_date_save($post_id)
  {
    //verify if data is available
    if ( !isset($_POST['ccal-aa']) ) {
        return $post_id;
    }

    $nonce = $_POST['ccal_inner_custom_box_nonce'];
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'ccal_inner_custom_box' ) ) {
        return $post_id;
    }

    //verify user permission
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return $post_id;
    }

    $time_str = $_POST['ccal-aa'] . '-' . $_POST['ccal-mm'] . "-" . $_POST['ccal-jj'] . " " . $_POST['ccal-hh'] . ":" . $_POST['ccal-mn'] . ":00";
    $event_timestamp = strtotime($time_str);
    if (!$event_timestamp) {
      return $post_id;
    }

    if ( ! add_post_meta( $post_id, 'event_date', $event_timestamp, true ) ) {
      update_post_meta ( $post_id, 'event_date', $event_timestamp );
    }

    add_post_meta( $post_id, 'event_users', "{}", true );
  }

  public static function post_column_filter($columns) {
    $new_columns = array(
      'cb' => $columns['cb'],
      'title' => $columns['title'],
      'event_date' => __('Event Datum'),
      'author' => $columns['author'],
      'date' => $columns['date']
    );
    return $new_columns;
  }

  public static function post_column_action($column_id, $post_id)
  {
    if ($column_id == "event_date") {
      $value = get_post_meta( $post_id, 'event_date', true );
      if ($value && is_numeric($value)) {
        echo CCalEvent::format_timestamp($value);
      }
    }
  }

  public static function format_timestamp($timestamp)
  {
    return date("d.m.Y - H:i", $timestamp);
  }


}
add_action( 'init', 'CCalEvent::init' );
add_action( 'save_post', 'CCalEvent::post_metabox_date_save' );
add_filter('manage_ccal_event_posts_columns','CCalEvent::post_column_filter');
add_action( 'manage_posts_custom_column','CCalEvent::post_column_action', 10, 2 );
