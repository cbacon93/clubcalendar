<?php


class CCalAjax {
  public static function get_event()
  {
    $user = wp_get_current_user();

    //validate user input
    if (!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) {
      $response["success"] = false;
      $response["result"] = "invalid input";
      wp_send_json( $response );
      wp_die();
    }

    $post_id = $_POST['post_id'];
    $thispost = get_post( $post_id );
    $thispost_custom = get_post_custom($post_id);

    //validate object
    if ( !is_object( $thispost ) || !is_array($thispost_custom) ) {
      $response["success"] = false;
      $response["result"] = "invalid post id";
      wp_send_json( $response );
      wp_die();
    }

    //validate post type and status
    if ($thispost->post_type != "ccal_event" ||
      $thispost->post_status != "publish")
    {
      $response["success"] = false;
      $response["result"] = "invalid post id";
      wp_send_json( $response );
      wp_die();
    }

    //generate participation list
    $wp_users = get_users( array( 'fields' => array( 'ID', 'display_name' ) ) );
    $participation = json_decode($thispost_custom['event_users'][0], true);
    $participation_list = array();
    $own_status = 0;
    foreach($participation as $uid=>$status) {
      if ($uid == $user->ID) {
        $own_status = $status;
        continue;
      }

      foreach($wp_users as $user) {
        if ($user->ID == $uid) {
          $participation_list[$user->display_name] = $status;
          break;
        }
      }
    }


    $response["success"] = true;
    $response["result"] = "success";
    $response["data"] = array(
      'ID' => $thispost->ID,
      'title' => $thispost->post_title,
      'content' => $thispost->post_content,
      'author' => $thispost->post_author,
      'own_status' => $own_status,
      'event_date' => CCalEvent::format_timestamp($thispost_custom['event_date'][0]),
      'event_users' => $participation_list
    );
    wp_send_json( $response );
    wp_die();
  }

  public static function set_event_status()
  {
    //only users are allowed
    $user = wp_get_current_user();
    if (!$user->exists()) {
      $response["success"] = false;
      $response["result"] = "not logged in";
      wp_send_json( $response );
      wp_die();
    }


    //validate user input
    if (!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) {
      $response["success"] = false;
      $response["result"] = "invalid input";
      wp_send_json( $response );
      wp_die();
    }
    $new_user_status = intval($_POST['user_status']);
    if ($new_user_status < 0 || $new_user_status > 3) {
      $response["success"] = false;
      $response["result"] = "invalid input";
      wp_send_json( $response );
      wp_die();
    }


    $post_id = $_POST['post_id'];
    $thispost = get_post( $post_id );
    $thispost_custom = get_post_custom($post_id);

    //validate object
    if ( !is_object( $thispost ) || !is_array($thispost_custom) ) {
      $response["success"] = false;
      $response["result"] = "invalid post id";
      wp_send_json( $response );
      wp_die();
    }

    //validate post type and status
    if ($thispost->post_type != "ccal_event" ||
      $thispost->post_status != "publish")
    {
      $response["success"] = false;
      $response["result"] = "invalid post id";
      wp_send_json( $response );
      wp_die();
    }


    $event_users = json_decode($thispost_custom['event_users'][0], true);
    $event_users[strval($user->ID)] = $new_user_status;

    update_post_meta ( $thispost->ID, 'event_users', json_encode($event_users) );

    $response["success"] = true;
    $response["result"] = "success";
    wp_send_json( $response );
    wp_die();
  }
}
add_action( 'wp_ajax_nopriv_ccal_get_event', 'CCalAjax::get_event' );
add_action( 'wp_ajax_ccal_set_status', 'CCalAjax::set_event_status' );
