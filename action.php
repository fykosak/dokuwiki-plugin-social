<?php

use dokuwiki\Extension\ActionPlugin;
use dokuwiki\Extension\Event;
use dokuwiki\Extension\EventHandler;
use dokuwiki\Form\Form;
use FYKOS\dokuwiki\Extension\PluginSocial\MenuButton;
use FYKOS\dokuwiki\Extension\PluginSocial\OpenGraphData;

require_once __DIR__ . '/inc/OpenGraphData.php';
require_once __DIR__ . '/inc/MenuButton.php';

/**
 * Class action_plugin_social
 * @author Michal Červeňák <miso@fykos.cz>
 */
class action_plugin_social extends ActionPlugin {

    private const ACTION_PARAM = 'social';

    public OpenGraphData $openGraphData;

    public function __construct() {
        $this->openGraphData = new OpenGraphData();
    }

    public function register(EventHandler $controller): void {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'renderMeta');
        $controller->register_hook('TPL_ACT_UNKNOWN', 'BEFORE', $this, 'tplMetaDataForm');
        $controller->register_hook('ACTION_ACT_PREPROCESS', 'BEFORE', $this, 'actPreprocessMeta');
        $controller->register_hook('MENU_ITEMS_ASSEMBLY', 'BEFORE', $this, 'tplMetaDataMenuButton');
    }

    public function actPreprocessMeta(Event $event): void {
        global $INPUT;
        $act = $event->data;

        if (!$this->openGraphData->canSaveMeta()) {
            return;
        }
        if ($act !== self::ACTION_PARAM) {
            return;
        }
        $event->preventDefault();
        $event->stopPropagation();

        switch ($INPUT->param(self::ACTION_PARAM)['do']) {
            case 'save':
                $this->saveMeta($event);
        }
    }

    public function tplMetaDataMenuButton(Event $event): void {
        if ($event->data['view'] === 'page' && $this->openGraphData->canSaveMeta()) {
            $event->data['items'][] = new MenuButton();
        }
    }

    public function tplMetaDataForm(Event $event): void {
        if ($event->data !== self::ACTION_PARAM) {
            return;
        }

        global $INPUT;
        if ($INPUT->param(self::ACTION_PARAM)['do'] !== 'edit') {
            return;
        }
        global $ID;
        $form = new Form();
        $form->setHiddenField('target', 'plugin_social');
        $form->setHiddenField('id', $ID);
        $form->setHiddenField('do', self::ACTION_PARAM);
        $form->setHiddenField(self::ACTION_PARAM . '[do]', 'save');

        foreach (OpenGraphData::$metaEditableKeys as $type => $values) {
            $form->addFieldsetOpen($type);
            foreach ($values as $value) {
                $form->addTagOpen('div')->addClass('form-group');
                $metadata = $this->openGraphData->getMetaData();
                $name = $this->openGraphData->getMetaPropertyName($type, $value);
                $form->addTextInput($name, $name)->attr('class', 'form-control')->val($metadata[$name]);
                $form->addTagClose('div');
            }
            $form->addFieldsetClose();
        }
        $form->addButton('submit', $this->getLang('btnSave'))->addClass('btn btn-success');
        echo $form->toHTML();
        $event->preventDefault();
    }

    private function saveMeta(Event $event): void {
        global $INPUT;
        if (!checkSecurityToken()) {
            $event->data = 'show';
            return;
        }
        if ($this->openGraphData->canSaveMeta()) {
            $metadata = [];
            foreach (OpenGraphData::$metaKeys as $type => $values) {
                foreach ($values as $value) {
                    $name = $this->openGraphData->getMetaPropertyName($type, $value);
                    $metadata[$name] = $INPUT->str($name);
                }
            }
            $content = json_encode($metadata);
            $metaFile = $this->openGraphData->getMetaFile();
            io_saveFile($metaFile, $content);
            msg('Metadata saved', 1);
            $event->data = 'show';
        }
    }

    public function renderMeta(Event $event): void {
        global $ID;
        // add FB_APP_ID
        // $event->data['meta'][] = ['property' => 'fb:app_id', 'content' => $this->getConf('fb_app_id')];

        $metaData = $this->openGraphData->getMetaData();
        $storeMetaData = $this->openGraphData->readMetaStorage();
        $data = array_merge($metaData, $storeMetaData);

        foreach (OpenGraphData::$metaKeys as $type => $values) {
            foreach ($values as $value) {
                $name = $this->openGraphData->getMetaPropertyName($type, $value);

                if ($data[$name]) {
                    $event->data['meta'][] = ['property' => $name, 'content' => $data[$name]];
                    continue;
                }
                switch ($name) {
                    case 'og:url':
                        $event->data['meta'][] = ['property' => $name, 'content' => wl($ID, null, true, '&')];
                        break;
                    case 'og:title':
                        $event->data['meta'][] = ['property' => $name, 'content' => p_get_first_heading($ID)];
                        break;
                    case 'og:site_name':
                        $event->data['meta'][] = ['property' => $name, 'content' => 'FYKOS'];
                        break;
                    case 'og:type':
                        $event->data['meta'][] = ['property' => $name, 'content' => 'website'];
                        break;
                    default :
                        break;
                }
            }
        }
    }
}
