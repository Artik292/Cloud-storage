<?php

//require 'vendor/autoload.php';
require 'connection.php';

$files = new File($db);
foreach ($files as $file) {
    if($file['Icon'] == NULL){
      if (isset($file_types[$file['MetaType']])) {
          if ($file_types[$file['MetaType']] == "img") {
            $file['Icon'] = $file['Link'];
          } else {
            $file['Icon'] = $file_types[$file['MetaType']];
          }
      } else {
          $file['Icon'] = "src/no_image.png";
      }
    }
    $file->save();
}

/*$app = new \atk4\ui\App('Main Page');
$app->initLayout('Centered');


$app->add(['Header', 'Properties', 'size' => 2]);
$app->add(['Button', 'Primary button', 'primary']);
$app->add(['Button', 'Load', 'labeled', 'icon'=>'pause']);
$app->add(['Button', 'Next', 'iconRight'=>'right arrow']);
$app->add(['Button', null, 'circular', 'icon'=>'settings']); */
