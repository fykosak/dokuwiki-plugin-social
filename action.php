<?php

/**
 * Description of sction
 *
 * @author Miso <miso@fykos.cz>
 */
class action_plugin_social extends DokuWiki_Action_Plugin {

    private $helper;

    public function __construct() {
        $this->helper = $this->loadHelper('social');
    }

    public function register(Doku_Event_Handler $controller) {

        $controller->register_hook('TPL_METAHEADER_OUTPUT','BEFORE',$this,'RenderMeta');
        $controller->register_hook('TPL_ACT_UNKNOWN','BEFORE',$this,'tplMetaDataForm');
        $controller->register_hook('TPL_ACT_RENDER','BEFORE',$this,'tplMetaDataButton');
        $controller->register_hook('ACTION_ACT_PREPROCESS','BEFORE',$this,'ActPreprocessMeta');
        //$controller-
    }

    public function ActPreprocessMeta(Doku_Event &$event) {
        $act = $event->data;
       
        if(!$this->helper->meta->CanSaveMeta()){
            return;
        }
        switch ($act) {
            case 'social_form':
                break;
            case 'social_save':
                $this->SaveMeta($event);
                break;
            default: return;
        }
        $event->preventDefault();
        $event->stopPropagation();
    }

    public function tplMetaDataButton(Doku_Event &$event) {
        global $ID;
       
        if($this->helper->meta->CanSaveMeta()){

            $form = new Doku_Form(array());
            $form->addHidden('id',$ID);
            $form->addHidden('do','social_form');
            $form->addElement(form_makeButton('submit',null,$this->getLang('Plugin_social').'Plugin_social'));
            html_form('',$form);
        }else{

            return;
        }
    }

   

    public function tplMetaDataForm(Doku_Event &$event) {
    
        global $ID;
        echo '<div class="plugin_social">';
        echo '<div class="form" id="pluginsocialform" >';
        $form = new Doku_Form(array());
        $form->addHidden('target','plugin_social');
        $form->addHidden('id',$ID);
        $form->addHidden('do','social_save');
        foreach (helper_plugin_social_meta::$metaEditableKeys as $type => $values) {
            $form->addElement('<div>');
            $form->startFieldset($type);
            foreach ($values as $value) {
                $metadata = $this->helper->meta->getMetaData();
                $name = $this->helper->meta->getMetaPropertyName($type,$value);
                $form->addElement(form_makeTextField($name,$metadata[$name],$type.':'.$value,null,'block'));
            }
            $form->endFieldset();

            $form->addElement('</div>');
        }

        $form->addElement(form_makeButton('submit',null,$this->getLang('send').'SEND'));
        html_form('',$form);
        echo '</div>';
        echo '</div>';
        $event->preventDefault();
    }

    public function SaveMeta($event) {
        global $INPUT;
        if(!checkSecurityToken()){
            $event->data = 'show';
            return;
        }

        if($this->helper->meta->CanSaveMeta()){

            $metadata = array();

            foreach (helper_plugin_social_meta::$metaKeys as $type => $values) {
                foreach ($values as $value) {
                    $name = $this->helper->meta->getMetaPropertyName($type,$value);
                    $metadata[$name] = $INPUT->str($name);
                }
            }
            $json = new JSON;
            $c = $json->encode($metadata);


            $metafile = $this->helper->meta->GetMetaFile();
            io_saveFile($metafile,$c);
            msg('Metadata saved',1);
            $event->data = 'show';
        }
    }

    public function RenderMeta(Doku_Event &$event) {

        $metadata = $this->helper->meta->getMetaData();
        $storemetadata = $this->helper->meta->ReadMetaStorage();

        foreach (helper_plugin_social_meta::$metaKeys as $type => $values) {
            foreach ($values as $value) {
                $name = $this->helper->meta->getMetaPropertyName($type,$value);

                if($storemetadata[$name] != null){
                    $event->data['meta'][] = array('property' => $name,'content' => $storemetadata[$name]);
                    continue;
                }

                if($metadata[$name] != null){
                    $event->data['meta'][] = array('property' => $name,'content' => $metadata[$name]);
                    continue;
                }
                $event->data['meta'][] = array('property' => $name,'content' => $this->getConf($name));
            }
        }
    }

}
