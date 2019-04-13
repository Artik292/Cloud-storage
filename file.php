<?php

require 'connection.php';

$app = new \atk4\ui\App('Main Page');
$app->initLayout('Centered');

/*if (isset($_SESSION['BreadCrumb'])) {
  if ((end($_SESSION['BreadCrumb'])) !== $_SESSION['folder_id']) {  //BECAUSE OF JS VIRTUAL PAGE (IT RESTART ALL PAGE)
   array_push($_SESSION['BreadCrumb'],$_SESSION['folder_id']);
 }
} */

//var_dump($_SESSION['BreadCrumb']);

$columns = $app->add('Columns');
$col_1 = $columns->addColumn(8);
$col_2 = $columns->addColumn(8);

$folder = new Folder($db);
$folder->load($_SESSION['folder_id']);
$folder_has_file = $folder->ref('File');

$col_1->add(['Button','Back','inverted blue','icon'=>'arrow alternate circle left'])->link(['back']);
$col_1->add(['ui'=>'hidden divider']);


/**

 ADD FILE AND ADD FOLDER

**/
// FILE //
if (($_SESSION['user_id'] == $folder['account_id']) OR ($is_admin)) {
$add_file_button = $col_2->add(['Button','Add file','inverted green','icon'=>'plus']);
$model = new File($db);
require 'virtual_page/add_file.php';

$add_file_button->on('click', new \atk4\ui\jsModal('New File',$vir));  //$vir is from virtual_page/add_file.php

// FOLDER //
  $model = new Folder($db);

  require 'virtual_page/add_sub_folder.php';

  $add_folder_button = $col_2->add(['Button','Add folder','inverted yellow','icon'=>'folder']);

  $add_folder_button->on('click', new \atk4\ui\jsModal('New Folder',$vir)); //$vir is from virtual_page/add_sub_folder.php
}

/**

VirtualPage FOR File

**/

$vir = $app->add('VirtualPage');
require 'virtual_page/file_show.php';
/**

  DECOR for folders

**/

$sub_folder = $folder->ref('SubFolder');

foreach ($sub_folder as $sub_fold) {
  $app->add(['Header','Folders']);
  $app->add(['ui'=>'divider']);
  break;
}

if (empty($sub_folder)) {
  $app->add(['Header','Folders']);
  $app->add(['ui'=>'divider']);
}


$app->add(['ui'=>'hidden divider']);

$columns = $app->add('Columns');

$col_1 = $columns->addColumn(4);
$col_2 = $columns->addColumn(4);
$col_3 = $columns->addColumn(4);
$col_4 = $columns->addColumn(4);

/**

  Adding Folders

**/

$i = 1;

foreach ($sub_folder as $sub_fold) {
    $fold = new Folder($db);
    $fold->load($sub_fold['child_folder_id']);

    if (!($fold['Image'] == NULL)) {
      $folder_icon = $fold['Image'];
    } else {
      $folder_icon = 'src/folder.png';
    }

    $id = $fold->id;

    $link = '"re.php?mn='.$id.'"';
    $link = 'document.location='.$link;

    switch ($i) {
        case 1:
              $col_1->add(['Image',$folder_icon,'big'])->on('click', new \atk4\ui\jsExpression($link));
              $col_1->add(['Header',$fold['name'],'centered']);
              $i++;
              break;
        case 2:
              $col_2->add(['Image',$folder_icon,'big'])->on('click', new \atk4\ui\jsExpression($link));
              $col_2->add(['Header',$fold['name'],'centered']);
              $i++;
              break;
        case 3:
              $col_3->add(['Image',$folder_icon,'big'])->on('click', new \atk4\ui\jsExpression($link));
              $col_3->add(['Header',$fold['name'],'centered']);
              $i++;
              break;
        case 4:
              $col_4->add(['Image',$folder_icon,'big'])->on('click', new \atk4\ui\jsExpression($link));
              $col_4->add(['Header',$fold['name'],'centered']);
              $i=1;
              $col_1->add(['ui'=>'hidden divider']);
              $col_2->add(['ui'=>'hidden divider']);
              $col_3->add(['ui'=>'hidden divider']);
              $col_4->add(['ui'=>'hidden divider']);
              break;
    }
}

/**

  DECOR for files

**/

$files = $folder->ref('File');
foreach ($files as $file) {
  $app->add(['Header','Files','H1']);
  $app->add(['ui'=>'divider']);
  break;
}

$columns = $app->add('Columns');

$col_1 = $columns->addColumn(4);
$col_2 = $columns->addColumn(4);
$col_3 = $columns->addColumn(4);
$col_4 = $columns->addColumn(4);


$i = 1;

/**

  Adding files

**/

foreach ($files as $file) {
    if ($file['MetaIsImage']) {
      $file_image = $file['Link'];
    } else {
      $file_image = 'src/no_image.png';
    }

    switch ($i) {
        case 1:
              $im = $col_1->add(['Image',$file_image,'big'])->on('click', function () use ($file,$vir) {
              $_SESSION['file_id'] = $file->id;
              return new \atk4\ui\jsModal('Image',$vir);
              });
              $col_1->add(['Header',$file['MetaName'],'center aligned']);
              $i++;
              break;
        case 2:
              $im = $col_2->add(['Image',$file_image,'big'])->on('click', function () use ($file,$vir) {
              $_SESSION['file_id'] = $file->id;
              return new \atk4\ui\jsModal('Image',$vir);
              });
              $col_2->add(['Header',$file['MetaName'],'center aligned']);
              $i++;
              break;
        case 3:
              $col_3->add(['Image',$file_image,'big'])->on('click', function () use ($file,$vir) {
              $_SESSION['file_id'] = $file->id;
              return new \atk4\ui\jsModal('Image',$vir);
              });
              $col_3->add(['Header',$file['MetaName'],'center aligned']);
              $i++;
              break;
        case 4:
              $col_4->add(['Image',$file_image,'big'])->on('click', function () use ($file,$vir) {
              $_SESSION['file_id'] = $file->id;
              return new \atk4\ui\jsModal('Image',$vir);
              });
              $col_4->add(['Header',$file['MetaName'],'center aligned']);
              $i=1;
              $col_1->add(['ui'=>'hidden divider']);
              $col_2->add(['ui'=>'hidden divider']);
              $col_3->add(['ui'=>'hidden divider']);
              $col_4->add(['ui'=>'hidden divider']);
              break;
}
}

if (($_SESSION['user_id'] == $folder['account_id']) OR ($is_admin)) {

$app->add(['ui'=>'divider']);

require 'virtual_page/check_delete_folder.php';

$delete_folder_button = $app->add(['Button','Delete folder','inverted red','icon'=>'trash']);
$delete_folder_button->on('click', new \atk4\ui\jsModal('Are you sure?',$vir));
}
