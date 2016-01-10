<?php

/**
 * This is just a random class to give me some objects to work with. THey all have the __invoke method
 */

interface Comparable
{
    // We want logic to make things comparable in here
    public function __invoke();
}

class Car implements Comparable
{
    public $value;

    public function __construct($val)
    {
	    $this->setValue($val);
    }

    public function __invoke()  
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}

class Motorcycle implements Comparable
{
    public $value;

    public function __construct($val)
    {
	    $this->setValue($val);
    }

    public function __invoke()
    {
	    return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
