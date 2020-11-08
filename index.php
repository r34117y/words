<?php

require_once __DIR__.'/vendor/autoload.php';

//$parser = new \App\Parser\OspsParser();
/*$matrix = new \App\SuccessorMatrix\SuccessorMatrix([
    'json' => 'data/json/succesor_matrix.json',
    'parser' => $parser
]);

$matrix->showLeaders();*/

$parser = new \App\Parser\OspsParser();
$words = $parser->getWordsOfLength(3);
//chcę tylko wyrazy bez spacji, zawierające scrabblowe znaki
//$regex = '/[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ]+/';
//foreach ($words as $word) {
//    echo $word . PHP_EOL;
//}

const WORD_SIZE = 3;

function find($words, $position = 1)
{
    $possible = findForPosition($words, $position);
    if ($position === WORD_SIZE && $possible) {
        return array_merge($words, $possible);
    } else {
        foreach ($possible as $pWord) {

        }
    }
}

function findForPosition($words, $position)
{

}

$trie = new \Tries\Trie();
$squares = [];
foreach ($words as $word) {
    $trie->add($word);
}

reset($words);
foreach ($words as $word) {
    $square = find([$word]);
}








