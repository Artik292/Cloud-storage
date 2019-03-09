<?php

$new_vir = $vir->add('VirtualPage');
$new_vir->set(function($new_vir) {

    $new_vir->add(['Header','Are you sure you want to delete this file?','big center aligned red']);

    $new_vir->add(['Button','Yes','red small'])->link(['delete_file']);

    $no_button = $new_vir->add(['Button','No','green big']);
    $no_button->on('click', function($new_vir) {
        return new \atk4\ui\jsExpression('document.location="file.php"');
    });
});
