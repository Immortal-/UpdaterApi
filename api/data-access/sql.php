<?php

class SqlDataAccess {

    private $con;

    public function __construct(){
        $this->con = Database::getInstance();

        $this->createTable();
    }

    private function createTable() {

        $query =  "CREATE TABLE IF NOT EXISTS `tblFiles`(
                  `Id` INT NOT NULL AUTO_INCREMENT ,
                  `Name` VARCHAR(40) NOT NULL ,
                  `Version` VARCHAR(15) NOT NULL ,
                  `DateSubmitted` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
                  `Hash` VARCHAR(50) NOT NULL ,
                  `Directory` VARCHAR(40) NOT NULL ,
                  `Notes` TEXT NULL ,
                   PRIMARY KEY (`Id`)) ENGINE = InnoDB;";

        return $this->con->prepare($query)->execute();
    }

    public function addFile(File $file) {

        $query = "INSERT INTO tblFiles (Name, Version, Hash, Notes, Directory)
              VALUES (:name, :version, :hash, :notes, :dir)";

        $stmt = $this->con->prepare($query);

        $stmt->bindValue(':name', $file->name, PDO::PARAM_STR);
        $stmt->bindValue(':version', $file->version, PDO::PARAM_STR);
        $stmt->bindValue(':hash', $file->hash, PDO::PARAM_STR);
        $stmt->bindValue(':notes', $file->notes, PDO::PARAM_STR);
        $stmt->bindValue(':dir', $file->directory, PDO::PARAM_STR);

        return $stmt->execute() && $stmt->rowCount() == 1;
    }

    public function getLastFile() {

        $stmt = $this->con->prepare("SELECT * FROM tblFiles ORDER BY DateSubmitted DESC LIMIT 1");

        //I could of returned the variable $r directly but it would fail the consistent layout
        //of the entire project

        if ($stmt->execute() && $stmt->rowCount() == 1) {
            $r = $stmt->fetch(PDO::FETCH_ASSOC);

            return new File(intval($r['Id']), $r['Name'], $r['DateSubmitted'],
                $r['Version'] , $r['Hash'], $r['Notes'], $r['Directory']);
        }

        return null;
    }

    public function getAllFiles() {

        $stmt = $this->con->prepare("SELECT * FROM tblFiles");

        if ($stmt->execute() && $stmt->rowCount() > 0) {

            $files = array();

            while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {

                //I could of added the variable $r directly but it would fail the consistent layout
                //of the entire project

                $file = new File(intval($r['Id']), $r['Name'], $r['DateSubmitted'],
                    $r['Version'] , $r['Hash'], $r['Notes'], $r['Directory']);

                $files[] = $file->toAssocArray();
            }

            return $files;
        }

        return null;
    }

    public function deleteFile($fileId) {
        return null;
    }

    public function getFileById($fileId) {

        $stmt = $this->con->prepare("SELECT * FROM tblFiles WHERE Id = :id");

        $stmt->bindValue(':id', $fileId, PDO::PARAM_INT);

        if ($stmt->execute() && $stmt->rowCount() == 1) {
            $r = $stmt->fetch(PDO::FETCH_ASSOC);

            return new File(intval($r['Id']), $r['Name'], $r['DateSubmitted'],
                $r['Version'] , $r['Hash'], $r['Notes'], $r['Directory']);
        }

        return null;
    }

    public function getFilesByX($X) {
        return null;
    }
}