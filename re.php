<?php

session_start();
$_SESSION['folder_id'] = $_GET['mn'];
echo $_SESSION['folder_id'];
header('Location: file.php');
