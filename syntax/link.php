<?php

if (!defined('DOKU_INC')) {
    die();
}

class syntax_plugin_social_link extends DokuWiki_Syntax_Plugin {
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
        $this->Lexer->addSpecialPattern('\{\{social-link-.+?>.*?\}\}', $mode, 'plugin_social_link');
    }

    public function handle($match, $state, $pos, \Doku_Handler $handler) {
        preg_match('/{{social-link-([a-z]*)>(.*)}}/', $match, $matches);
        list(, $type, $link) = $matches;
        return [$state, ['type' => $type, 'link' => $link]];
    }

    public function render($mode, Doku_Renderer $renderer, $data) {
        if ($mode == 'xhtml') {
            list($state, $param) = $data;
            if ($state === DOKU_LEXER_SPECIAL) {
                switch ($param['type']) {
                    case 'fb':
                        $icon = 'fab fa-facebook';
                        $label = 'Facebook';
                        break;
                    case 'yt':
                        $icon = 'fab fa-youtube';
                        $label = 'YouTube';
                        break;
                    case 'ig':
                        $icon = 'fab fa-instagram';
                        $label = 'Instagram';
                        break;
                    default :
                        msg('Plugin social: link component not match', -1);
                }
                $renderer->doc .= '<p><a href="' . htmlspecialchars($param['link']) . '"><span style="margin-right:0.4rem" class="' . $icon . '"></span>' . $label . '</a></p>';
            }
        }
        return false;
    }
}
