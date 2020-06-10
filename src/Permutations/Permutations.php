<?php


namespace App\Permutations;


class Permutations
{
    public static function make(array $items, array $perms = []) : array
    {
        if (! $items) {
            $return = array($perms);
        }  else {
            $return = array();
            for ($i = count($items) - 1; $i >= 0; --$i) {
                $newitems = $items;
                $newperms = $perms;
                list($foo) = array_splice($newitems, $i, 1);
                array_unshift($newperms, $foo);
                $return = array_merge($return, self::make($newitems, $newperms));
            }
        }

        return $return;
    }

}
