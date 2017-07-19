<?php

include_once DIR_AUTHORIZATION . 'authorize.php';

if ($authorized == 0) {
    if (isset($_GET['get'])) {
        echo "{login: false}";
        exit;
    } elseif (isset($_GET['ui'])) {
        echo 'Login required';
        exit;
    } else {
        header('Location: '.$uriForLogin);
    }
}