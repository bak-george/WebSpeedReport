<?php

use Core\App;
use Core\Bytes;
use Core\Database;

$db = App::resolve(Database::class);
$bytes = App::resolve(Bytes::class);

$data = $db->query('SELECT * FROM results WHERE id = :id', [
    'id' => $_GET['id']
])->find();

$data['download_bytes'] = Bytes::instantiateConvertAndRound($data['download_bytes'], 'toMegabytes', 2);
$data['upload_bytes'] = Bytes::instantiateConvertAndRound($data['upload_bytes'], 'toMegabytes', 2);
$data['download_bandwidth'] = round($data['download_bandwidth'] / 1000, 2);
$data['upload_bandwidth']   = round($data['upload_bandwidth'] / 1000, 2);
$data['ping_latency'] = round($data['ping_latency'], 2);

($data['interface_isVpn'] == 1) ? $data['interface_isVpn'] = 'Yes' : $data['interface_isVpn'] = 'No';

view("data/show.view.php", [
    'heading' => 'Data',
    'data' => $data
]);
