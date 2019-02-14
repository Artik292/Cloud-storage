<?php

require 'admin_connection.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.2)');
$app->initLayout('Admin');
$app->layout->leftMenu->addItem(['Users', 'icon'=>'users'],['users']);
