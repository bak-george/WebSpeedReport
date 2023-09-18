<?php

use Core\App;
use Core\Bytes;
use Core\Database;

$db    = App::resolve(Database::class);
$bytes = App::resolve(Bytes::class);

$data = $db->query("SELECT * FROM results LIMIT 20")->fetchAll();

foreach ($data as $key => &$value) {
    $bytes->setBytes($value['download_bytes']);
    $value['download_bytes'] = round($bytes->toMegabytes(), 2);

    $bytes->setBytes($value['upload_bytes']);
    $value['upload_bytes'] = round($bytes->toMegabytes(), 2);

    $value['download_bandwidth'] = round($value['download_bandwidth'] / 1000, 2);
    $value['upload_bandwidth']   = round($value['upload_bandwidth'] / 1000, 2);
}

view("index.view.php", [
    'heading' => 'Home',
    'data' => $data,
]);
