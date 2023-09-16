<?php

use Core\App;
use Core\Bytes;
use Core\Database;

$db = App::resolve(Database::class);
$bytes = App::resolve(Bytes::class);

$dataBytes = 1024;

$bytes->setBytes($dataBytes);

$bytes->toKilobytes();

$data = $db->query("SELECT * FROM results LIMIT 10")->fetchAll();

foreach ($data as $key => &$value) {  // Note the & which makes $value a reference
    $bytes->setBytes($value['download_bytes']);
    $value['download_bytes'] = $bytes->toMegabytes();

    $bytes->setBytes($value['upload_bytes']);
    $value['upload_bytes'] = $bytes->toMegabytes();
}


view("index.view.php", [
    'heading' => 'Home',
    'data' => $data,
]);