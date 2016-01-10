<?php
/**
 * maybe monad. It helps with fkuent interfaces where a value is expected but absent, breaking the chain of functions.
 */
class Vehicle
{
    public $id;
    public $type;
    public $color;
    public $sold;
    public $price;

    public function __construct($id, $type, $color, $mileage, $sold, $price) {
        $this->id = $id;
        $this->type = $type;
        $this->color = $color;
        $this->mileage = $mileage;
        $this->sold = $sold;
        $this->price = $price;
    }

    public function __invoke($array)
    {
        return $array[2] == $this->$array[0];
    }
}

class Maybe
{
    public $container = null;

    public function __construct($value)
    {
        $this->set($value);
    }

    public function get()
    {
        return $this->container;
    }

    public function set($value)
    {
        $this->container = $value;
    }

    // Responsible for binding an object to a monad
    public static function unit($value)
    {
        if( $value instanceof Maybe ) {
            return $value;
        }
        return new static($value);
    }

    // Places an object into the monad if the isNothing function returns true
    public function bind(callable $function)
    {
        return $this->isNothing() ? $this : static::unit($function($this->container));
    }

    public function isNothing()
    {
        return $this->container === false;
    }
}

// Object to test
$vehicle = new Vehicle(1,'golf', 'red', 12000, true, 1000);

// Ruleset for type, color and mileage
$type = function($value) {
    return Maybe::unit($value->type == 'golf' ? $value : false);
};

$color = function($value) {
    return Maybe::unit($value->color == 'red' ? $value : false);
};

$mileage = function($value) {
    return Maybe::unit($value->mileage == 12000 ? $value : false);
};

// Execution. On success an object will be returned
$test = Maybe::unit($vehicle)->bind($type)->bind($color)->bind($mileage);

var_dump($test->get());