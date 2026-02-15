<?php
$logs = file("logs.txt");
$total=0; $count=0; $violations=0;

foreach($logs as $line){
    if (preg_match('/(\d+) дБ/', $line,$match)){
        $total+=intval($match[1]);
        $count++;
    }
    if (strpos($line,"ПОДОЗРИТЕЛЬНАЯ АКТИВНОСТЬ")!==false)
        $violations++;

}

$average = $count? round($total/$count,1) : 0;

header ("Content-Type: text/plain");
header ("Content-Disposition: attachment;filename=AuraGuard_Report.txt");

echo "AuraGuard 2.0 - Отчет\n";
echo "Дата: ".date ("d.m.Y H:i")."\n\n";
echo "Средний уровень шума: $average дБ\n";
echo "Количество тревог: $violations \n\n";
echo "Логи:\n";
foreach($logs as $line) echo $line;