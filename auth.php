<?php

require 'connection.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.2)');
$app->initLayout('Centered');

$app->add(['Header','Registration','center aligned huge green']);

$form = $app->add(['Form']);
$form->addField('email',['caption'=>'Email']);
$form->addField('nickname',['caption'=>'Username']);
$form->addField('password-1',['caption'=>'Password']);
$form->addField('password-2',['caption'=>'Confirm password']);

$someone = new Account($db);

$form->onSubmit(function($form) use($someone) {
    $someone->tryLoadby('Email',$form->model['email']);
    if (isset($someone->id)) {
        return new atk4\ui\jsNotify(['content' => 'This email is already in use', 'color' => 'red']);
    } else {
        return new atk4\ui\jsNotify(['content' => 'Good!', 'color' => 'green']);
    }
});
