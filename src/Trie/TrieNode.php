<?php
namespace App\Trie;

class TrieNode {
    // weight is needed for the given problem
    public $weight;
    /* TrieNode children,
    * e.g. [0 => (TrieNode object1), 2 => (TrieNode object2)]
    * where 0 stands for 'a', 2 for 'c'
    * and TrieNode objects are references to other TrieNodes.
    */
    private $children;

    function __construct($weight) {
        $this->weight = $weight;
        $this->children = [];
    }

    function addChild($char, $node) {
        $this->children[$char] = $node;
    }

    function isChild($char) {
        return isset($this->children[$char]);
    }

    function getChild($char) {
        return $this->children[$char];
    }
}