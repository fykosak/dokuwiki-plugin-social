<?php

use \dokuwiki\Form\Form;
use \PluginSocial\Meta;

class action_plugin_social extends DokuWiki_Action_Plugin {
    /**
     * @var helper_plugin_social
     */
    private $helper;

    public function __construct() {
        $this->helper = $this->loadHelper('social');
    }

    public function register(Doku_Event_Handler $controller) {
        $controller->register_hook('DOKUWIKI_STARTED', 'AFTER', $this, 'addFBAppID');
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'renderMeta');
        $controller->register_hook('TPL_ACT_UNKNOWN', 'BEFORE', $this, 'tplMetaDataForm');
        $controller->register_hook('ACTION_ACT_PREPROCESS', 'BEFORE', $this, 'actPreprocessMeta');
        $controller->register_hook('TEMPLATE_PAGETOOLS_DISPLAY', 'BEFORE', $this, 'tplMetaDataMenuButton');
    }

    public function addFBAppID() {
        global $JSINFO;
        $JSINFO['FBAppID'] = $this->getConf('fb_app_id');
    }

    public function actPreprocessMeta(Doku_Event &$event) {
        global $INPUT;
        $act = $event->data;

        if (!$this->helper->meta->canSaveMeta()) {
            return;
        }
        if ($act !== 'social') {
            return;
        }
        $event->preventDefault();
        $event->stopPropagation();

        switch ($INPUT->param('social')['do']) {
            case 'save':
                $this->saveMeta($event);
                break;
            case 'edit':
            default:
                return;
        }
    }

    public function tplMetaDataMenuButton(Doku_Event &$event) {
        global $ID;
        if ($this->helper->meta->canSaveMeta()) {
            $event->data['items']['social_form'] = '<a class="dropdown-item" href="' .
                wl($ID, ['do' => 'social', 'social[do]' => 'edit']) . '" >
                    ' . $this->getLang('Plugin_social') . '</a>';
        }
    }

    public function tplMetaDataForm(Doku_Event &$event) {
        if ($event->data != 'social') {
            return;
        }

        global $INPUT;
        if ($INPUT->param('social')['do'] !== 'edit') {
            return;
        }
        global $ID;
        $form = new Form();
        $form->setHiddenField('target', 'plugin_social');
        $form->setHiddenField('id', $ID);
        $form->setHiddenField('do', 'social');
        $form->setHiddenField('social[do]', 'save');

        foreach (Meta::$metaEditableKeys as $type => $values) {
            $form->addFieldsetOpen($type);
            foreach ($values as $value) {
                $form->addTagOpen('div')->addClass('form-group');
                $metadata = $this->helper->meta->getMetaData();
                $name = $this->helper->meta->getMetaPropertyName($type, $value);
                $form->addTextInput($name, $name)->attr('class', 'form-control')->val($metadata[$name]);
                $form->addTagClose('div');
            }
            $form->addFieldsetClose();
        }
        $form->addButton('submit', $this->getLang('btnSave'))->addClass('btn btn-success');
        echo $form->toHTML();
        $event->preventDefault();
    }

    private function saveMeta($event) {
        global $INPUT;
        if (!checkSecurityToken()) {
            $event->data = 'show';
            return;
        }
        if ($this->helper->meta->canSaveMeta()) {
            $metadata = [];
            foreach (Meta::$metaKeys as $type => $values) {
                foreach ($values as $value) {
                    $name = $this->helper->meta->getMetaPropertyName($type, $value);
                    $metadata[$name] = $INPUT->str($name);
                }
            }
            $json = new JSON;
            $content = $json->encode($metadata);
            $metaFile = $this->helper->meta->getMetaFile();
            io_saveFile($metaFile, $content);
            msg('Metadata saved', 1);
            $event->data = 'show';
        }
    }

    public function renderMeta(Doku_Event &$event) {
        global $ID;
        // add FB_APP_ID
        $event->data['meta'][] = ['property' => 'fb:app_id', 'content' => $this->getConf('fb_app_id')];

        $metaData = $this->helper->meta->getMetaData();
        $storeMetaData = $this->helper->meta->readMetaStorage();
        $data = array_merge($metaData, $storeMetaData);

        foreach (Meta::$metaKeys as $type => $values) {
            foreach ($values as $value) {
                $name = $this->helper->meta->getMetaPropertyName($type, $value);

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
