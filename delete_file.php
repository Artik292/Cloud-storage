<?php

require 'connection.php';

$file = new File($db);
$file->load($_SESSION['file_id']);

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

unset($_SESSION['file_id']);


header('Location: file.php');
