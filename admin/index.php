<?php

require 'admin_connection.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.2)');
$app->initLayout('Admin');

require 'layout.php';

$CRUD = $app->add(['CRUD']);
$CRUD->setModel(new Account($db));
$CRUD->addQuickSearch(['name']);
