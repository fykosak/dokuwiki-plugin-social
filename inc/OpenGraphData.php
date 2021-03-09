<?php

namespace FYKOS\dokuwiki\Extension\PluginSocial;
/**
 * Class OpenGraphData
 * @author Michal Červeňák <miso@fykos.cz>
 */
class OpenGraphData {

    private $metadata;

    public static $FBmeta = [/* 'url','locale', */
        'title',
        'description',
        'site_name',
        'image',
        'type',
    ];
    public static $metaKeys = [
        'og' => [
            'url',
            'title',
            'description',
            'site_name',
            'image',
            'type',
            'locale',
        ],
    ];
    public static $metaEditableKeys = [
        'og' => [
            'title',
            'description',
            'site_name',
            'image',
            'type',
            'locale',
        ],
    ];

    public function __construct() {
        $this->metadata = [];
    }

    public function readMetaStorage(): array {
        return $this->metadata;
    }

    public function addMetaData(string $type, string $key, ?string $value): bool {
        $name = $this->getMetaPropertyName($type, $key);
        $this->metadata[$name] = $value;
        return true;
    }

    public function canSaveMeta(): bool {
        global $ID;
        return (auth_quickaclcheck($ID) >= AUTH_EDIT);
    }

    public function getMetaFile(): string {
        global $ID;
        return metaFN($ID, '.meta.social');
    }

    public function getMetaData(): array {
        $metaFile = $this->getMetaFile();
        $metaData = $this->readMeta($metaFile);
        return (array)$metaData;
    }

    public function getMetaPropertyName(string $type, string $value): string {
        return $type . ':' . $value;
    }

    private function readMeta(string $metaFile): array {
        $content = io_readFile($metaFile);
        return (array)json_decode($content);
    }
}
