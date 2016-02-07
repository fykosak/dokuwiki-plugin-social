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
    
    }

    
    public function RenderMeta(Doku_Event &$event){
        global $ID;
      
        $SocialMeta=p_get_metadata($ID,'plugin_social');
        
        $this->helper->meta->Render($SocialMeta,$event);

        
    }

}
