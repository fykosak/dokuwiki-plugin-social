<?php

class helper_plugin_social_facebook extends DokuWiki_Plugin {

    public function parseMatch($match) {
        preg_match('/{{FB-([a-z]*)>\s*(\S*)\s*(.*)}}/', $match, $matches);
        list(, $class, $href, $width) = $matches;
        return ['class' => $class, 'href' => $href, 'width' => $width];
    }

    public function createSend($href, $colorScheme = 'light', $kid_directed_site = false, $ref = '') {
        $html = '';
        $html .= '<div class="fb-send" ';
        $html .= ' data-href="' . htmlspecialchars($href) . '" ';
        $html .= ' data-colorscheme="' . $colorScheme . '" ';
        if ($kid_directed_site) {
            $html .= ' data-kid-directed-site="true" ';
        }
        if ($ref != '') {
            $html .= ' data-ref="' . htmlspecialchars($ref) . '" ';
        }
        $html .= '></div>';
        return $html;
    }

    public function createPost($href, $width = false) {
        $html = '';
        $html .= ' <div class="fb-post" ';
        $html .= ' data-href="' . htmlspecialchars($href) . '" ';
        if ($width) {
            $html .= ' data-width="' . $width . '" ';
        }
        $html .= ' ></div>';
        return $html;
    }

    public function createLike($href, $action = 'like', $layout = 'standard', $colorScheme = 'light', $kid_directed_site = false, $ref = '', $share = false, $show_faces = false, $width = false) {
        $html = '';
        $html .= '<div class="fb-like" ';
        $html .= ' data-action="' . $action . '" ';
        $html .= ' data-colorscheme="' . $colorScheme . '" ';
        $html .= ' data-href="' . htmlspecialchars($href) . '" ';
        if ($kid_directed_site) {
            $html .= ' data-kid-directed-site="true" ';
        }
        $html .= ' data-layout="' . $layout . '" ';
        if ($ref != '') {
            $html .= ' data-ref="' . htmlspecialchars($ref) . '" ';
        }
        if ($share) {
            $html .= ' data-share="true" ';
        }
        if ($show_faces) {
            $html .= ' data-show-faces="true" ';
        }
        if ($width) {
            $html .= ' data-width="' . $width . '" ';
        }
        $html .= '></div>';

        return $html;
    }

    public function createShare($href, $layout = 'button') {
        $html = '';
        $html .= '<div class="fb-share-button" ';
        $html .= ' data-href="' . htmlspecialchars($href) . '"  ';
        $html .= ' data-layout="' . $layout . '" ';
        $html .= '></div>';
        return $html;
    }

    public function createPage($data) {

    }

}
