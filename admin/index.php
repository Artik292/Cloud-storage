<?php

require 'admin_connection.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.3)');
$app->initLayout('Admin');

require 'layout.php';

$CRUD = $app->add(['CRUD']);
$CRUD->setModel(new Account($db));
$CRUD->addQuickSearch(['name']);
$CRUD->addDecorator('name', new \atk4\ui\TableColumn\Link('re.php?id={$id}&way=folders'));
