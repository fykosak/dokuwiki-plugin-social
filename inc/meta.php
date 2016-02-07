<?php

/**
 * Description of sction
 *
 * @author Miso <miso@fykos.cz>
 */
class helper_plugin_social_meta extends DokuWiki_Plugin {

    public static $FBmeta = array('url','title','description','site_name','image','type','locale');

    public function __construct() {
        
    }

    public function CreateDefault() {
        global $ID;
        $data = array();
        $data['FB']['url'] = wl($ID,null,true);
        $data['FB']['title'] = p_get_first_heading($ID);
        $text = "";
        $data['FB']['description'] = $text;
        $data['FB']['site_name'] = "FYKOS";
       
        //var_dump(p_get_metadata($ID,'relation'));
        $data['FB']['image'] = ml($this->getConf('default_image'),array('w' => 600,'h' => 600),true,'&',true);
        $data['FB']['type'] = "website";
        $data['FB']['locale'] = 'cs_CZ';


        return $data;
    }

    public function Render($meta,Doku_Event &$event) {
        $default = $this->CreateDefault();
        
        $this->RenderFB($meta['FB'],$event,$default['FB']);
    }

    private function RenderFB($data,Doku_Event &$event,$default = array()) {

        foreach (self::$FBmeta as $meta) {
            $v = $data[$meta] ? $data[$meta] : $default[$meta];
            $event->data['meta'][] = array('property' => 'og:'.$meta,'content' => $v);
        }
    }

}
