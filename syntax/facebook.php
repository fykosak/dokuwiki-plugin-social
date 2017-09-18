<?php

if (!defined('DOKU_INC')) {
    die();
}

class syntax_plugin_social_facebook extends DokuWiki_Syntax_Plugin {
    /**
     * @var helper_plugin_social
     */
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
        return [];
    }

    public function getSort() {
        return 226;
    }

    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\{\{FB-.+?>.*?\}\}', $mode, 'plugin_social_facebook');
    }

    public function handle($match, $state, $pos, \Doku_Handler $handler) {
        $params = $this->helper->facebook->parseMatch($match);
        return [$state, $params];
    }

    public function render($mode, Doku_Renderer $renderer, $data) {
        global $ID;
        if ($mode == 'xhtml') {
            list($state, $param) = $data;
            if ($state === DOKU_LEXER_SPECIAL) {
                $href = ($param['href'] == '') ? wl($ID, null, true) : wl($param['href']);
                switch ($param['class']) {
                    case 'post':
                        $renderer->doc .= $this->helper->facebook->createPost($param['href'], $param['width']);
                        break;
                    case 'send':
                        $renderer->doc .= $this->helper->facebook->createSend($href);
                        break;
                    case 'like':
                        $renderer->doc .= $this->helper->facebook->createLike($href);
                        break;
                    case 'share':
                        $renderer->doc .= $this->helper->facebook->createShare($href);
                        break;
                    case 'page':
                        $renderer->doc .= $this->helper->facebook->createPage($href);
                        break;

                    case 'wrap':
                        $renderer->doc .= '<div class="plugin_social fb_wrap">';
                        $renderer->doc .= $this->helper->facebook->createWrap($href);
                        $renderer->doc .= '</div>';
                        break;
                    case 'comment':
                        $renderer->doc .= $this->helper->facebook->createComment($href);
                        break;
                    default :
                        msg('Plugin social: FB component not match', -1);
                }
            }
        }
        return false;
    }
}
