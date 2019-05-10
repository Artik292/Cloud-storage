<?php

require 'admin_connection.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.3)');
$app->initLayout('Admin');

require 'layout.php';

if (isset($_SESSION['folder_id'])) {
  $folder = new Folder($db);
  $folder->load($_SESSION['folder_id']);
  $file = $folder->ref('File');
  $file->setOrder('DateCreated',true);
  $CRUD = $app->add(['CRUD']);
  $CRUD->setModel($file);
  $CRUD->addQuickSearch(['MetaName','MetaType','ContainerName']);

  unset($_SESSION['folder_id']);
} else {

  $file = new File($db);
  $file->setOrder('DateCreated',true);

  $CRUD = $app->add(['CRUD']);
  $CRUD->setModel($file);
  $CRUD->addQuickSearch(['MetaName','MetaType','ContainerName']);
}
