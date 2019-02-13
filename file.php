<?php

require 'connection.php';



$app = new \atk4\ui\App('Main Page');
$app->initLayout('Centered');

$columns = $app->add('Columns');

$col_1 = $columns->addColumn(8);
$col_2 = $columns->addColumn(8);

$folder = new Folder($db);
$folder->load($_SESSION['folder_id']);

$files = $folder->ref('File');

$col_1->add(['Button','Back','inverted blue','icon'=>'arrow alternate circle left'])->link(['index']);
$col_1->add(['ui'=>'hidden divider']);


/**

 ADD BUTTON

**/

if ($_SESSION['user_id'] == $folder['account_id']) {

$add_file_button = $col_2->add(['Button','Add file','inverted green','icon'=>'plus'])->link(['index']);

$model = new File($db);

require 'AddButton.php';

$add_file_button->on('click', new \atk4\ui\jsModal('New File',$vir));

}

/**

VirtualPage FOR File

**/

$vir = $app->add('VirtualPage');
$vir->set(function($vir) use($db,$blobClient,$folder){

    $file = new File($db);
    $file->load($_SESSION['file_id']);
    if ($file['MetaIsImage']) {
        $file_image = "https://artik292.blob.core.windows.net/".$file['ContainerName']."/".$file['MetaName'];
    } else {
        $file_image = 'no_image.png';
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
              require 'delete.php';
              return new \atk4\ui\jsExpression('document.location = "file.php" ');
            });
    }

    return 1;
});

/**

  DECOR

**/

$app->add(['ui'=>'hidden divider']);

$columns = $app->add('Columns');

$col_1 = $columns->addColumn(4);
$col_2 = $columns->addColumn(4);
$col_3 = $columns->addColumn(4);
$col_4 = $columns->addColumn(4);

$i = 1;

foreach ($files as $file) {
    if ($file['MetaIsImage']) {
      $file_image = "https://artik292.blob.core.windows.net/".$file['ContainerName']."/".$file['MetaName'];
    } else {
      $file_image = 'no_image.png';
    }

    $link = '"re.php?mn='.$file->id.'"';
    $link = 'document.location='.$link;

    switch ($i) {
        case 1:
              $im = $col_1->add(['Image',$file_image,'big'])->on('click', function () use ($file,$vir) {
              $_SESSION['file_id'] = $file->id;
              return new \atk4\ui\jsModal('Image',$vir);
              });
              $i++;
              break;
        case 2:
              $im = $col_2->add(['Image',$file_image,'big'])->on('click', function () use ($file,$vir) {
              $_SESSION['file_id'] = $file->id;
              return new \atk4\ui\jsModal('Image',$vir);
              });
              $i++;
              break;
        case 3:
              $col_3->add(['Image',$file_image,'big'])->on('click', function () use ($file,$vir) {
              $_SESSION['file_id'] = $file->id;
              return new \atk4\ui\jsModal('Image',$vir);
              });
              $i++;
              break;
        case 4:
              $col_4->add(['Image',$file_image,'big'])->on('click', function () use ($file,$vir) {
              $_SESSION['file_id'] = $file->id;
              return new \atk4\ui\jsModal('Image',$vir);
              });
              $i=1;
              $col_1->add(['ui'=>'hidden divider']);
              $col_2->add(['ui'=>'hidden divider']);
              $col_3->add(['ui'=>'hidden divider']);
              $col_4->add(['ui'=>'hidden divider']);
              break;
}
}


if ($_SESSION['user_id'] == $folder['account_id']) {

$app->add(['ui'=>'divider']);

$delete_folder_button = $app->add(['Button','Delete folder','inverted red','icon'=>'trash'])->link(['delete']);

}


/*$blob = $blobClient->getBlob($file['ContainerName'], $file['MetaName']);

$files = ($blobClient->listBlobs($file['ContainerName']));
//$image = $files["0"]["_data:protected"]["url"];
$image = "https://artik292.blob.core.windows.net/".$file['ContainerName']."/".$file['MetaName'];

 if ($file['MetaIsImage']) {
   $app->add(['Image',$image]);
   $app->add(['ui'=>'hidden divider']);
 }

$DownloadFile = $app->add(['Button','Download '.$file['MetaName'],'icon'=>'cloud download','inverted green'])
    ->link($image);

$app->add(['ui'=>'hidden divider']);

$DeleteButton = $app->add(['Button','Delete ','red right ribbon','iconRight'=>'trash']);

$_SESSION['blobClient'] = $blobClient;
$_SESSION['containerName'] = $file['ContainerName'];

$DeleteButton->link(['delete']);*/
