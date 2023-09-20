<?php

use Core\App;
use Core\Bytes;
use Core\Database;

$db    = App::resolve(Database::class);
$bytes = App::resolve(Bytes::class);

$serverName = $db->query("SELECT server_name FROM results GROUP BY server_name  ORDER BY COUNT(*) DESC LIMIT 4")->fetchAll();

$avgDownload = $db->query("SELECT AVG(download_bytes) AS 'avg_download_bytes' FROM results")->find();
$avgUpload   = $db->query("SELECT AVG(upload_bytes) AS 'avg_upload_bytes' FROM results")->find();
$avgPingLatency = $db->query("SELECT AVG(ping_latency) AS 'avg_ping_latency' FROM results")->find();
$avgPacketLoss = $db->query("SELECT AVG(packetLoss) AS 'avg_packet_loss' FROM results")->find();

$avgDownload = Bytes::instantiateConvertAndRound($avgDownload['avg_download_bytes'], 'toMegabytes', 2);
$avgUpload   = Bytes::instantiateConvertAndRound($avgUpload['avg_upload_bytes'], 'toMegabytes', 2);
$avgPingLatency = round($avgPingLatency['avg_ping_latency'], 2);
$avgPacketLoss = round($avgPacketLoss['avg_packet_loss'], 2);

$averages = [
    $avgDownload,
    $avgUpload,
    $avgPingLatency,
    $avgPacketLoss
];

$maxDownload = $db->query("SELECT MAX(download_bytes) AS 'max_download_bytes' FROM results")->find();
$maxUpload   = $db->query("SELECT MAX(upload_bytes) AS 'max_upload_bytes' FROM results")->find();
$maxPingLatency = $db->query("SELECT MAX(ping_latency) AS 'max_ping_latency' FROM results")->find();
$macPacketLoss = $db->query("SELECT MAX(packetLoss) AS 'max_packet_loss' FROM results")->find();

$maxDownload = Bytes::instantiateConvertAndRound($maxDownload['max_download_bytes'], 'toMegabytes', 2);
$maxUpload   = Bytes::instantiateConvertAndRound($maxUpload['max_upload_bytes'], 'toMegabytes', 2);
$maxPingLatency = round($maxPingLatency['max_ping_latency'], 2);

$maxValues = [
    $maxDownload,
    $maxUpload,
    $maxPingLatency,
    $macPacketLoss['max_packet_loss']
];

$minDownload = $db->query("SELECT MIN(download_bytes) AS 'min_download_bytes' FROM results")->find();
$minUpload   = $db->query("SELECT MIN(upload_bytes) AS 'min_upload_bytes' FROM results")->find();
$minPingLatency = $db->query("SELECT MIN(ping_latency) AS 'min_ping_latency' FROM results")->find();
$minPacketLoss = $db->query("SELECT MIN(packetLoss) AS 'min_packet_loss' FROM results")->find();

$minDownload = Bytes::instantiateConvertAndRound($minDownload['min_download_bytes'], 'toMegabytes', 2);
$minUpload   = Bytes::instantiateConvertAndRound($minUpload['min_upload_bytes'], 'toMegabytes', 2);
$minPingLatency = round($minPingLatency['min_ping_latency'], 2);

$minValues = [
    $minDownload,
    $minUpload,
    $minPingLatency,
    $minPacketLoss['min_packet_loss']
];

$data = $db->query("SELECT * FROM results ORDER BY timestamp DESC")->fetchAll();

foreach ($data as $key => &$value) {
    $value['download_bytes'] = Bytes::instantiateConvertAndRound($value['download_bytes'], 'toMegabytes', 2);

    $value['upload_bytes'] = Bytes::instantiateConvertAndRound($value['upload_bytes'], 'toMegabytes', 2);

    $value['download_bandwidth'] = round($value['download_bandwidth'] / 1000, 2);
    $value['upload_bandwidth']   = round($value['upload_bandwidth'] / 1000, 2);
}

view("index.view.php", [
    'heading' => 'Home',
    'data' => $data,
    'averages' => $averages,
    'maxValues' => $maxValues,
    'minValues' => $minValues,
    'serverName' => $serverName
]);
