<?php

require 'connection.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.2)');
$app->initLayout('Centered');

$app->add(['Header','Login'])
