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

// If this file is called directly, abort.
if ( ! defined('WPINC' ) ) {
    die('dead!');
}

class Code_Challenges_Startup {

    public function bootstrap() {
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
    }

    public function activate() {
        die('activate function!');
    }
}


/* code runs during plugin activation. Documented in includes/class-plugin-name-activator.php */
/*function activate_code_challenges() {
    die('in here!');
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-code-challenges-activator.php';
    Code_Challenges_Activator::activate();
}*/


/* 
* core plugin class 
 */
//require plugin_dir_path( __FILE__ ) . 'includes/class-code-challenges.php';

/*function run_code_challenges() {
    $plugin = new Code_Challenges();
    $plugin->run();
}
run_code_challenges();*/

$code_challenges_startup = new Code_Challenges_Startup();
$code_challenges_startup->bootstrap();
