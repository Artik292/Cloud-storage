 <?php

require 'admin_connection.php';
//require '../vendor/autoload.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.2)');
$app->initLayout('Admin');

$CRUD = $app->add(['CRUD']);
$CRUD->setModel(new Account($db));
$CRUD->addQuickSearch(['name']);

$CRUD = $app->add(['CRUD']);
$CRUD->setModel(new Folder($db));
$CRUD->addQuickSearch(['name']);

$CRUD = $app->add(['CRUD']);
$CRUD->setModel(new File($db));
$CRUD->addQuickSearch(['name']);
