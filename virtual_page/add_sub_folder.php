<?php

$vir = $app->add('VirtualPage');
$vir->set(function($vir) use($model,$db) {

    $form = $vir->add(['Form']);
    $form->addField('FolderName',['caption'=>'Folder Name']);
    //$form->setModel($model,['name']);

    $form->onSubmit(function ($form) use($db,$model) {
        $new_folder = new Folder($db);
        $new_folder['name'] = $form->model['FolderName'];
        $new_folder['account_id'] = $_SESSION['user_id'];
        $new_folder['Is_SubFolder'] = TRUE;
        $new_folder->save();
        $sub_new_folder = new SubFolder($db);
        $sub_new_folder['child_folder_id'] =$new_folder->id;
        $sub_new_folder['folder_id'] = $_SESSION['folder_id'];
        $sub_new_folder->save();
        //$form->model->save();
        return new \atk4\ui\jsExpression('document.location="file.php"');
    });
});
