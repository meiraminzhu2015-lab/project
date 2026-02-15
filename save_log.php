
<?php

$noise = rand(40,80);
$door = (rand(0,1)==0) ? "Закрыта" : "Открыта";
$motion = (rand(0,1)==0) ? "Не обнаружено" : "Обнаружено";
$away = isset($_GET['away']) ? intval($_GET['away']) : 0;

$status = "";
$alert = false;

if($noise<50) $status="Комфортно (Шепот)";
elseif($noise<65) $status="Умеренно (Разговор)";
else { $status="Громко (Шум)"; if($noise>65) $alert=true; }

if($away==1 && $noise>70) $alert=true;

$logLine = date("Y-m-d H:i:s")." — $noise дБ — $status — Дверь: $door — Движение: $motion";
if($alert) $logLine.=" — ПОДОЗРИТЕЛЬНАЯ АКТИВНОСТЬ";

file_put_contents("logs.txt",$logLine.PHP_EOL,FILE_APPEND);

$logs = file("logs.txt");
$logsOutput = "";
foreach(array_slice(array_reverse($logs),0,5) as $line){
    $logsOutput.="<div>$line</div>";
}

echo json_encode([
    "noise"=>$noise,
    "status"=>$status,
    "door"=>$door,
    "motion"=>$motion,
    "logs"=>$logsOutput,
    "alert"=>$alert
]);


---
