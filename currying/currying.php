<?php
/**

Currying is the technique of transforming a function that takes multiple
arguments in such a way that it can be called as a chain of functions each
with a single argument.

*/

/**
 * First example
 */
$start = function($start) {
    return function($length) use ($start) { // <-- early binding. for late binding add &
        return function($string) use ($start, $length) {
            return substr($string, $start, $length);
        };
    };
};

// Note how we are assigning the first of the inner functions to the variable. The variable is now a
$end = $start(0);
$toTrim = $end(5);

echo $toTrim('123456789')."\n";
echo $toTrim('abcdefghi')."\n";

$toTrim = $end(4);

echo $toTrim('123456789')."\n";
echo $toTrim('abcdefghi')."\n";

$toTrim = $end(1);
echo $toTrim('123456789')."\n";

/**
 * Second example
 */

$data = [
    1,
    2,
    3,
    4,
    5,
    6,
    7,
    8,
    9
];

$glueComma = ',';
$gluePipe = '|';

// Pass by reference and pass by value changes behaviour. ALso called late and early binding
$toImplode = function(&$array) { // <-- early binding. for late binding add &
    return function($glue) use ($array) {
        return implode($glue, $array);
    };
};

$implode = $toImplode($data);

//Depending on early or late binding, this line of code will affect the $implode function
$data=[];

echo $implode($glueComma);
echo "\n";
echo $implode($gluePipe);
