<?php

require 'connection.php';

//session_start();

var_dump($_SESSION);

//$blobClient = $_SESSION['blobClient'];
$containerName = $_SESSION['containerName'];

$blobClient->deleteContainer($containerName);

//unset_session();

//header('Location: file.php');
