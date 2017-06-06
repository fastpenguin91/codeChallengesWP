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


require_once( dirname( __FILE__ ) . '/setup.php' );
require_once( dirname( __FILE__ ) . '/db_setup.php' );
require( plugin_dir_path( __FILE__ ) . '/includes/class-code-challenges-wp.php' );


function jsc_get_custom_post_type_template($single_template) {
    global $post;

    if ($post->post_type == 'code_challenge') {
        $single_template = dirname( __FILE__ ) . '/single-code_challenge.php';
    }
    return $single_template;
}

add_filter( 'single_template', 'jsc_get_custom_post_type_template' );
add_filter( 'template_include', 'portfolio_page_template', 99 );
add_filter( 'template_include', 'unsolved_challenges_template', 99);
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

function unsolved_challenges_template( $template ) {
    if ( is_page( 'unsolved-challenges' )  ) {
        $new_template = dirname( __FILE__ ) . '/unsolved-challenges.php';
        if ( '' != $new_template ) {
            return $new_template ;
        }
    }
    return $template;
}

// enqueue and localise scripts
wp_enqueue_script( 'my-ajax-handle', plugin_dir_url( __FILE__ ) . 'ajax.js', array( 'jquery' ) );
wp_localize_script( 'my-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
// THE AJAX ADD ACTIONS
add_action( 'wp_ajax_the_ajax_hook', 'the_action_function' );
add_action( 'wp_ajax_reset_challenge', 'the_reset_challenge_function');


require_once( dirname( __FILE__ ) . '/db_setup.php' );

//db function
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


//db function
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