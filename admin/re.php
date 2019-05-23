<?php

require 'admin_connection.php';

$id = $_GET['id'];
$way = $_GET['way'];

switch ($way) {
  case 'usrtofol':
      $_SESSION['account_id'] = $id;
      header('Location: folders.php');
  break;

  case 'foltousr':
      $_SESSION['account_id'] = $id;
      header('Location: users.php');
  break;

  case 'foltofil':
      $_SESSION['folder_id'] = $id;
      header('Location: files.php');
  break;

  default:
      header('Location: logout_admin.php');
  break;
}
