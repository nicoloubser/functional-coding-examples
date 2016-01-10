<?php

/**
 * memoization is the technique of caching function results. PHP doesn't support it out of the box, but can emulate it using the static keyword. *
 */

$memoize = function($val)
{
    static $cache = [];

    $key = md5($val);

    if ( ! isset($cache[$key])) {
        // Imagine this is doing something huge
        sleep(5);
        $cache[$key] = $val * 10;
    }

    return $cache[$key];
};

echo "---\n";
$memoize(2);
echo "Job 1 finished\n";
$memoize(2);
echo "Job 2 finished\n";
$memoize(2);
echo "Job 3 finished\n";
echo "Passing a new value, so we need to recalc...\n";
$memoize(3);
echo "Job 4 finished\n";
echo "Passing a memoized value, this should be quick...\n";
$memoize(2);
echo "Job 5 finished\n";

