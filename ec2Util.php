<?php
    $url = "http://169.254.169.254/latest/meta-data/instance-id";   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $res = curl_exec($ch);
    echo $res;
?>
