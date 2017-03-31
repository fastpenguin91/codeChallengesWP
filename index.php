<?php
/**
 * @package codeChallenges
 * @version 1.6
 */
/*
Plugin Name: Code Challenges
Plugin URI:
Description: 
Author: John
Version: 1.0
Author URI: 
*/



register_activation_hook( __FILE__, 'jal_install' );
register_activation_hook( __FILE__, 'jal_install_data' );

add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'code_challenge',
    array(
      'labels' => array(
        'name' => __( 'Challenges' ),
        'singular_name' => __( 'Challenge' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}

function jsc_get_custom_post_type_template($single_template) {
     global $post;
     //die('called the get_custom_post_type_template function.');

     if ($post->post_type == 'code_challenge') {
          $single_template = dirname( __FILE__ ) . '/single-code_challenge.php';
          //die($single_template);
     }
     return $single_template;
}
add_filter( 'single_template', 'jsc_get_custom_post_type_template' );

add_filter( 'template_include', 'portfolio_page_template', 99 );
apply_filters( 'template_include', $template );
function portfolio_page_template( $template ) {
  if ( is_page( 'code-challenges' )  ) {
    //die('dead inside portfolio_page_template');
    $new_template = dirname( __FILE__ ) . '/archive-challenge.php';
    //die($new_template);
    if ( '' != $new_template ) {
      return $new_template ;
    }
  }

  return $template;
}

function jsc_solve_challenge(){
  global $wpdb;

  //die('Die from ajax!');

/*
  $user_id = (int) $_POST['user_id'];
  $challenge_id = (int) $_POST['challenge_id'];

  $wpdb->insert(
    $wpdb->prefix . 'jsc_challenge_user',
    array(
      'user_id' => $user_id,
      'challenge_id' => $challenge_id,
      'challenge_user' => $challenge_id . '_' . $user_id
      )
    );
*/


}
add_action( 'admin_post_solve_challenge', 'jsc_solve_challenge' );

//global $jsc_challenge_user_db_version;
//$jsc_challenge_user_db_version = '1.0';

/*function jsc_pivot_table_install () {
  global $wpdb;
  global $jsc_challenge_user_db_version;

  $table_name = $wpdb->prefix . "jsc_challenge_user";

  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table_name (
    id tinytext NOT NULL,
    challenge_id mediumint(9) NOT NULL,
    user_id mediumint(9) NOT NULL,
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  add_option( 'jsc_challenge_user_db_version', $jsc_challenge_user_db_version );

}*/

global $jal_db_version;
$jal_db_version = '1.0';

function jal_install() {
  global $wpdb;
  global $jal_db_version;

  $table_name = $wpdb->prefix . 'jsc_challenge_user';
  
  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    challenge_user tinytext NOT NULL,
    challenge_id mediumint(9) NOT NULL,
    user_id mediumint(9) NOT NULL,
    PRIMARY KEY  (id)
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  add_option( 'jal_db_version', $jal_db_version );
}


function jal_install_data() {
  global $wpdb;
  
  $welcome_name = 'Mr. WordPress';
  $welcome_text = 'Congratulations, you just completed the installation!';
  $welcome_challenge_id = 4;
  $welcome_user_id      = 2;
  
  $table_name = $wpdb->prefix . 'jsc_challenge_user';
  
  $wpdb->insert( 
    $table_name, 
    array(
      'challenge_user' => '4_2',
      'challenge_id' => $welcome_challenge_id,
      'user_id' => $welcome_user_id, 
    ) 
  );
}



/*function jsc_pivot_install_data() {
  global $wpdb;

  $welcome_user = 2;
  $welcome_challenge = 3;
  $welcome_id   = '3_2';

  $table_name = $wpdb->prefix . 'jsc_challenge_user';

  $wpdb->insert(
    $table_name,
    array(
      'id' => $welcome_id,
      'challenge_id' => $welcome_challenge,
      'user_id' => $welcome_user,
      )
    );
}*/
?>
