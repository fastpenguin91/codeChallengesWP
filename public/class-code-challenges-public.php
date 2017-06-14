<?php

class Code_Challenges_Public {

    private $code_challenges;

    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-public.css', array(), $this->version, 'all' );
    }

}

?>
