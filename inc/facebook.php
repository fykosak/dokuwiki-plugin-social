<?php

namespace pluginSocial;

class Facebook extends \DokuWiki_Plugin {

    public function parseMatch($match) {
        preg_match('/{{FB-([a-z]*)>\s*(\S*)\s*(.*)}}/', $match, $matches);
        list(, $class, $href, $width) = $matches;
        return ['class' => $class, 'href' => $href, 'width' => $width];
    }

    public function createSend($href) {
        return '<button ' .
            'data-link="' . htmlspecialchars($href) . '" ' .
            'data-method="send" ' .
            'disabled="disabled" ' .
            'class="btn btn-messenger plugin-social fb send">' .
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
    <path d="M 25 2 C 12.346406 2 2 11.598008 2 23.5 C 2 30.006279 5.1321774 35.786204 10 39.71875 L 10 47 L 10 48.65625 L 11.46875 47.875 L 18.6875 44.125 C 20.703106 44.664209 22.801527 45 25 45 C 37.653594 45 48 35.401992 48 23.5 C 48 11.598008 37.653594 2 25 2 z M 25 4 C 36.646406 4 46 12.757992 46 23.5 C 46 34.242008 36.646406 43 25 43 C 22.83693 43 20.742743 42.687614 18.78125 42.125 L 18.40625 42.03125 L 18.0625 42.21875 L 12 45.375 L 12 39.3125 L 12 38.8125 L 11.625 38.53125 C 6.9625477 34.94328 4 29.539893 4 23.5 C 4 12.757992 13.353594 4 25 4 z M 22.71875 17.71875 L 10.6875 30.46875 L 21.5 24.40625 L 27.28125 30.59375 L 39.15625 17.71875 L 28.625 23.625 L 22.71875 17.71875 z" overflow="visible" font-family="Sans"></path>
</svg>' .
            'Send</button>';
    }

    public function createPost($href, $width = false) {
        $html = '<div class="fb-post" ' .
            ' data-href="' . htmlspecialchars($href) . '" ';
        if ($width) {
            $html .= ' data-width="' . $width . '" ';
        }
        $html .= '></div>';
        return $html;
    }

    public function createLike($href) {
        return '<div data-size="large" data-layout="button" data-href="' . hsc($href) . '" ' . '></div> ';
    }

    public function createWrap($href) {
        return '<div data-share="true" data-size="large" data-layout="button" data-href="' . hsc($href) . '" ' . '></div> ';
    }

    public function createShare($href) {
        return '<button ' .
            'data-href = "' . htmlspecialchars($href) . '" ' .
            'disabled="disabled" ' .
            'data-method="share" ' .
            'class="btn btn-fb plugin-social fb share">' .
            '<i class="fa fa-facebook"></i> Share</button>';
    }

    public function createPage($data) {

    }

}
