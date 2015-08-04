<?php

require 'model/file.php';
require 'data-access/sql.php';
require 'data-access/db.php';
require 'data-access/uploader.php';
require 'output/json.php';

$file = $_FILES['file'];

$uploader = new FileUploader();

$errorMsg = $uploader->getErrorMsg($file, $folder);
//Checks the file and returns an error message if any in a string
$errorMsg = $uploader->getErrorMsg($file, 'uploads');

if ($errorMsg == null) {

    $file['file_version'] = $_POST['fileVersion'];
    $file['notes'] = $_POST['notes'];

    $file = $uploader->saveFile($file, $folder);
    
    $file = $uploader->saveFile($file, 'uploads');

    if ($file != null)
        JsonUtils::echoUploadResponse("Success", $file->getDownloadLink());
    else
        JsonUtils::echoUploadResponse("An error ocurred whilst saving your file");
        
} else {
    JsonUtils::echoUploadResponse($errorMsg);
}
