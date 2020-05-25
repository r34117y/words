<?php

namespace App\Parser;

abstract class AbstractDictParser
{
    /** @var array */
    public $flatWords;

    /** @var bool|resource */
    protected $fileHandler;

    public function __construct()
    {
        $path = $this->getDictionaryPath();
        if (! ($this->fileHandler = fopen($path, "r"))) {
            throw new \Exception("Zła ścieżka do słownika: {$path}");
        }
    }

    public function getWordsOfLength(int $n): array
    {
        $words = $this->getFlatWordsArray();

        return array_filter($words, function ($word) use ($n) {
            return mb_strlen($word) === $n;
        });
    }

    public function getWordsFinishingWith(string $ending)
    {
        $words = $this->getFlatWordsArray();

        return array_filter($words, function ($word) use ($ending) {
            $length = mb_strlen($ending);
            if (mb_strlen($word) <= $length || mb_strlen($word) > 8) {
                return false;
            }
            return mb_substr($word, -$length) === $ending;
        });
    }

    public function getWordsWithUniqueLetters()
    {
        $words = $this->getFlatWordsArray();
        echo 'Przed: ' . count($words) . "\n";
        $uniqueLetters = array_filter($words, function ($word) {
            $wa = StringToArray::get($word);
            $wau = array_unique($wa);
            return $wa === $wau;
        });
        echo 'Po: ' . count($uniqueLetters) . "\n";
        $path = 'webroot/x_algorithm/unique_letters';
        file_put_contents($path, implode("\n", $uniqueLetters));

    }

    abstract public function getFlatWordsArray();

    abstract public function makeGroupedWordsArray();

    abstract public function getDictionaryPath() : string;
}