<?php 

$date1 = new DateTime("now");
$date2 = new DateTime("2020-09-01");
$interval = $date1->diff($date2);
echo intval($interval->format('%R%a'));
//header("location: upload.html");    
?>