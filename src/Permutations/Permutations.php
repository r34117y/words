<?php


namespace App\Permutations;


class Permutations
{
    private static function permutate($values, $size, $offset)
    {
        $count = count($values);
        $array = [];
        for ($i = 0; $i < $size; $i++) {
            $selector = ($offset / pow($count,$i)) % $count;
            $array[$i] = $values[$selector];
        }
        return $array;
    }

    public static function permutations($values, $size) : array
    {
        $a = [];
        $c = count($values) ** $size;
        for ($i = 0; $i < $c; $i++) {
            $a[$i] = self::permutate($values, $size, $i);
        }
        return $a;
    }
}