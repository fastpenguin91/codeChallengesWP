<?php

class Code_Challenges {
    /**
     * The unique Identifier of the plugin
     * @since 1.0
     * @access protected
     * @var string $plugin_name   The string used to uniquely identify plugn
     */
    protected $loader;
    
    protected $plugin_name;

    public function __construct() {
        $this->plugin_name = 'code-challenges';

        $this->load_dependencies();
    }

    private function load_dependencies() {
        die('load deps');

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-code-challenges-public.php';

        $this->loader = new Code_Challenges_Loader();
    }

    private function define_public_hooks() {

        $plugin_public = new Code_Challenges_Public();
        die('define public hooks');
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
    }

    public function run() {
        $this->loader->run();
    }
}

?>
