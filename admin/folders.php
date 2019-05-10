 <?php

require 'admin_connection.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.3)');
$app->initLayout('Admin');

require 'layout.php';

if (isset($_SESSION['account_id'])) {
  $account = new Account($db);
  $account->load($_SESSION['account_id']);
  $folders = $account->ref('Folder');

  $CRUD = $app->add(['CRUD']);
  $CRUD->setModel($folders);
  $CRUD->addQuickSearch(['name']);
  $CRUD->addDecorator('name', new \atk4\ui\TableColumn\Link('re.php?id={$id}&way=foltofil'));

  unset($_SESSION['account_id']);

} else {

  $CRUD = $app->add(['CRUD']);
  $CRUD->setModel(new Folder($db));
  $CRUD->addQuickSearch(['name']);
  $CRUD->addDecorator('name', new \atk4\ui\TableColumn\Link('re.php?id={$id}&way=foltofil'));

}
