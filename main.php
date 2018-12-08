<?php

//require 'vendor/autoload.php';

session_start();


echo $_SESSION['name_file'];

//$app = new \atk4\ui\App('Main Page');
//$app->initLayout('Centered');


/*
$path_parts = pathinfo($_SESSION['file']);

echo $path_parts['basename'], "\n";
echo $path_parts['extension'], "\n";

$fileSize = filesize($_FILES['file']['tmp_name']);        МОИ ПОПЫТКИ
echo $fileSize;

//$f = fopen($_SESSION['file'],"r");
$f = fopen('D:\Users\Arturs\UI\XAMPP\tmp',"r");


var_dump($_SESSION['file']);
var_dump($_FILES);

*/

/*

echo $path_parts['dirname'], "\n";
echo $path_parts['basename'], "\n";
echo $path_parts['extension'], "\n";
echo $path_parts['filename'], "\n";

*/
