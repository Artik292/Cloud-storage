<?php

//require 'vendor/autoload.php';
require 'connection.php';



$accounts = new Account($db);
$basic_info = new Basic_info($db);
$basic_info->load(1);
$basic_info['amount_of_users'] = 0;
foreach ($accounts as $account) {
    $basic_info['amount_of_users'] = $basic_info['amount_of_users'] + 1;
}

$files = new File($db);
$basic_info['total_memory_in_use'] = 0;
foreach ($files as $file) {
    $basic_info['total_memory_in_use'] = $basic_info['total_memory_in_use'] + $file['MetaSize'];
}
$basic_info['total_memory_in_use'] = $basic_info['total_memory_in_use'];

$basic_info->save();






/*$file_name = "Снимок экрана 2019-05-10 в 15.12.45.png";
$last_dot_position_number = strrpos($_SESSION['name_file'], ".");
$last_dot_position_number++;
$type = substr($file_name, $last_dot_position_number);


//var_dump($last_dot_position_number);
echo $type; */





/*$files = new File($db);
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
*/


/*$app = new \atk4\ui\App('Main Page');
$app->initLayout('Centered');


$app->add(['Header', 'Properties', 'size' => 2]);
$app->add(['Button', 'Primary button', 'primary']);
$app->add(['Button', 'Load', 'labeled', 'icon'=>'pause']);
$app->add(['Button', 'Next', 'iconRight'=>'right arrow']);
$app->add(['Button', null, 'circular', 'icon'=>'settings']); */
