<?php

$app->layout->leftMenu->addItem(['Users', 'icon'=>'users'],['index']);
$app->layout->leftMenu->addItem(['Folders', 'icon'=>'folder open outline'],['folders']);
$app->layout->leftMenu->addItem(['Files', 'icon'=>'file alternate outline'],['files']);
$app->layout->leftMenu->addItem(['Exit', 'icon'=>'sign out'],['../index']);
