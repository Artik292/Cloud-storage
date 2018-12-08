<?php

session_start();
$_SESSION['File_id'] = $_GET['mn'];
header('Location: file.php');
