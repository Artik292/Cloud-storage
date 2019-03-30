<?php

$vir = $app->add('VirtualPage');
$vir->set(function($vir) {

    $vir->add(['Header','Are you sure you want to delete this folder?','big center aligned red']);

    $vir->add(['Button','Yes','red small'])->link(['delete_folder']);

    $no_button = $vir->add(['Button','No','green big']);
    $no_button->on('click', function($vir) {
        return new \atk4\ui\jsExpression('document.location="file.php"');
    });
});
