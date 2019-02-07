<?php

require 'connection.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.2)');
$app->initLayout('Centered');

/**

    Add new Folder

**/

$button_add_folder = $app->add(['Button','New folder','big inverted green','icon'=>'plus']);
$vir = $app->add('VirtualPage');
$vir->set(function($vir) use ($db) {
            $form = $vir->add('Form');
            $form->setModel(new Folder($db),['name']);
            $form->onSubmit(function($form) {
                $form->model['account_id'] = $_SESSION['user_id'];
                $form->model->save();
                return [$form->success('Folder added!'),new \atk4\ui\jsExpression('document.location="index.php"')];
    });
});

$button_add_folder->on('click', new \atk4\ui\jsModal('New Folder',$vir));
$app->add(['ui'=>'green divider']);

$columns = $app->add('Columns');

$col_1 = $columns->addColumn(4);
$col_2 = $columns->addColumn(4);
$col_3 = $columns->addColumn(4);
$col_4 = $columns->addColumn(4);

$folder = new Folder($db);

$i = 1;

foreach ($folder as $fold) {
    $folder_icon = $fold['Image'] ?? 'no_image.png';
    $id = $fold->id;

    $link = '"re.php?mn='.$id.'"';
    $link = 'document.location='.$link;

    switch ($i) {
        case 1:
              $col_1->add(['Image',$folder_icon,'big'])->on('click', new \atk4\ui\jsExpression($link));
              $col_1->add(['Header',$fold['name'],'centered']);
              $i++;
              break;
        case 2:
              $col_2->add(['Image',$folder_icon,'big'])->on('click', new \atk4\ui\jsExpression($link));
              $col_2->add(['Header',$fold['name'],'centered']);
              $i++;
              break;
        case 3:
              $col_3->add(['Image',$folder_icon,'big'])->on('click', new \atk4\ui\jsExpression($link));
              $col_3->add(['Header',$fold['name'],'centered']);
              $i++;
              break;
        case 4:
              $col_4->add(['Image',$folder_icon,'big'])->on('click', new \atk4\ui\jsExpression($link));
              $col_4->add(['Header',$fold['name'],'centered']);
              $i=1;
              $col_1->add(['ui'=>'hidden divider']);
              $col_2->add(['ui'=>'hidden divider']);
              $col_3->add(['ui'=>'hidden divider']);
              $col_4->add(['ui'=>'hidden divider']);
              break;
}
}

$app->add(['ui'=>'hidden divider']);

$app->add(['Button','Log out','red'])->link(['logout']);
