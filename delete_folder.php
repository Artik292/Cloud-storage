<?php

require 'connection.php';

$folder = new Folder($db);
$folder->load($_SESSION['folder_id']);


$_SESSION['db'] = $db;
$_SESSION['blobClient'] = $blobClient;

function FolderDelete ($folder) {
  $sub_folder = $folder->ref('SubFolder');
  if ($sub_folder !== NULL) {
      foreach ($sub_folder as $sub_fold) {
          $now_delete_sub_folder = new Folder($_SESSION['db']);
          $now_delete_sub_folder->load($sub_fold['child_folder_id']);
          FolderDelete($now_delete_sub_folder);
      }
  }


  $files = $folder->ref('File');

  foreach ($files as $file) {

    try{
          // Delete container.
          $_SESSION['blobClient']->deleteContainer($file["ContainerName"]);
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

  if ($folder['Is_SubFolder']) {
    $sub_folder = new SubFolder($_SESSION['db']);
    $sub_folder->loadBy('child_folder_id',$folder->id);
    $sub_folder->delete();
  }

  $folder->delete();

  return true;
}

  FolderDelete($folder);

header('Location: index.php');
