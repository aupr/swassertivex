<?php


    if (isset($_POST['submit'])) {
        //$remember = true;
        $memoryTime = 3600*24*7; // in seconds
        $userid = $_POST['userid'];
        $password = $_POST['password'];
        $udt = $avdb->select('user',"*", "WHERE userid = '$userid' AND covert = '$password'");

        if ($udt->num_rows > 0) {

            $uuid = $udt->row['id'];
            $credentials = removeTimeOutSI(json_decode($udt->row['credentials'], true));
            $_SESSION[$stk]['authorization'] = $uuid;

            $toSaveToken = array('STK'=>$stk, 'ASID'=>"ByLogin");

            if ($memoryTime > 0) {

                $seriesIdentifier = $avsession->createId();
                $setTime = time()+$memoryTime;
                $hashKey = $avsession->createId();
                $avencryption = new Encryption($hashKey);
                $hashedValue = $avencryption->encrypt($seriesIdentifier);
                $deviceInfo = $_SERVER['HTTP_USER_AGENT'];


                $credentials[$seriesIdentifier] = array(
                    'time' => $setTime,
                    'duration' => $memoryTime,
                    'hs_token' => $hashedValue,
                    'di' => $deviceInfo
                );

                $avcookie->make('si', $seriesIdentifier, $setTime, '/'.APDIR,"", false, true);
                $avcookie->make('hsk', $hashKey, $setTime, '/'.APDIR,"", false, true);
                $avcookie->make('trk', $uuid, $setTime, '/'.APDIR,"", false, false);
            }

            // App permission start

            $consents = json_decode($udt->row['consents'], true);
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

            echo "Login Success!<hr>";

            // target application linking
            if (isset($_GET['tal'])) {
                $targetLinkAv = $avencryption_sae->decrypt($_GET['tal']);
                $tal_avad = preg_split('/[\/]+/',$targetLinkAv);
                if (isset($tal_avad[2])) {
                    header('Location: '.$targetLinkAv);
                } else {
                    header('location: /'.APDIR.CADIR);
                }
            } else {
                header('location: /'.APDIR.CADIR);
            }

        } else {
            echo "Invalid UserID or Password!";
        }
    }

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>System Login!</title>
</head>
<body>
    <form action="" method="post">
        <label for="userid">User ID: </label>
        <input type="text" id="userid" name="userid">
        <label for="password">Password: </label>
        <input type="password" id="password" name="password">
        <input type="submit" name="submit" value="Login">
    </form>

<?php
    echo "authorized: $authorized <br>";
?>
</body>
</html>