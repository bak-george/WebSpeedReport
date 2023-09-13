<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$data = $db->query("SELECT * FROM results LIMIT 10")->fetchAll();

view("index.view.php", [
    'heading' => 'Home',
    'data' => $data,
]);
