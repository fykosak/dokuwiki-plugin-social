<?php

/**
 * Description of helper
 *
 * @author root
 */
require 'inc/facebook.php';
require 'inc/meta.php';

class helper_plugin_social extends DokuWiki_Plugin {

    public $facebook;
    public $meta;

    public function __construct() {
        $this->facebook = new helper_plugin_social_facebook();
        $this->meta = new helper_plugin_social_meta();
    }

}
