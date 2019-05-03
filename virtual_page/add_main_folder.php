<?php

$vir = $app->add('VirtualPage');
$vir->set(function($vir) use ($db) {
            $form = $vir->add('Form');
            $form->setModel(new Folder($db),['name']);
            $form->onSubmit(function($form) {
                //if (preg_match('/^[a-zA-Z0-9_]{1,}$', $form->model['name'])) { //regular expression, need to know more 
                if ($form->model['name'] !== '') {
                  $form->model['account_id'] = $_SESSION['user_id'];
                  $form->model['Is_SubFolder'] = 0;
                  $form->model->save();
                  return [$form->success('Folder added!'),new \atk4\ui\jsExpression('document.location="index.php"')];
                } else {
                  return new atk4\ui\jsNotify(['content' => "Folder name can't be empty!", 'color' => 'red']);
                }
    });
});
