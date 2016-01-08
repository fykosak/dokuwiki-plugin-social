<?php

/**
 * Description of sction
 *
 * @author Miso <miso@fykos.cz>
 */
class action_plugin_social extends DokuWiki_Action_Plugin {

    private $helper;

    public function __construct() {
        $this->helper = $this->loadHelper('social');
    }

    public function register(Doku_Event_Handler $controller) {

        $controller->register_hook('TPL_METAHEADER_OUTPUT','BEFORE',$this,'RenderMeta');
        $controller->register_hook('ACTION_ACT_PREPROCESS','BEFORE',$this,'CreateSocialMeta');
    }

    public function CreateSocialMeta(Doku_Event &$event) {
        global $SocialMeta;
        $SocialMeta = $this->helper->meta->CreateDefault();
        
        
       
    }
    
    public function RenderMeta(Doku_Event &$event){
        global $ID;
        global $SocialMeta;
        
        $this->helper->meta->Render($SocialMeta,$event);

        
    }

}
