<?php

include_once DIR_AUTHORIZATION.'login.php';

if ($login==2) {
    echo 'login failed!';
} elseif ($login==1) {
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
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Assertive Login!</title>
    <base href="/<?=APDIR.ADIR?>application/">
    <script src="vendor/jquery-3.1.1/jquery.js"></script>
</head>
<body>
    <form action="" method="post">
        <label for="userid">User ID: </label>
        <input type="text" id="userid" name="userid">
        <label for="password">Password: </label>
        <input type="password" id="password" name="password">
        <input type="hidden" name="duration" value="3600">
        <input type="submit" name="submit" value="Login">
    </form>

<?php
    echo "authorized: $authorized <br>";
?>
</body>
</html>