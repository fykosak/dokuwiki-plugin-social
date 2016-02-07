<?php

if(!defined('DOKU_INC')){
    die();
}

class syntax_plugin_social_facebook extends DokuWiki_Syntax_Plugin {

    private $helper;

    public function __construct() {
        $this->helper = $this->loadHelper('social');
    }

    public function getType() {
        return 'substition';
    }

    public function getPType() {
        return 'block';
    }

    public function getAllowedTypes() {
        return array('formatting','substition','disabled');
    }

    public function getSort() {
        return 226;
    }

    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\{\{FB-.+?>.*?\}\}',$mode,'plugin_social_facebook');
    }

    /**
     * Handle the match
     */
    public function handle($match,$state,$pos,Doku_Handler &$handler) {


        $params = $this->helper->facebook->ParseMatch($match);




        return array($state,$params);
    }

    public function render($mode,Doku_Renderer &$renderer,$data) {
        // $data is what the function handle return'ed.
        global $ID;
        if($mode == 'xhtml'){
            /** @var Do ku_Renderer_xhtml $renderer */
            list($state,$param) = $data;

            switch ( $param['class']){
                case "post":
                    
                    $renderer->doc.= $this->helper->facebook->CreatePost($param['href'],$param['width']);
                    break;
                case "send":
                   $href=  ($param['href']=='')?wl($ID,null,true):wl($param['href']);
                    $renderer->doc.= $this->helper->facebook->CreateSend($href);
                    break;
                case "like":
                    $href=  ($param['href']=='')?wl($ID,null,true):wl($param['href']);
                    $renderer->doc.= $this->helper->facebook->CreateLike($href);
                    break;
                case "share":
                     $href=  ($param['href']=='')?wl($ID,null,true):wl($param['href']);
                    $renderer->doc.= $this->helper->facebook->CreateShare($href);
                    break;
                case "page":
                  //  $renderer->doc.= $this->helper->facebook->{'Create'.$param['class']}($param['href'],$param['width']);
                     msg('not implement');
                    break;
                default :
                msg('No match');
            }

            
        }
        return false;
    }

}
