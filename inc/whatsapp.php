<?php

namespace pluginSocial;
class Whatsapp extends \DokuWiki_Plugin {

    public function CreateSend($href) {
        return '<a href="whatsapp://send?text=' . htmlspecialchars($href) .
        '"><span class="plugin_social social_button whatsapp-share">Send</span></a>';
    }
}
