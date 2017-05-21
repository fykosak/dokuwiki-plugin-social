<?php

/**
 * Description of helper
 *
 * @author root
 */
require 'inc/facebook.php';
require 'inc/whatsapp.php';
require 'inc/meta.php';

class helper_plugin_social extends DokuWiki_Plugin {
    /**
     * @var helper_plugin_social_facebook
     */
    public $facebook;
    /**
     * @var helper_plugin_social_meta
     */
    public $meta;

    public function __construct() {
        $this->facebook = new helper_plugin_social_facebook();
        $this->whatsapp = new helper_plugin_social_whatsapp();
        $this->meta = new helper_plugin_social_meta();
    }

}
