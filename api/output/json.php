<?php

class JsonUtils {

    public static function echoError($msg) {
        echo json_encode(array('message' => $msg), JSON_PRETTY_PRINT);
    }

    public static function echoFile(File $file = null) {

        if ($file == null)
            self::echoError("File not found");
        else
            self::echoArray($file->toAssocArray());
    }

    public static function echoArray($arr){
        echo json_encode($arr, JSON_PRETTY_PRINT);
    }

    public static function echoUploadResponse($msg, $downloadLink = null) {
        echo json_encode(array(
            'message' => $msg,
            'download_link' => $downloadLink
        ), JSON_PRETTY_PRINT);
    }
}