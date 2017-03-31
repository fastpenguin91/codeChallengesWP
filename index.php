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
    $new_template = dirname( __FILE__ ) . '/archive-challenge.php';
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

function get_randomcol() {
  echo "<h1>HEY TEST TESTTDKFJSLDKFJS</h1>";
  check_ajax_referer( "helloworld" );
  $col = substr( mt_rand(), 0, 6 );
  echo '#' . $col;
  die();
}
add_action( 'wp_ajax_randomcol', 'get_randomcol' );

// enqueue and localise scripts
 wp_enqueue_script( 'my-ajax-handle', plugin_dir_url( __FILE__ ) . 'ajax.js', array( 'jquery' ) );
 wp_localize_script( 'my-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
 // THE AJAX ADD ACTIONS
 add_action( 'wp_ajax_the_ajax_hook', 'the_action_function' );
 add_action( 'wp_ajax_nopriv_the_ajax_hook', 'the_action_function' ); // need this to serve non logged in users
 // THE FUNCTION
 function the_action_function(){
 /* this area is very simple but being serverside it affords the possibility of retreiving data from the server and passing it back to the javascript function */
 $name = $_POST['name'];
 echo"Hello World, " . $name;// this is passed back to the javascript function
 die();// wordpress may print out a spurious zero without this - can be particularly bad if using json
 }
 // ADD EG A FORM TO THE PAGE
 function hello_world_ajax_frontend(){
 $the_form = '
 <p>Hello from in the codeChallenges plugin</p>
 <form id="theForm">
 <input id="name" name="name" value = "name" type="text" />
 <input name="action" type="hidden" value="the_ajax_hook" />&nbsp; <!-- this puts the action the_ajax_hook into the serialized form -->
 <input id="submit_button" value = "Click This" type="button" onClick="submit_me();" />
 </form>
 <div id="response_area">
 This is where we\'ll get the response
 </div>';
 return $the_form;
 }
 add_shortcode("hw_ajax_frontend", "hello_world_ajax_frontend");




?>