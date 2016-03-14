<?php

/**
 * Description of sction
 *
 * @author Miso <miso@fykos.cz>
 */
class helper_plugin_social_meta extends DokuWiki_Plugin {

    private $metadata;
    public $helper;
    public static $FBmeta = array(/* 'url', */'title','description','site_name','image','type','locale');
    public static $metaKeys = array('og' => array('url','title','description','site_name','image','type','locale'));
    public static $metaEditableKeys =array('og' => array('title','description','site_name','image','type','locale'));

    public function __construct() {

        $this->metadata = array();
    }

    public function ReadMetaStorage() {
        return $this->metadata;
    }

    public function AddMetaData($type,$key,$value) {
        $name = $this->getMetaPropertyName($type,$key);
        $this->metadata[$name] = $value;
        return true;
    }

    public function CanSaveMeta() {
        global $ID;
        return (auth_quickaclcheck($ID) >= AUTH_EDIT);
    }

    public function GetMetaFile() {
        global $ID;
        return metaFN($ID,'.meta.social');
    }

    public function GetMetaData() {
        $metafile = $this->GetMetaFile();
        $metadata = $this->ReadMeta($metafile);

        return (array) $metadata;
    }

    public function ReadMeta($metafile) {
        $c = io_readFile($metafile);
        $metadata = (array) json_decode($c);

        return $metadata;
    }

    public function getMetaPropertyName($type,$value) {
        return $type.':'.$value;
    }

}
