<?php

include_once DIR_AUTHORIZATION . 'authorize.php';

if ($authorized == 0) {
    if (isset($_GET['app'])){
        if ($_GET['app']!='login' and $_GET['app']!='logout') {
            header('Location: '.$uriForLogin);
        }
    } elseif (isset($_GET['get'])) {
        echo "{login: false}";
        exit;
    } elseif (isset($_GET['ui'])) {
        echo 'Login required';
        exit;
    }
}
