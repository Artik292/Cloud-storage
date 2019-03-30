<?php

session_start();
$new_folder_id = array_pop($_SESSION['BreadCrumb']);
if ((count($_SESSION['BreadCrumb'])) == 0) {
    header('Location: index.php');
} else {
    $new_folder_id = end($_SESSION['BreadCrumb']);
    $_SESSION['folder_id'] = $new_folder_id;
    header('Location: file.php');
}
