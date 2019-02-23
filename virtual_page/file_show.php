<?php

$vir->set(function($vir) use($db,$blobClient,$folder){

    $file = new File($db);
    $file->load($_SESSION['file_id']);
    if ($file['MetaIsImage']) {
        $file_image = "https://artik292.blob.core.windows.net/".$file['ContainerName']."/".$file['MetaName'];
        $vir->add(['Button','Set as folder image','blue','icon'=>'plus'])->on('click', function() use($file,$db) {
          $folder = new Folder($db);
          $folder->load($_SESSION['folder_id']);
          $folder['Image'] = "https://artik292.blob.core.windows.net/".$file['ContainerName']."/".$file['MetaName'];
          $folder->save();
          return new atk4\ui\jsNotify(['content' => 'Ready', 'color' => 'blue']);
        });
    } else {
        $file_image = 'src/no_image.png';
    }
    $vir->add(['Image',$file_image,'medium centered']);
    $vir->add(['Header',$file['MetaName'],'big centered']);
    $vir->add(['ui'=>'divider']);
    $vir->add(['Button','Download','big green','iconRight'=>'download'])->link("https://artik292.blob.core.windows.net/".$file['ContainerName']."/".$file['MetaName']);

    if ($_SESSION['user_id'] == $folder['account_id']) {
            if ($file['MetaIsImage']) {
                $delete_name = 'Delete image';
            } else {
                $delete_name = 'Delete file';
            }
            $vir->add(['Button',$delete_name,'red','icon'=>'trash alternate'])->on('click', function() use($blobClient,$file) {
              $_SESSION['file_id'] = $file->id;
              //require 'delete_file.php';
              return new \atk4\ui\jsExpression('document.location = "delete_file.php" ');
            });
    }

    return 1;
});
