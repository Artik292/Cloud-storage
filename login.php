<?php

require 'connection.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.3)');
$app->initLayout('Centered');

$app->add(['Button','Sign up','big green','iconRight'=>'user plus'])->link(['auth']);


$app->add(['Header','Login']);

$model = new \atk4\data\Model(new \atk4\data\Persistence_Array($a));

$model->addField('nick',['caption'=>'E-mail or Nick name']);
$model->addField('password',['type'=>'password']);

$form = $app->add(['Form']);
$form->setModel($model);

$account = new Account($db);

$form->buttonSave->set('Log in');

$form->onSubmit(function($form) use($account,$app,$db){
    $account->tryLoadby('Email',$form->model['nick']);
    if (isset($account->id)) {
        if ($account['Password'] == $form->model['password']) {
            $_SESSION['user_id'] = $account->id;
            $account->unload();

            $basic_info = new Basic_info($db);
            $basic_info->load(1);
            $basic_info['amount_of_visitors'] = $basic_info['amount_of_visitors'] + 1;
            $basic_info->save();
            $basic_info->unload();

            return $app->jsRedirect('index.php');
        } else {
            $account->unload();
            $error = (new \atk4\ui\jsNotify('No such user or incorrect password.'));
            $error->setColor('red');
            return $error;
        }
    } else {
        $account->tryLoadby('name',$form->model['nick']);
        if (isset($account->id)) {
          if ($account['Password'] == $form->model['password']) {
              $_SESSION['user_id'] = $account->id;
              $account->unload();

              $basic_info = new Basic_info($db);
              $basic_info->load(1);
              $basic_info['amount_of_visitors']= $basic_info['amount_of_visitors'] + 1;
              $basic_info->save();
              $basic_info->unload();

              return $app->jsRedirect('index.php');
          } else {
              $account->unload();
              $error = (new \atk4\ui\jsNotify('No such user or incorrect password.'));
              $error->setColor('red');
              return $error;
          }
        } else {
          $account->unload();
          $error = (new \atk4\ui\jsNotify('No such user or incorrect password.'));
          $error->setColor('red');
          return $error;
        }
    }
});
