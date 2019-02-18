<?php

require 'connection.php';

$folder = new Folder($db);
$folder->load($_SESSION['folder_id']);

$files = $folder->ref('File');

foreach ($files as $file) {

  try{
        // Delete container.
        $blobClient->deleteContainer($file["ContainerName"]);
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        new atk4\ui\jsNotify(['content' => $code.": ".$error_message, 'color' => 'red']);
    }

  $file->delete();
}

$folder->delete();

unset($_SESSION['folder_id']);


header('Location: index.php');
