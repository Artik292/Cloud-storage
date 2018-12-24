<?php

session_start();
if ($_SESSION['admin']) {
    $_SESSION['admin'] = FALSE;
} else {
    $_SESSION['admin'] = TRUE;
}

header('Location: index.php');
