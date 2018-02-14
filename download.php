<?php

//rename('php_errorlog', 'report.csv');
$filename = 'report.csv'; // of course find the exact filename....        
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="'. basename($filename));

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false); // required for certain browsers 
header('Content-Encoding: UTF-8');
header('Content-Type: text/plain');

header('Content-Transfer-Encoding: utf8_decode');
header('Content-Length: ' . filesize($filename));
echo "\xEF\xBB\xBF";
readfile($filename);


exit;



?>