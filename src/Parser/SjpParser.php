<?php


namespace App\Parser;


class SjpParser extends AbstractDictParser
{

    public function getFlatWordsArray() : array
    {
        $words = [];
        rewind($this->fileHandler);
        while ($line = trim(fgets($this->fileHandler))) {
            $line = explode(', ', $line);
            foreach ($line as $word) {
                $words[] = $word;
            }
        }
        return $words;
    }

    public function getGroupedWordsArray() : array
    {
        $groups = [];
        rewind($this->fileHandler);
        while ($line = fgets($this->fileHandler)) {
            $lineParsed = explode(', ', $line);
            $parent = trim(array_shift($lineParsed));
            if (array_key_exists($parent, $groups)) {
                echo "Słowo powtarza się: {$parent}\n";
            } else {
                $groups[$parent] = [];
            }
            $groups[$parent][] = array_map('trim', $lineParsed);
        }
        return $groups;
    }
}