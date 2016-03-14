<?php

/**
 * Description of action
 *
 * @author Miso <miso@fykos.cz>
 */
class helper_plugin_social_facebook extends DokuWiki_Plugin {



    public function __construct() {
        
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
        if($ref != ""){
            $r.=' data-ref="'.htmlspecialchars($ref).'" ';
        }
        $r.='></div>';
        return $r;
    }

    public function CreatePost($href,$width = false) {
        $r = "";
        $r.=' <div class="fb-post" ';
        $r.=' data-href="'.htmlspecialchars($href).'" ';
        if($width){
            $r.=' data-width="'.$width.'" ';
        }
        $r.=' ></div>';
        return $r;
    }

    public function CreateLike($href,$action = "like",$layout = "standard",$colorscheme = "light",$kid_directed_site = false,$ref = "",$share = false,$show_faces = false,$width = false) {
        $r = "";
        $r.='<div class="fb-like" ';
        $r.=' data-action="'.$action.'" ';
        $r.=' data-colorscheme="'.$colorscheme.'" ';
        $r.=' data-href="'.htmlspecialchars($href).'" ';
        if($kid_directed_site){
            $r.=' data-kid-directed-site="true" ';
        }
        $r.=' data-layout="'.$layout.'" ';
        if($ref != ""){
            $r.=' data-ref="'.htmlspecialchars($ref).'" ';
        }
        if($share){
            $r.=' data-share="true" ';
        }
        if($show_faces){
            $r.=' data-show-faces="true" ';
        }
        if($width){
            $r.=' data-width="'.$width.'" ';
        }
        $r.='></div>';

        return $r;
    }

    public function CreateShare($href,$layout = "button") {
        $r = "";
        $r.='<div class="fb-share-button" ';
        $r.=' data-href="'.htmlspecialchars($href).'"  ';
        $r.=' data-layout="'.$layout.'" ';
        $r.='></div>';
        return $r;
    }

    public function CreatePage($data) {
        
    }

}
