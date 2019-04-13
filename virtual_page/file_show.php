<?php

$vir->set(function($vir) use($db,$blobClient,$folder,$app,$is_admin){

    $file = new File($db);
    $file->load($_SESSION['file_id']);
    if ($file['MetaIsImage']) {
        $file_image = $file['Link'];
                $col_0->add(['Button','Set as folder image','blue','icon'=>'plus'])->on('click', function() use($file,$db) {
                  $folder = new Folder($db);
                  $folder->load($_SESSION['folder_id']);
                  $folder['Image'] = "https://artik292.blob.core.windows.net/".$file['ContainerName']."/".$file['MetaName'];
                  $folder->save();
                  return new \atk4\ui\jsToast(['title'   => 'Success','message' => 'Successfully completed!','class'   => 'success',]);
                });
        }
    } else {
        $file_image = 'src/no_image.png';
    }

    /**

      RENAME File

    **/
    require 'file_rename.php';
    $col_1->add(['Button', null, 'circular blue', 'icon'=>'edit'])->on('click', function () use ($file,$virtual) {
    $_SESSION['file_id'] = $file->id;  //JUST FOR EASY READING
    $_SESSION['file_name'] = $file['MetaName'];
    return new \atk4\ui\jsModal('Rename',$virtual);
    });
    $vir->add(['Image',$file_image,'medium centered']);
    $vir->add(['Header',$file['MetaName'],'big centered']);
    $vir->add(['ui'=>'divider']);

    if (($_SESSION['user_id'] == $folder['account_id']) OR ($is_admin)) {
            if ($file['MetaIsImage']) {
                $delete_name = 'Delete image';
            } else {
                $delete_name = 'Delete file';
            }
            require 'virtual_page/check_delete_file.php';
            $vir->add(['Button',$delete_name,'red','icon'=>'trash alternate'])->on('click', new \atk4\ui\jsModal('Are you sure?',$new_vir));
    }

    return 1;
});
