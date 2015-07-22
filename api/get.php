<?php

require 'model/file.php';
require 'data-access/db.php';
require 'data-access/sql.php';
require 'output/json.php';

<<<<<<< HEAD
$cmd = $_GET['cmd'];
//$fileId = $_GET['id'];
=======
$action = isset($_GET['action']) ? $_GET['action'] : '';
$fileId = isset($_GET['id']) ? $_GET['id'] : '';
>>>>>>> origin/master

$sql = new SqlDataAccess();

switch ($cmd) {

    case "all":
        JsonUtils::echoArray($sql->getAllFiles());
        break;

    case "last":
        JsonUtils::echoFile($sql->getLastFile());
        break;

    case "byId":
        JsonUtils::echoFile($sql->getFileById($fileId));
        break;

    //case "search":
        //JsonUtils::echoArray($sql->getFiles());
        //break;

    default:
        JsonUtils::echoError("Command not understood");
        break;
}
<<<<<<< HEAD
=======

// Lazy is sexy.
>>>>>>> origin/master
