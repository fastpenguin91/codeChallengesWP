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


function jsc_plugin_css() {
  wp_register_style('jsc_code_challenges', plugins_url() . '/codeChallenges/css/jsc_code_challenges.css' );
  wp_enqueue_style( 'jsc_code_challenges',
    dirname(__FILE__) . '/css/jsc_code_challenges.css',
    '',
    false
    );
}

add_action( 'wp_enqueue_scripts', 'jsc_plugin_css');

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

     if ($post->post_type == 'code_challenge') {
          $single_template = dirname( __FILE__ ) . '/single-code_challenge.php';
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

global $jal_db_version;
$jal_db_version = '1.0';

function jal_install() {
  global $wpdb;
  global $jal_db_version;

  $table_name = $wpdb->prefix . 'jsc_challenge_user';
  
  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
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

// enqueue and localise scripts
 wp_enqueue_script( 'my-ajax-handle', plugin_dir_url( __FILE__ ) . 'ajax.js', array( 'jquery' ) );
 wp_localize_script( 'my-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
 // THE AJAX ADD ACTIONS
 add_action( 'wp_ajax_the_ajax_hook', 'the_action_function' );
 add_action( 'wp_ajax_reset_challenge', 'the_reset_challenge_function');

function the_reset_challenge_function(){
  global $wpdb;

  $user = wp_get_current_user();
  $challenge_id = (int) $_POST['challenge_id'];

  $wpdb->delete(
    $wpdb->prefix . 'jsc_challenge_user',
    array(
      'user_id' => $user->ID,
      'challenge_id' => $challenge_id
      )
    );
  die();
}



 function the_action_function(){
    global $wpdb;
$user = wp_get_current_user();
    $challenge_id = (int) $_POST['challenge_id'];

    $wpdb->insert(
      $wpdb->prefix . 'jsc_challenge_user',
      array(
        'user_id' => $user->ID,
        'challenge_id' => $challenge_id
        )
      );
  
 die();
 }
