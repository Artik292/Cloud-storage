<?php

$vir->set(function($vir) use($db,$blobClient,$folder,$app,$is_admin){

    $file = new File($db);
    $file->load($_SESSION['file_id']);

    $columns = $vir->add('Columns');
    $col_0 = $columns->addColumn(15);   // VISUAL FIX
    $col_1 = $columns->addColumn(1);    // VISUAL FIX

    if ($file['MetaIsImage']) {
        $file_image = $file['Icon'];
              if (($_SESSION['user_id'] == $folder['account_id']) OR ($is_admin)) {
                $col_0->add(['Button','Set as folder image','blue','icon'=>'plus'])->on('click', function() use($file,$db) {
                  $folder = new Folder($db);
                  $folder->load($_SESSION['folder_id']);
                  $folder['Image'] = $file['Link'];
                  $folder->save();
                  return new \atk4\ui\jsToast(['title'   => 'Success','message' => 'Successfully completed!','class'   => 'success',]);
                });
        }
    } else {
        $file_image = $file['Icon'];
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

    /**
      VISUAL PART
    **/

    $vir->add(['Image',$file_image,'medium centered']);
    $vir->add(['Header',$file['MetaName'],'big centered']);
    $vir->add(['ui'=>'divider']);

    $columns = $vir->add('Columns');
    $col_0 = $columns->addColumn(5);
    $col_1 = $columns->addColumn(7);
    $col_2 = $columns->addColumn(4);

    /**
      DOWNLOAD AND DELETE FILE
    **/

    $col_0->add(['Button','Download','big green','iconRight'=>'download'])->link($file['Link']);

    if (($_SESSION['user_id'] == $folder['account_id']) OR ($is_admin)) {
            if ($file['MetaIsImage']) {
                $delete_name = 'Delete image';
            } else {
                $delete_name = 'Delete file';
            }
            require 'virtual_page/check_delete_file.php';
            $col_2->add(['Button',$delete_name,'red','icon'=>'trash alternate'])->on('click', new \atk4\ui\jsModal('Are you sure?',$new_vir));
    }

    return 1;
});
