<?php

/**
 * Description of sction
 *
 * @author Miso <miso@fykos.cz>
 */
class helper_plugin_social_facebook extends DokuWiki_Plugin {

    //put your code here


    public function __construct() {
        ;
    }

    public function ParseMatch($match) {
        preg_match('/{{FB-([a-z]*)>\s*(\S*)\s*(.*)}}/',$match,$matches);
        list(,$class,$href,$width) = $matches;
        return array('class' => $class,'href' => $href,'width' => $width);
    }

    public function CreateSend($href,$colorscheme = "light",$kid_directed_site = false,$ref = "") {
        $r = "";
        $r.= '<div class="fb-send" ';
        $r.= ' data-href="'.htmlspecialchars($href).'" ';
        $r.= ' data-colorscheme="'.$colorscheme.'" ';
        if($kid_directed_site){
            $r.=' data-kid-directed-site="true" ';
        }
        if($ref!=""){
            $r.=' data-ref="'.htmlspecialchars($ref).'" ';
        }
        $r.='></div>';
        return $r;
    }

    public function CreatePost($data) {
        
    }

    public function CreateLike($data) {
        
    }

    public function CreateShare($href,$layout="button") {
        $r="";
        $r.='<div class="fb-share-button" ';
        $r.=' data-href="'.htmlspecialchars($href).'"  ';
	$r.=' data-layout="'.$layout.'" ';	
	$r.='></div>';
        return $r;
        
    }

    public function CreatePage($data) {
        
    }

}
