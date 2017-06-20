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
     * @var \pluginSocial\Facebook
     */
    public $facebook;
    /**
     * @var \pluginSocial\Meta
     */
    public $meta;
    /**
     * @var \pluginSocial\Whatsapp
     */
    public $whatsapp;

    public function __construct() {
        $this->facebook = new \pluginSocial\Facebook();
        $this->whatsapp = new \pluginSocial\Whatsapp();
        $this->meta = new \pluginSocial\Meta();
    }
}
