<?php
namespace App\MagicSquare;

use App\Parser\OspsParser;
use App\Utils\StringHelper;

class MagicSquare
{
    /**
     * @param array $words - zakładam, że mają tę samą długość
     */
    public function make(array $words) {
        $wLength = mb_strlen($words[0]);

        $c = count($words);
        $iterations = $c** $wLength;
        $done = 0;
        echo "Znaleziono {$c} wyrazów {$wLength}-literowych ({$iterations}) iteracji przed nami.\n";

        for ($i = 2; $i < $wLength; $i++) {
            $starts = file_get_contents("data/{$wLength}_starts_{$i}");
            $starts{$i} = array_flip(explode("\n", $starts));
        }
    }
    public static function createFives()
    {
        $wordString = file_get_contents('data/piatki');
        $words = explode("\n", $wordString);
        //$words = array_flip($words);

        $vs2 = file_get_contents('data/5_starts_2');
        $vs2 = explode("\n", $vs2);
        $vs2 = array_flip($vs2);

        $vs3 = file_get_contents('data/5_starts_3');
        $vs3 = explode("\n", $vs3);
        $vs3 = array_flip($vs3);

        $vs4 = file_get_contents('data/5_starts_4');
        $vs4 = explode("\n", $vs4);
        $vs4 = array_flip($vs4);

        $c = count($words);
        $iterations = $c*$c*$c*$c*$c;
        $done = 0;
        echo "Znaleziono {$c} wyrazów 5-literowych ({$iterations}) iteracji przed nami.\n";

        for ($i = 0; $i < $c; $i++) {
            echo "Nowy wyraz pierwszego poziomu: {$words[$i]}\n";
            for ($j = 0; $j < $c; $j++) {
                echo "Nowy wyraz drugiego poziomu: {$words[$i]} + {$words[$j]}\n";
                for ($k = 0; $k < $c; $k++) {
                    for ($l = 0; $l < $c; $l++) {
                        for ($m = 0; $m < $c; $m++) {
                            $w1 = $words[$i];
                            $w2 = $words[$j];
                            $w3 = $words[$k];
                            $w4 = $words[$l];
                            $w5 = $words[$m];

                            $w1s = StringHelper::stringToArray($w1);
                            $w2s = StringHelper::stringToArray($w2);
                            $w3s = StringHelper::stringToArray($w3);
                            $w4s = StringHelper::stringToArray($w4);
                            $w5s = StringHelper::stringToArray($w5);

                            $c1 = $w1s[0] . $w2s[0] . $w3s[0] . $w4s[0] . $w5s[0];
                            $c2 = $w1s[1] . $w2s[1] . $w3s[1] . $w4s[1] . $w5s[1];
                            $c3 = $w1s[2] . $w2s[2] . $w3s[2] . $w4s[2] . $w5s[2];
                            $c4 = $w1s[3] . $w2s[3] . $w3s[3] . $w4s[3] . $w5s[3];
                            $c5 = $w1s[4] . $w2s[4] . $w3s[4] . $w4s[4] . $w5s[4];

                            // jeśli któraś kolumna nie może utworzyć wyrazu
                            //to przeskakujemy do drugiej iteracji
                            if (! (array_key_exists(mb_substr($c1,0,2), $vs2) &&
                                array_key_exists(mb_substr($c2,0,2), $vs2) &&
                                array_key_exists(mb_substr($c3,0,2), $vs2) &&
                                array_key_exists(mb_substr($c4,0,2), $vs2) &&
                                array_key_exists(mb_substr($c5,0,2), $vs2)
                            )) {
                                echo "Brejkam!: {$w1} + {$w2}\n";
                                $done += $c ** 3;
                                break 3;
                            }

                            if (! (array_key_exists(mb_substr($c1,0,3), $vs3) &&
                                array_key_exists(mb_substr($c2,0,3), $vs3) &&
                                array_key_exists(mb_substr($c3,0,3), $vs3) &&
                                array_key_exists(mb_substr($c4,0,3), $vs3) &&
                                array_key_exists(mb_substr($c5,0,3), $vs3)
                            )) {
                                $done += $c ** 2;
                                break 2;
                            }

                            if (! (array_key_exists(mb_substr($c1,0,4), $vs4) &&
                                array_key_exists(mb_substr($c2,0,4), $vs4) &&
                                array_key_exists(mb_substr($c3,0,4), $vs4) &&
                                array_key_exists(mb_substr($c4,0,4), $vs4) &&
                                array_key_exists(mb_substr($c5,0,4), $vs4)
                            )) {
                                $done += $c;
                                break 1;
                            }

                            //przekątne
                            $d1 = $w1s[0] . $w2s[1] . $w3s[2] . $w4s[3] . $w5s[4];
                            $d2 = $w1s[4] . $w2s[3] . $w3s[2] . $w4s[1] . $w5s[0];

                            if (in_array($c1, $words) && in_array($c2, $words) && in_array($c3, $words) && in_array($c4, $words) && in_array($c5, $words)) {
                                echo "Znaleziono magiczny kwadrat:\n";
                                echo "{$w1}\n";
                                echo "{$w2}\n";
                                echo "{$w3}\n";
                                echo "{$w4}\n";
                                echo "{$w5}\n";
                                if (in_array($d1, $words) && in_array($d2, $words)) {
                                    echo "KWADRAT FULL MAGICZNY!!!";
                                    file_put_contents('magic5full', "{$w1}\n{$w2}\n{$w3}\n{$w4}\n{$w5}\n\n", FILE_APPEND);
                                }
                                file_put_contents('magic5', "{$w1}\n{$w2}\n{$w3}\n{$w4}\n{$w5}\n\n", FILE_APPEND);
                            }

                            $done++;
                            if ($done % 100000 === 0) {
                                $percent = round(($done / $iterations) * 100, 2);
                                echo "Zbadano {$done} z {$iterations} ({$percent}%)\n";
                            }
                        }
                    }
                }
            }
        }
    }
    public static function createFours()
    {
        $wordString = file_get_contents('data/czworki');
        $words = explode("\n", $wordString);
        //tablica z dwójkami od których zaczynają się wyrazy, co by unikać
        //niepotrzebnych pierdyliardów iteracji 32*32=1024 możliwości
        //a mamy 427 - zawsze coś.
        $vS = file_get_contents('data/4_starts_2');
        $vS = explode("\n", $vS);

        $vS3 = file_get_contents('data/4_starts_3');
        $vS3 = explode("\n", $vS3);

        $c = count($words);
        $iterations = $c*$c*$c*$c;
        $done = 0;
        echo "Znaleziono {$c} wyrazów czteroliterowych ({$iterations}) iteracji przed nami.\n";

        for ($i = 0; $i < $c; $i++) {
            echo "Nowy wyraz pierwszego poziomu: {$words[$i]}\n";
            for ($j = 0; $j < $c; $j++) {
                echo "Nowy wyraz drugiego poziomu: {$words[$i]} + {$words[$j]}\n";
                for ($k = 0; $k < $c; $k++) {
                    for ($l = 0; $l < $c; $l++) {
                        $w1 = $words[$i];
                        $w2 = $words[$j];
                        $w3 = $words[$k];
                        $w4 = $words[$l];

                        $w1s = StringHelper::stringToArray($w1);
                        $w2s = StringHelper::stringToArray($w2);
                        $w3s = StringHelper::stringToArray($w3);
                        $w4s = StringHelper::stringToArray($w4);

                        $c1 = $w1s[0] . $w2s[0] . $w3s[0] . $w4s[0];
                        $c2 = $w1s[1] . $w2s[1] . $w3s[1] . $w4s[1];
                        $c3 = $w1s[2] . $w2s[2] . $w3s[2] . $w4s[2];
                        $c4 = $w1s[3] . $w2s[3] . $w3s[3] . $w4s[3];

                        // jeśli któraś kolumna nie może utworzyć wyrazu
                        //to przeskakujemy do drugiej iteracji
                        if (! (array_key_exists(mb_substr($c1,0,2), $vS) &&
                            array_key_exists(mb_substr($c2,0,2), $vS) &&
                            array_key_exists(mb_substr($c3,0,2), $vS) &&
                            array_key_exists(mb_substr($c4,0,2), $vS)
                        )) {
                            echo "Brejkam!: {$w1} + {$w2}\n";
                            $done += 68442529;
                            break 2;
                        }

                        // może też trochę przyspieszy - TAK
                        if (! (array_key_exists(mb_substr($c1,0,3), $vS3) &&
                            array_key_exists(mb_substr($c2,0,3), $vS3) &&
                            array_key_exists(mb_substr($c3,0,3), $vS3) &&
                            array_key_exists(mb_substr($c4,0,3), $vS3)
                        )) {
                            $done += 8273;
                            break 1;
                        }

                        //przekątne
                        $d1 = $w1s[0] . $w2s[1] . $w3s[2] . $w4s[3];
                        $d2 = $w1s[3] . $w2s[2] . $w3s[1] . $w4s[0];

                        if (array_key_exists($c1, $words) && array_key_exists($c2, $words) && array_key_exists($c3, $words) && array_key_exists($c4, $words)) {
                            echo "Znaleziono magiczny kwadrat:\n";
                            echo "{$w1}\n";
                            echo "{$w2}\n";
                            echo "{$w3}\n";
                            echo "{$w4}\n";
                            if (array_key_exists($d1, $words) && array_key_exists($d2, $words)) {
                                echo "KWADRAT FULL MAGICZNY!!!";
                                file_put_contents('magic4full', "{$w1}\n{$w2}\n{$w3}\n{$w4}\n\n", FILE_APPEND);
                            }
                            file_put_contents('magic4', "{$w1}\n{$w2}\n{$w3}\n{$w4}\n\n", FILE_APPEND);
                        }

                        $done++;
                        if ($done % 100000 === 0) {
                            $percent = round(($done / $iterations) * 100, 2);
                            echo "Zbadano {$done} z {$iterations} ({$percent}%)\n";
                        }
                    }
                }
            }
        }
    }
    public static function create() : array
    {
        $parser = new OspsParser();
        $wordString = file_get_contents('data/trojki');
        $words = explode("\n", $wordString);
        $c = count($words);
        $iterations = $c*$c*$c;
        $done = 0;
        echo "Znaleziono {$c} wyrazów trzyliterowych";

        for ($i = 0; $i < $c; $i++) {
            for ($j = 0; $j < $c; $j++) {
                for ($k = 0; $k < $c; $k++) {
                    $w1 = $words[$i];
                    $w2 = $words[$j];
                    $w3 = $words[$k];

                    $w1s = StringHelper::stringToArray($w1);
                    $w2s = StringHelper::stringToArray($w2);
                    $w3s = StringHelper::stringToArray($w3);

                    $c1 = $w1s[0] . $w2s[0] . $w3s[0];
                    $c2 = $w1s[1] . $w2s[1] . $w3s[1];
                    $c3 = $w1s[2] . $w2s[2] . $w3s[2];

                    //przekątne
                    $d1 = $w1s[0] . $w2s[1] . $w3s[2];
                    $d2 = $w1s[2] . $w2s[1] . $w3s[0];

                    if (array_key_exists($c1, $words) && array_key_exists($c2, $words) && array_key_exists($c3, $words)) {
                        echo "Znaleziono magiczny kwadrat:\n";
                        echo "{$w1}\n";
                        echo "{$w2}\n";
                        echo "{$w3}\n";
                        if (array_key_exists($d1, $words) && array_key_exists($d2, $words)) {
                            echo "KWADRAT FULL MAGICZNY!!!";
                            file_put_contents('magic3full', "{$w1}\n{$w2}\n{$w3}\n\n", FILE_APPEND);
                        }
                        file_put_contents('magic3', "{$w1}\n{$w2}\n{$w3}\n\n", FILE_APPEND);
                    }

                    $done++;
                    if ($done % 1000 === 0) {
                        echo "Zbadano {$done} z {$iterations}\n";
                    }
                }
            }
        }
    }
}