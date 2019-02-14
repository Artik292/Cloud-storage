<?php

require 'admin_connection.php';

$id = $_GET['id'];
$way = $_GET['way'];

switch ($way) {
  case 'folders':
      $_SESSION['folders'] = $id;
      header('Location: folders.php');
  break;

  case 'folder':
      $_SESSION['folder'] = $id;
      header('Location: folders.php');
  break;

  case 'files':
      $_SESSION['files'] = $id;
      header('Location: files.php');
  break;

  case 'file':
      $_SESSION['file'] = $id;
      header('Location: files.php');
  break;

  default:
      header('Location: logout_admin.php');
  break;
}
