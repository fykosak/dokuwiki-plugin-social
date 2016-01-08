<?php
/**
 * Description of sction
 *
 * @author Miso <miso@fykos.cz>
 */
class helper_plugin_social_facebook extends DokuWiki_Plugin{
    //put your code here
    
    
    public function __construct() {
        ;
    }
    
    public function ParseMatch($match){
        preg_match('/{{FB-([a-z]*)>\s*(\S*)\s*(.*)}}/',$match,$matches);
        list(,$class,$href,$width) = $matches;
        return array('class' => $class,'href' => $href,'width' => $width);
          
          
        
    }
    public function CreateSend($data){
        
    }
    public function CreatePost($data){
        
    }
    public function CreateLike($data){
        
    }
    public function CreateShare($data){
        
    }
    public function CreatePage($data){
        
    }
    
}
