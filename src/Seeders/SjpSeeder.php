<?php


namespace App\Seeders;


use App\Parser\AbstractDictParser;
use App\Parser\SjpParser;
use App\Utils\StringHelper;

class SjpSeeder
{
    public function __construct()
    {
        $words = (new SjpParser())->makeGroupedWordsArray();
        $csvArray = [];
        $id = 1;

        foreach ($words as $parent => $childrenArrays) {
            foreach ($childrenArrays as $wordsArray) {
                $parentId = $id;
                $csvArray[] = [$id, $parent, $parentId, StringHelper::sortString($parent)];
                $id ++;

                foreach ($wordsArray as $word) {
                    $csvArray[] = [$id, $word, $parentId, StringHelper::sortString($word)];
                    $id++;
                }
            }
        }

        $csvStr = '';
        foreach ($csvArray as $line) {
            $csvStr .= (implode(',', $line) . "\n");
        }

        file_put_contents('sjp_bulk_insert.csv', $csvStr);
    }
}