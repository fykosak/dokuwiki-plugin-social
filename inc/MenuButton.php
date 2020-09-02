<?php

namespace FYKOS\dokuwiki\Extenstion\PluginSocial;

use dokuwiki\Menu\Item\AbstractItem;

/**
 * Class MenuButton
 * @author Michal Červeňák <miso@fykos.cz>
 */
class MenuButton extends AbstractItem {

    public function __construct() {
        parent::__construct();
        $this->params = ['do' => 'social', 'social[do]' => 'edit'];
        $this->label = 'Set page metadata'; // TODO i18n
    }
}
