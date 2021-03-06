 <?php

require 'admin_connection.php';
//require '../vendor/autoload.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.2)');
$app->initLayout('Admin');

require 'layout.php';

if (isset($_SESSION['folders'])) {
  $account_id = $_SESSION['folders'];
  $account = new Account($db);
  $account->load($account_id);
  echo $_SESSION['folders'];
  $folders = $account->ref('Folder');

  $CRUD = $app->add(['CRUD']);
  $CRUD->setModel($folders);
  $CRUD->addQuickSearch(['name']);

  unset($_SESSION['folders']);

} elseif (isset($_SESSION['folder'])) {


  unset($_SESSION['folder']);

} else {

  $CRUD = $app->add(['CRUD']);
  $CRUD->setModel(new Folder($db));
  $CRUD->addQuickSearch(['name']);

}
