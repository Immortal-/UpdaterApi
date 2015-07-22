<?php

require 'model/file.php';
require 'data-access/sql.php';
require 'data-access/db.php';
require 'data-access/uploader.php';
require 'output/json.php';

$file = $_FILES['file'];

$uploader = new FileUploader();

<<<<<<< HEAD
$errorMsg = $uploader->getErrorMsg($file, $folder);
=======
//Checks the file and returns an error message if any in a string
$errorMsg = $uploader->getErrorMsg($file, 'uploads');
>>>>>>> origin/master

if ($errorMsg == null) {

    $file['file_version'] = $_POST['fileVersion'];
    $file['notes'] = $_POST['notes'];

<<<<<<< HEAD
    $file = $uploader->saveFile($file, $folder);
=======
    $file = $uploader->saveFile($file, 'uploads');
>>>>>>> origin/master

    if ($file != null)
        JsonUtils::echoUploadResponse("Success", $file->getDownloadLink());
    else
<<<<<<< HEAD
        JsonUtils::echoUploadResponse("An error ocurred whilst saving your file");

} else {
    JsonUtils::echoUploadResponse($errorMsg);
}
=======
        JsonUtils::echoUploadResponse("An error ocurred whilst saving your file.");

} else {
    JsonUtils::echoUploadResponse($errorMsg);
}
>>>>>>> origin/master
