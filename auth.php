<?php

require 'connection.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.2)');
$app->initLayout('Centered');

$app->add(['Button','Log in','big inverted green','icon'=>'sign in'])->link(['login']);

$app->add(['Header','Registration','center aligned huge blue']);

$form = $app->add(['Form']);
$form->addField('email',['caption'=>'Email']);
$form->addField('nickname',['caption'=>'Username']);
$form->addField('password-1',['caption'=>'Password']);
$form->addField('password-2',['caption'=>'Confirm password']);

$someone = new Account($db);

$form->buttonSave->set('Register');

$form->onSubmit(function($form) use($someone) {
    $someone->tryLoadby('Email',$form->model['email']);
    if (isset($someone->id)) {
        return new atk4\ui\jsNotify(['content' => 'This email is already in use', 'color' => 'red']);
    } else {
      $someone->tryLoadby('name',$form->model['nickname']);
      if (isset($someone->id)) {
          return new atk4\ui\jsNotify(['content' => 'This Nick name is already in use', 'color' => 'red']);
      } else {
          if ($form->model['password-1'] == $form->model['password-2']) {
            $someone['name'] = $form->model['nickname'];
            $someone['Email'] = $form->model['email'];
            $someone['Password'] = $form->model['password-1'];
            $someone->save();
            return new \atk4\ui\jsExpression('document.location = "index.php" ');
          } else {
            return new atk4\ui\jsNotify(['content' => 'Passwords are not the same', 'color' => 'red']);
          }
      }
    }
});
