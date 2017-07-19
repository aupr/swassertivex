<?php

// Load the required class
spl_autoload_register(function ($class_name) {
    if (file_exists(DIR_LIBRARY . $class_name . '.php')) {
        include_once DIR_LIBRARY . $class_name . '.php';
    } elseif (file_exists(DIR_EXTLIB . $class_name . '.php')) {
        include_once DIR_EXTLIB . $class_name . '.php';
    } else {
        foreach (glob(DIR_EXTLIB . '*' , GLOB_ONLYDIR) as $fpath) {
            if (file_exists($fpath . '/' . $class_name . '.php')) {
                include_once $fpath . '/' . $class_name . '.php';
            }
        }
    }
});

// Set the value of confuguration from target ini file
foreach(parse_ini_file(DIR_.'sw.ini') as $key=>$value) {
    ini_set($key, $value);
}


    // URL router object
    global $url;
    $url = new url(HTTP_SERVER . ADIR);

    // Encryption manager object
    global $encryption;
    $encryption = new encryption(ENCRYPTION_HASH);

    // Database manager object
    global $db;
    $db = new db(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_PREFIX.DB_DATABASE, DB_PORT);

    // Cache manager object
    global $cache;
    $cache = new cache('file',3600);

    // Cookie manager object
    global $cookie;
    $cookie = new cookie(ADIR);

    // Session manager object
    /*global $session;
    $session = new session('native', ADIR);*/

    // File downloader object
    global $downloader;
    $downloader = new downloader(DIR_FILE);

    // Mail sender object
    global  $mail;
    $email = new mail();

    // Log manager object
    global $error_log;
    global $query_log;
    $error_log = new log(DIR_LOGS, 'error.log');
    $query_log = new log(DIR_LOGS, 'query.log');


// Including the layout files
foreach (glob(DIR_LAYOUT . '*' , GLOB_ONLYDIR) as $fpath) {
    foreach (glob($fpath . '/*.php', GLOB_NOSORT) as $file) {
        require_once $file;
    }
}

// Including the security layout file
if (file_exists(DIR_LAYOUT . 'access.php')) {
    include_once DIR_LAYOUT . 'access.php';
} else {
    throw new \Exception("Error: Could not find the security layout file!");
}

// Default route function
function routeDefault($fname) {
    if (sizeof($ires =  glob(DIR_APPLICATION . $fname . '.*', GLOB_NOSORT))) {
        return $ires[0];
    } else {
        exit("No application file found as named $fname!");
    }
}

// Route function
function start($fname) {
    if (isset($_GET['get'])) {
        if (sizeof($ires =  glob(DIR_TRANSFER . $_GET['get'] . '.*', GLOB_NOSORT))  and $_GET['get']!='') {
            return $ires[0];
        } else {
            exit('{total:0, result:0, request:0, return:0, data:0}');
        }
    } elseif (isset($_GET['ui'])) {
        if (sizeof($ires =  glob(DIR_UIM . $_GET['ui'] . '.*', GLOB_NOSORT))  and $_GET['ui']!='') {
            return $ires[0];
        } else {
            return routeDefault($fname);
        }
    } elseif (isset($_GET['app'])) {
        if (sizeof($ires =  glob(DIR_APPLICATION . $_GET['app'] . '.*', GLOB_NOSORT)) and $_GET['app']!='') {
            return $ires[0];
        } else {
            return routeDefault($fname);
        }
    } else {
        return routeDefault($fname);
    }
}