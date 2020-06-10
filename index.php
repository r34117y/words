<?php

require_once __DIR__.'/vendor/autoload.php';

$parser = new \App\Parser\OspsParser();
$matrix = new \App\SuccessorMatrix\SuccessorMatrix([
    'json' => 'data/json/succesor_matrix.json',
    'parser' => $parser
]);

$matrix->showLeaders();




