<?php

session_start();
$_SESSION['folder_id'] = $_GET['mn'];
header('Location: file.php');
