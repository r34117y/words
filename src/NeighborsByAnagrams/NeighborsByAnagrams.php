<?php


namespace App\NeighborsByAnagrams;


use App\Parser\SjpParser;

class NeighborsByAnagrams
{
    /**\
     * Słowa są sąsiadami, jeśli choć jedna odmiana danego słowa
     * jest anagramem jakiejś odmiany innego słowa
     */
    public function __construct()
    {
        $parser = new SjpParser();
        $words = $parser->getFlatWordsArray();
        $queue = [];
        $visited = [];
        array_push($queue, $words[0]);
        while ($queue) {
            foreach ($queue as $word) {

            }
        }
    }
}