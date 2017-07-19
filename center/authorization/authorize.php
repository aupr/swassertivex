<?php

// Center application folder name

// Assertive Database Credential
$avdbc = array(
    'DRIVER'=>'mysqli',
    'HOSTNAME'=>'localhost',
    'USERNAME'=>'root',
    'PASSWORD'=>'',
    'DATABASE'=>'assertive',
    'PORT'=>'3306',
    'PREFIX'=>''
);


global $authorized;
$authorized = 0;

// server address transferred to login page
$avencryption_sae = new Encryption('adgjmptw');
echo $_SERVER['REQUEST_URI'];
function getLogin($obj, $uri) {

}





global $avdb;
$avdb = new EDB($avdbc['DRIVER'], $avdbc['HOSTNAME'], $avdbc['USERNAME'], $avdbc['PASSWORD'], $avdbc['PREFIX'].$avdbc['DATABASE'], $avdbc['PORT']);

function removeTimeOutSI($credentials) {
    $toBeUnset = array();
    $time = time();

    foreach ($credentials as $key=>$value) {
        if ($value['time'] < $time) {
            $toBeUnset[] = $key;
        }
    }

    foreach ($toBeUnset as $val) {
        unset($credentials[$val]);
    }

    return $credentials;
}

global $avsession;
$avsession = new session('native', APDIR);
$stk = $avsession->start('STK');

$avcookie = new Cookie();

if (isset($_SESSION[$stk]['authorization'])) {
    $uuid = $_SESSION[$stk]['authorization'];
    $tokens_json = $avdb->select('user', 'tokens', "WHERE id='$uuid'");

    $tokens = json_decode($tokens_json->row['tokens'], true);

    if (isset($tokens['STK'])) {
        if ($tokens['STK'] == $stk) {
            $authorized = 2;
        }
    }
}


if ($authorized == 0) {

    if (isset($_COOKIE['si']) AND isset($_COOKIE['hsk']) AND isset($_COOKIE['trk'])) {
        $seriesIdentifier = $_COOKIE['si'];
        $hashKey = $_COOKIE['hsk'];
        $uuid = $_COOKIE['trk'];
        $udata = $avdb->select('user','*', "WHERE id = '$uuid'");
        $credentials = removeTimeOutSI(json_decode($udata->row['credentials'], true));

        if (isset($credentials[$seriesIdentifier])) {
            $avencryption_cu = new Encryption($hashKey);
            $seriesIdentifier_cu = $avencryption_cu->decrypt($credentials[$seriesIdentifier]['hs_token']);

            if ($seriesIdentifier_cu == $seriesIdentifier) {
                if ($_SERVER['HTTP_USER_AGENT'] == $credentials[$seriesIdentifier]['di']) {
                    $setTime = $credentials[$seriesIdentifier]['duration'] + time();

                    $hashKeyN = $avsession->createId();
                    $avencryption_cun = new Encryption($hashKeyN);
                    $hashedValueN = $avencryption_cun->encrypt($seriesIdentifier);

                    $credentials[$seriesIdentifier]['time'] = $setTime;
                    $credentials[$seriesIdentifier]['hs_token'] = $hashedValueN;

                    $avcookie->make('si', $seriesIdentifier, $setTime, '/'.APDIR,"", false, true);
                    $avcookie->make('hsk', $hashKeyN, $setTime, '/'.APDIR,"", false, true);
                    $avcookie->make('trk', $uuid, $setTime, '/'.APDIR,"", false, false);



                    $_SESSION[$stk]['authorization'] = $uuid;
                    $toSaveToken = array('STK'=>$stk, 'ASID'=>"ByCookie");


                    // App permission start

                    $consents = json_decode($udata->row['consents'], true);
                    $appsData = $avdb->select('apps', "*");
                    if ($appsData->num_rows > 0) {
                        // set default apps permissions
                        foreach ($appsData->rows as $appData) {
                            $defaultPermission = json_decode($appData['dps'], true);
                            $_SESSION[$stk][$appData['cookie']] = $defaultPermission;
                            $avcookie->make($appData['cookie'], $uuid, 0, '/'.APDIR.$appData['directory'],"", false, false);
                        }

                        // set defined apps permissions

                        $consentsToBeUnset = array();
                        foreach ($consents as $appCookie=>$definedPermissions) {
                            if (isset($_SESSION[$stk][$appCookie])) {

                                // Start detection of absurd variables and removing them
                                $definedPermissionsToBeUnset = array();
                                foreach ($definedPermissions as $key=>$val) {
                                    if (!isset($_SESSION[$stk][$appCookie][$key])) {
                                        $definedPermissionsToBeUnset[] = $key;
                                    }
                                }
                                foreach ($definedPermissionsToBeUnset as $val) {
                                    unset($definedPermissions[$val]);
                                    unset($consents[$appCookie][$val]);
                                }
                                // End detection of absurd variables and removing them

                                $_SESSION[$stk][$appCookie] = array_merge($_SESSION[$stk][$appCookie], $definedPermissions);

                            } else {
                                $consentsToBeUnset[] = $appCookie;
                            }
                        }

                        // Remove backdated / unused app consents
                        foreach ($consentsToBeUnset as $val) {
                            unset($consents[$val]);
                        }
                    }

                    // App permission end

                    $avdb->updateById('user', array('tokens'=>json_encode($toSaveToken), 'credentials'=>json_encode($credentials), 'consents'=>json_encode($consents)), $uuid);


                    $authorized = 3;
                } else {
                    unset($credentials[$seriesIdentifier]);
                    $avdb->updateById('user', array('tokens'=>json_encode(array()), 'credentials'=>json_encode($credentials)), $uuid);
                }
            }
        }
    }
}

if ($authorized == 0) {
    $avcookie->destroy('hsk','/'.APDIR);
    $avcookie->destroy('si','/'.APDIR);
    $avcookie->destroy('trk','/'.APDIR);
}













