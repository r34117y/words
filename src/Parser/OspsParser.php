<?php

namespace App\Parser;

use App\Utils\StringHelper;

class OspsParser extends AbstractDictParser
{

    public function getFlatWordsArray()
    {
        return $this->makeFlatArray('word');
    }

    public function makeFlatBaseWordsArray()
    {
        return array_unique($this->makeFlatArray('baseWord'));
    }

    private function makeFlatArray(string $type)
    {
        $words = [];
        rewind($this->fileHandler);
        while ($line = fgets($this->fileHandler)) {
            $words[] = self::lineToArray($line)[$type];
        }
        return $words;
    }

    public function makeGroupedWordsArray()
    {
        $groups = [];
        rewind($this->fileHandler);
        while ($line = fgets($this->fileHandler)) {
            $lineParsed = self::lineToArray($line);
            if (array_key_exists($lineParsed['baseWord'], $groups)) {
                $groups[$lineParsed['baseWord']][] = $lineParsed['word'];
            } else {
                $groups[$lineParsed['baseWord']] = [$lineParsed['word']];
            }
        }
        return $groups;
    }

    public function createAnkiDeck()
    {
        $wordsSki = $this->getWordsFinishingWith('izm');
        $wordsCki = $this->getWordsFinishingWith('yzm');
        $words = array_merge($wordsCki, $wordsSki);
        echo "All ski: " . count($words);
        $grouped = [];
        foreach ($words as $word) {
            $sorted = StringHelper::sortString($word);
            if (array_key_exists($sorted, $grouped)) {
                $grouped[$sorted][] = $word;
            } else {
                $grouped[$sorted] = [$word];
            }
        }
        echo "Grouped ski: " . count($grouped);

        foreach ($grouped as $sorted => $words) {
            $question = StringHelper::sortString($word) . ' (' . count($words) . ')';
            $answer = implode(' ', $words);
            file_put_contents('webroot/anki/izm_yzm_anagramy', $question . ';' . $answer . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

    }

    public function getDictionaryPath() : string
    {
        return 'data/osps40.txt';
    }

    /**
     * 1. Makes all characters lowercase (no uppercase characters in osps)
     * 2. Gets rid of '(ndm)' in undeclinable words
     * returns array ['word' => 'sths', 'baseWord' => 'sth']
     * @todo case3 still doesn't work correctly (???)
     */
    private static function lineToArray(string $line) : array
    {
        $words = explode("\t", $line);
        $baseWord = trim(mb_strtolower($words[1]));
        $word = trim(mb_strtolower($words[0]));

        $check = explode(" ", $baseWord);
        $ndm = false;
        if (count($check) > 1) {
            if (trim(end($check)) === '(ndm)') {
                $ndm = true;
                array_pop($check);
            }
            $baseWord = implode(" ", $check);
        }

        return ['word' => $word, 'baseWord' => $baseWord, 'ndm' => $ndm];
    }
}