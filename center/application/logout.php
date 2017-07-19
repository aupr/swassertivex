<?php

$avsession->destroy('STK');

$avcookie->destroy('hsk','/'.APDIR);
$avcookie->destroy('si','/'.APDIR);
$avcookie->destroy('trk','/'.APDIR);

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


