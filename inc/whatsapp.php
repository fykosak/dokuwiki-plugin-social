<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of whatsapp
 *
 * @author root
 */
class helper_plugin_social_whatsapp extends DokuWiki_Plugin {

    public function __construct() {
        
    }
    
    public function CreateSend($href){
        return '<a href="whatsapp://send?text='.htmlspecialchars($href).'"><span class="plugin_social social_button whatsapp-share">Send</span></a>';
    }

}


