<?php

$avsession->destroy('STK');

$avcookie->destroy('hsk','/'.APDIR);
$avcookie->destroy('si','/'.APDIR);
$avcookie->destroy('trk','/'.APDIR);