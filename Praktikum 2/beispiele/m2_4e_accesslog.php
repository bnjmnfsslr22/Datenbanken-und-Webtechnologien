<?php

$browser = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];
$currentDate = date('Y-m-d H:i:s');

$logEntry = "$currentDate - $browser - $ip\n";

file_put_contents('accesslog.txt', $logEntry, FILE_APPEND);

echo "Log-Eintrag hinzugefügt.";

?>
