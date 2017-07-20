<?php

include_once DIR_AUTHORIZATION.'login.php';

if ($login==2) {
    echo '{"login":false, "location": ""}';
} elseif ($login==1) {
    // target application linking
    if (isset($_GET['tal'])) {
        $targetLinkAv = $avencryption_sae->decrypt($_GET['tal']);
        $tal_avad = preg_split('/[\/]+/',$targetLinkAv);
        if (isset($tal_avad[2])) {
            //header('Location: '.$targetLinkAv);
            echo '{"login":true, "location": "'.$targetLinkAv.'"}';
        } else {
            echo '{"login":true, "location": "/'.APDIR.CADIR.'"}';
        }
    } else {
        echo '{"login":true, "location": "/'.APDIR.CADIR.'"}';
    }
} elseif ($login==0) {
    echo '{"login":false, "location": ""}';
}