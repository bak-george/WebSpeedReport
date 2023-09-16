<?php

use Core\App;
use Core\Bytes;
use Core\Database;

$db = App::resolve(Database::class);
$bytes = App::resolve(Bytes::class);

$data = $db->query("SELECT * FROM results LIMIT 10")->fetchAll();

foreach ($data as $key => &$value) {
    $bytes->setBytes($value['download_bytes']);
    $value['download_bytes'] = $bytes->toMegabytes();

    $bytes->setBytes($value['upload_bytes']);
    $value['upload_bytes'] = $bytes->toMegabytes();

    $value['download_bandwidth'] = $value['download_bandwidth'] / 1000;
}


view("index.view.php", [
    'heading' => 'Home',
    'data' => $data,
]);
