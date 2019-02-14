<?php

session_start();
$user_id = $_SESSION['user_id'];
session_unset();
$_SESSION['user_id'] = $user_id;
header('Location: ../index.php');
