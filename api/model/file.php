<?php

class File {

    public $id;
    public $name;
    public $version;
    public $hash;
    public $notes;
    public $directory;
    public $dateSubmitted;

    function __construct($id, $name, $date, $version, $hash, $note, $dir) {
        $this->id = $id;
        $this->name = $name;
        $this->version = $version;
        $this->dateSubmitted = $date;
        $this->hash = $hash;
        $this->notes = $note;
        $this->directory = $dir;
    }

    function toAssocArray() {

        $assocArray = array();

        $assocArray['id'] = $this->id;
        $assocArray['name'] = $this->name;
        $assocArray['version'] = $this->version;
        $assocArray['date_submitted'] = $this->dateSubmitted;
        $assocArray['hash'] = $this->hash;
        $assocArray['notes'] = $this->notes;
        $assocArray['download_link'] = $this->getDownloadLink();

        return $assocArray;
    }

    public function getDownloadLink() {
        return $this->getFileUrl($this->directory);
    }

    private function getFileUrl($dir){
        return sprintf("%s://%s%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['HTTP_HOST'],
            dirname($_SERVER['REQUEST_URI']), $dir);
    }
}