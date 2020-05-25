<?php


namespace App\Statistics;


use App\Parser\AbstractDictParser;
use App\Parser\OspsParser;
use App\Utils\StringHelper;

class LettersDistribution
{
    /** @var AbstractDictParser */
    private $parser;

    /** @var string */
    private $prefix;

    public function __construct(AbstractDictParser $parser, string $prefix = '')
    {
        $this->parser = $parser;
        $this->prefix = $prefix;
    }
    public function createLetters()
    {
        $dist = [];
        $words = $this->parser->getFlatWordsArray();

        foreach ($words as $word) {
            $letters = StringHelper::stringToArray($word);
            foreach ($letters as $letter) {
                if (array_key_exists($letter, $dist)) {
                    $dist[$letter]++;
                } else {
                    $dist[$letter] = 1;
                }
            }
        }
        $cl = array_sum($dist);
        $cw = count($words);
        $mean = $cl/$cw;
        echo "Mamy {$cl} liter w {$cw} słowach, co daje średnio {$mean} liter na słowo.\n";
        file_put_contents($this->prefix . 'letters_dist_all', json_encode($dist));

        $labels = [];
        $values = [];

        ksort($dist);

        foreach ($dist as $letter => $value) {
            $labels[] = $letter;
            $values[] = $value;
        }

        file_put_contents($this->prefix . 'letters_dist_all_lv', json_encode([
            'labels' => $labels,
            'values' => $values,
        ]));
    }

    public function createLengths()
    {
        $dist = [];
        $words = $this->parser->getFlatWordsArray();

        foreach ($words as $word) {
            $length = mb_strlen($word);
            if (array_key_exists($length, $dist)) {
                $dist[$length]++;
            } else {
                $dist[$length] = 1;
            }
        }
        file_put_contents($this->prefix . 'words_length_dist', json_encode($dist));

        $labels = [];
        $values = [];

        ksort($dist);

        foreach ($dist as $length => $value) {
            $labels[] = $length;
            $values[] = $value;
        }

        file_put_contents($this->prefix . 'words_length_dist_lv', json_encode([
            'labels' => $labels,
            'values' => $values,
        ]));
    }

    /**
     * Tworzy dwuwymiarową tablicę zliczającą wystąpienia danej litery
     * jeżeli była poprzedzona inną literą:
     * ['a' => ['a' => 10, 'b' => 5], 'b' => ['a' => 13, 'b' => 1]]
     */
    public static function createPreviousAndNextDist()
    {
        $words = (new OspsParser())->getFlatWordsArray();
        $next = [];
        $prev = [];

        foreach ($words as $word) {
            $letters = StringHelper::stringToArray($word);
            $length = mb_strlen($word);
            for ($i = 0; $i < $length; $i++) {
                if ($i > 0) {
                    if (array_key_exists($letters[$i], $prev)) {
                        $prev[$letters[$i]]++;
                    } else {
                        $prev[$letters[$i]][$letters[$i - 1]] = 1;
                    }
                }
            }
        }
    }
}