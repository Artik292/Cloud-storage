<?php

require 'admin_connection.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.3)');
$app->initLayout('Admin');

require 'layout.php';

$CRUD = $app->add(['CRUD']);
$CRUD->setModel(new File($db));
$CRUD->addQuickSearch(['name']);
