<?php

/**
 * This code compares imperative code against functional code.
 * The imperative code was hacked out in about 10 minutes, I didn't care much about optimising it.
 *
 * The functional code was very interesting to write, and took much longer than 10 minutes, it is also slower than it imperative counterpart.
 * This is a strong argument for imperative coding. This code should be seen as an experiment in functional programming, and not to promote it.
 *
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$list = [];
echo "Generating numbers \n";
for ($itr=0; $itr<1000000; $itr++) {
	$list[$itr] = $itr;	
}
echo "Done \n";

$searchFor = 45215;
$search = true;
$arrayPortion = $list;
$itr=0;

$timeStart = microtime_float();

/**
 * Imperative binary search algorithm
 */

while ($search) {

	if ($searchFor > (int)$arrayPortion[(int)(count($arrayPortion)/2)]) {
        $arrayPortion = array_slice($arrayPortion, (int)(count($arrayPortion)/2), (count($arrayPortion) - (int)(count($arrayPortion)/2)));
	} elseif ($searchFor < $arrayPortion[(int)(count($arrayPortion)/2)]) {
        $arrayPortion = array_slice($arrayPortion, 0, (int)(count($arrayPortion)/2));
	} elseif ($searchFor == $arrayPortion[(int)(count($arrayPortion)/2)]) {
		$index = (int)(count($arrayPortion)/2);
	    $search = false;
	}
    $itr++;
}

$timeEnd = microtime_float();

echo 'Imperative Duration : ' . ($timeEnd - $timeStart) . "\n";



/**
 * Functional section
 */

/**
 * Passes state on. THey are normally good candidates for memoisation, but they do so little that it has little effect.
 */
function middleElement($array) {
    return $array[(int)count($array)/2];
}

function arrayMiddle($array) {
    return count($array)/2;
}

/**
 * Predicate functions
 */
function biggerThanOrEqual($array, $searchFor) {
    return $searchFor >= middleElement($array);
}

function equals($array, $searchFor) {
    return $searchFor == middleElement($array);
}

/**
 *
 * Uses currying, sort of.... But this also allows for us to handle a function instead of a variable inside binary
 */
$curry = function($array, $searchFor) {
    $data = biggerThanOrEqual($array, $searchFor)
        ? array_splice($array, arrayMiddle($array))
        : array_splice($array, 0, arrayMiddle($array));

    return function() use ($data) {
        return $data;
    };
};

/**
 * Main recursive function
 */
function binary($array, $search, callable $function, $itr) {
    $returnData = $function($array, $search);
    return equals($returnData(), $search) || empty($returnData()) || count($returnData()) == 1
        ? equals($returnData(), $search)
        : binary($returnData(), $search, $function, $itr);
}

$timeStart = microtime_float();

$val = binary($list, $searchFor, $curry, 0);

$timeEnd = microtime_float();

echo "Functional Duration : " .($timeEnd - $timeStart) . "\n";
























