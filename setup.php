<?php

function jsc_plugin_css() {
    wp_register_style('jsc_code_challenges',
                      plugins_url() . '/codeChallengesWP/css/jsc_code_challenges.css');
    wp_enqueue_style( 'jsc_code_challenges',
                      dirname(__FILE__) . '/css/jsc_code_challenges.css',
                      '',
                      false );
}

add_action( 'wp_enqueue_scripts', 'jsc_plugin_css');
add_action( 'init', 'create_post_type' );

function create_post_type() {
    //   die("create post type");
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

?>