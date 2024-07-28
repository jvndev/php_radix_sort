<?php

require __DIR__ . '/RadixSort.php';

// Test data
function createDataArr($len, $max)
{
    $retArr = [];

    for ($i = 0; $i < $len; $i++)
        array_push($retArr, rand(0, $max));

    return $retArr;
}

function arrToStr($arr)
{
    if (!$arr)
        return null;

    return array_reduce($arr, function ($p, $c) {
        return $p ? "$p $c" : $c;
    }, '');
}

function testArrAsc($arr) {
    $isSorted = true;

    for ($i = 1; $i < count($arr); $i++)
        $isSorted &= $arr[$i] >= $arr[$i - 1];

    return $isSorted;
}

echo arrToStr($dataArr = createDataArr(10, 999)) . "\n";
echo arrToStr($sortedArr = RadixSort::sort($dataArr)) . "\n";
assert((testArrAsc($sortedArr)), 'Sort failed');
