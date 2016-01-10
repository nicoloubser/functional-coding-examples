<?php

include 'classes.php';

// We pass the object which has the ability to be a functor, so I am typehinting my function with Callable
function carDepreciation(Callable $vehicle)
{
    return ($vehicle()/100)*90;
}

echo carDepreciation(new Car(60));

$car = new Car(1000);
$motorcycle = new Motorcycle(1100);

if ($car() > $motorcycle()) {
    echo "\nCar is the heaviest";
} else {
    echo "\nMotorcycle is the heaviest";
}
