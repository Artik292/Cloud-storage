<?php

session_start();
$_SESSION['folder_id'] = $_GET['mn'];
if (!isset($_SESSION['BreadCrumb'])) {
    $_SESSION['BreadCrumb'] = array();
}
array_push($_SESSION['BreadCrumb'],$_SESSION['folder_id']);
//var_dump($_SESSION['BreadCrumb']);
header('Location: file.php');
