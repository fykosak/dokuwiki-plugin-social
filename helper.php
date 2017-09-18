<?php

/**
 * Description of helper
 *
 * @author Michal Červeńák <miso@fyko.cz>
 */
require 'inc/facebook.php';
require 'inc/whatsapp.php';
require 'inc/meta.php';

class helper_plugin_social extends DokuWiki_Plugin {
    /**
     * @var \PluginSocial\Facebook
     */
    public $facebook;
    /**
     * @var \PluginSocial\Meta
     */
    public $meta;
    /**
     * @var \PluginSocial\Whatsapp
     */
    public $whatsapp;

    public function __construct() {
        $this->facebook = new \PluginSocial\Facebook();
        $this->whatsapp = new \PluginSocial\Whatsapp();
        $this->meta = new \PluginSocial\Meta();
    }
}
