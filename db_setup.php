<?php


register_activation_hook( __FILE__, 'jal_install' );
register_activation_hook( __FILE__, 'jal_install_data' );

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
?>
