<?php
namespace App\Trie;

class Trie {
    /* root TrieNode stores the first characters */
    private $root;

    function __construct() {
        $this->root = new TrieNode(-1);
    }

    static $asciiValues = array(
        "a" => 0,
        "b" => 1,
        "c" => 2,
        "d" => 3,
        "e" => 4,
        "f" => 5,
        "g" => 6,
        "h" => 7,
        "i" => 8,
        "j" => 9,
        "k" => 10,
        "l" => 11,
        "m" => 12,
        "n" => 13,
        "o" => 14,
        "p" => 15,
        "q" => 16,
        "r" => 17,
        "s" => 18,
        "t" => 19,
        "u" => 20,
        "v" => 21,
        "w" => 22,
        "x" => 23,
        "y" => 24,
        "z" => 25
    );

    function insert($string, $weight) {
        $currentNode = $this->root;
        $l = strlen($string);
        for ($i = 0; $i < $l; $i++) {
            $char = self::$asciiValues[$string[$i]];
            $currentNode->weight = max($weight, $currentNode->weight);
            if($currentNode->isChild($char)) {
                $childNode = $currentNode->getChild($char);
            } else {
                $childNode = new TrieNode($weight);
                $currentNode->addChild($char, $childNode);
            }
            $currentNode = $childNode;
        }
    }

    function getNodeWeight($string) {
        $currentNode = $this->root;
        $l = strlen($string);
        for ($i = 0; $i < $l; $i++) {
            $char = self::$asciiValues[$string[$i]];
            if (!$currentNode->isChild($char)) {
                return -1;
            }
            $currentNode = $currentNode->getChild($char);
        }
        return $currentNode->weight;
    }
}
