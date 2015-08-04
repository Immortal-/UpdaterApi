<?php

class FileUploader {

    public function getErrorMsg($file , $folder) {

        if (! isset($file))
            return "File is empty";

        if (! $this->isFileOk($file))
            return "There was an error in the file you sent";

        if (! $this->isValidExt($file))
            return "Invalid file type";

        if (! $this->isSizeOk($file))
            return "File size too big";

        if (! $this->isValidKey(""))
            return "You're not authorized access";

        if (! $this->isValidDir($folder))
            return "A valid directory could not be established";

        return null;
    }

    public function saveFile($file, $dir) {

        $tempFile = $file['tmp_name'];
        $name = $file['name'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);

        $newName = sprintf("%s.%s", hash('crc32b', date("Y-m-d H:i:s")), $ext);
        $filePath = sprintf("%s/%s", $dir , $newName);

        if (move_uploaded_file($tempFile, $filePath)) {

            $file = new File(0, $name, '', $file['file_version'],
                sha1_file($filePath), $file['notes'], '/' . $filePath);

            return (new SqlDataAccess())->addFile($file) ? $file : null;
        }

        return null;
    }

    private function isValidDir($directory) {
        //It creates a directory if doesn't exist
        return file_exists($directory) ? true : mkdir($directory, 0777, true);
    }

    private function isSizeOk($file) {
        return $file['size'] < 500000;
    }

    private function isValidExt($file) {

        $validExts = array ('exe', 'jar');
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);

        return in_array($fileExt , $validExts);
    }

    private function isFileOk($file) {
        return $file['error'] == UPLOAD_ERR_OK;
    }

    private function isValidKey($key) {
        //TODO - This is key is required to do eveyrthing other than getting the latest update file

        return true;
    }
}
