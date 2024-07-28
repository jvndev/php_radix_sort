<?php

require __DIR__ . '/vendor/autoload.php';

use Jaco\Datastructures\Queue;

/*
* Can only be used on integers for now.
* Not very efficient. O(n*n) I think.
* Not async friendly.
*/

final class RadixSort
{
    private function __construct() { }

    private static function createBins()
    {
        $bins = [];

        for ($i = 0; $i < 10; $i++)
            $bins = [...$bins, new Queue()];

        return $bins;
    }

    private static function maxRadix($data)
    {
        $max = array_reduce($data, function ($p, $c) {
            return max($p, $c);
        }, PHP_INT_MIN);

        $radix = 10;

        for (; $max % $radix != $max; $radix *= 10);

        return $radix;
    }

    private static function assignToBin($val, $bins, $radix)
    {
        $bins[$radix]->enqueue($val);
    }

    private static function emptyBins($bins)
    {
        $retArr = [];

        foreach ($bins as $bin)
            while (!$bin->isEmpty())
                array_push($retArr, $bin->dequeue());

        return $retArr;
    }

    public static function sort($data)
    {
        $bins = self::createBins();
        $maxRadix = self::maxRadix($data);

        for ($i = 10; $i <= $maxRadix; $i *= 10) {
            foreach ($data as $val) {
                $radix = floor(($val % $i) / ($i / 10));
                self::assignToBin($val, $bins, $radix);
            }

            $data = self::emptyBins($bins);
        }

        return $data;
    }
}