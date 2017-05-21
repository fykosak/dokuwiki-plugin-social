<?php

/**
 * Description of sction
 *
 * @author Miso <miso@fykos.cz>
 */
class helper_plugin_social_meta extends DokuWiki_Plugin {

    private $metadata;
    public $helper;
    public static $FBmeta = array(/* 'url','locale', */
                                  'title',
                                  'description',
                                  'site_name',
                                  'image',
                                  'type'
    );
    public static $metaKeys = [
        'og' => [
            'url',
            'title',
            'description',
            'site_name',
            'image',
            'type',
            'locale',
        ]
    ];
    public static $metaEditableKeys = [
        'og' => [
            'title',
            'description',
            'site_name',
            'image',
            'type',
            'locale',
        ]
    ];

    public function __construct() {
        $this->metadata = [];
    }

    public function readMetaStorage() {
        return $this->metadata;
    }

    public function addMetaData($type, $key, $value) {
        $name = $this->getMetaPropertyName($type, $key);
        $this->metadata[$name] = $value;
        return true;
    }

    public function canSaveMeta() {
        global $ID;
        return (auth_quickaclcheck($ID) >= AUTH_EDIT);
    }

    public function getMetaFile() {
        global $ID;
        return metaFN($ID, '.meta.social');
    }

    public function getMetaData() {
        $metaFile = $this->getMetaFile();
        $metaData = $this->readMeta($metaFile);
        return (array)$metaData;
    }

    public function readMeta($metaFile) {
        $content = io_readFile($metaFile);
        return (array)json_decode($content);
    }

    public function getMetaPropertyName($type, $value) {
        return $type . ':' . $value;
    }

}
