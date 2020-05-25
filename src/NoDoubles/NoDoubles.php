<?php

namespace App\NoDoubles;

class NoDoubles
{
    public static function get($length)
    {
        $parser = new \App\Parser\OspsParser();

        $words = $parser->getWordsOfLength(15);
        $checks = $parser->getWordsOfLength(2);

        $noDoubles = [];

        foreach ($words as $word) {
            $hasSubstring = false;
            foreach ($checks as $check) {
                if (mb_strpos($word, $check) !== false) {
                    $hasSubstring = true;
                    break;
                }
            }
            if (! $hasSubstring) {
                $noDoubles[] = $word;
            }
        }

        echo count($noDoubles) . "\n";
        var_dump($noDoubles);
    }
}