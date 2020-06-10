<?php

namespace App\SuccessorMatrix;


use App\Parser\AbstractDictParser;
use App\Permutations\Permutations;
use App\Utils\StringHelper;

class SuccessorMatrix
{

    /** @var string[]  */
    private $words;

    private $matrix;

    /** @var AbstractDictParser */
    private $parser;

    public function __construct(array $options = [])
    {
        if (isset($options['parser'])) {
            $this->parser = $options['parser'];
        }
        if (isset($options['json'])) {
            $this->matrix = $this->getFromFile($options['json']);
        } else {
            $this->createMatrix();
        }
    }

    /**
     * Tworzy macierz następników wraz z prawdopodobieństwami
     */
    private function createMatrix() : void
    {
        foreach ($this->getWords() as $word) {
            $letters = StringHelper::stringToArray($word, true);
            $l = count($letters);
            for ($i = 0; $i < $l - 1; $i++) {
                if (! array_key_exists($letters[$i], $this->matrix)) {
                    $this->matrix[$letters[$i]] = ['total' => 0, 'last' => 0];
                }
                if (! array_key_exists($letters[$i + 1], $this->matrix[$letters[$i]])) {
                    $this->matrix[$letters[$i]][$letters[$i + 1]] = 0;
                }
                $this->matrix[$letters[$i]]['total']++;
                $this->matrix[$letters[$i]][$letters[$i + 1]]++;
            }
            // dla ostatniej litery ustawiamy prawdopopodobieństwo bycia ostatnią
            if (! array_key_exists($letters[$l - 1], $this->matrix)) {
                $this->matrix[$letters[$l - 1]] = ['total' => 0, 'last' => 0];
            }
            $this->matrix[$letters[$l - 1]]['total']++;
            $this->matrix[$letters[$l - 1]]['last']++;
        }
    }

    public function getMatrix() : array
    {
        if (! $this->matrix) {
            $this->createMatrix();
        }

        return $this->matrix;
    }

    public function getFromFile(string $path)
    {
        $json = file_get_contents($path);
        return json_decode($json, true);
    }

    public function saveJson(string $path) {
        if (! $this->matrix) {
            $this->createMatrix();
        }

        file_put_contents($path, json_encode($this->matrix));
    }

    private function getProb(string $a, string $b) {
        if (! isset($this->matrix[$a][$b])) {
            return 0;
        }

        return $this->matrix[$a][$b] / $this->matrix[$a]['total'];
    }

    /**
     * Zwraca sumę (odległość) dla danej tablicy znaków
     */
    private function getWordProb(array $letters) : float
    {
        $prob = 0;
        $c = count($letters);
        for ($i = 0; $i < $c - 1; $i++) {
            $prob += $this->getProb($letters[$i], $letters[$i+1]);
        }

        return $prob;
    }

    /**
     * Zwraca posortowaną tablicę odległości w postaci:
     * 'permutacja' => 0.1,
     * 'premutacja' => 0.2,
     * etc.
     */
    public function getRanks(string $word)
    {
        $letters = StringHelper::stringToArray($word);
        $permutations = Permutations::make($letters);
        $ranks = [];
        foreach ($permutations as $permutation) {
            $ranks[implode('', $permutation)] = $this->getWordProb($permutation);
        }
        asort($ranks);
        return $ranks;
    }

    public function showLeaders()
    {
        foreach ($this->getWords() as $word) {
            if (mb_strlen($word) === 8) {
                $ranks = $this->getRanks($word);
                if ($ranks[$word] === array_pop($ranks)) {
                    echo $word;
                    echo "\n";
                }
            }
        }
    }

    private function getWords() : array
    {
        if (! $this->words) {
            $this->words = $this->parser->getFlatWordsArray();
        }

        return $this->words;
    }
}
