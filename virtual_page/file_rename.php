<?php

$virtual = $vir->add('VirtualPage');
$virtual->set(function($virtual) use ($db) {
            $form = $virtual->add('Form');
            $form->addField('new_name',['caption'=>'New name for '.$_SESSION['file_name']])->set($_SESSION['file_name']);
            $form->onSubmit(function($form) use($db) {
                if ($form->model['new_name'] == '') {
                    return new atk4\ui\jsNotify(['content' => "Name can't be empty", 'color' => 'red']);
                }
                $file = new File($db);
                $file->load($_SESSION['file_id']);
                $file['MetaName'] = $form->model['new_name'];
                $file->save();
                return [$form->success('File renamed!'),new \atk4\ui\jsExpression('document.location="file.php"')];
    });
});
