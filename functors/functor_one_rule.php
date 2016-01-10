<?php

class Vehicle
{
	public $id;
	public $type;
	public $color;
	public $sold;
    public $price;

	public function __construct($id, $type, $color, $sold, $price) {
		$this->id = $id;
		$this->type = $type;
		$this->color = $color;
		$this->sold = $sold;
		$this->price = $price;
	}

	public function __invoke() 
	{
		return $this->color;
	}
}

// Data set
$list = [
	new Vehicle(1,'car', 'red', true, 1000),
	new Vehicle(1,'car', 'red', false, 100),
	new Vehicle(1,'car', 'red', true, 500),
	new Vehicle(1,'bike', 'blue', false, 800),
	new Vehicle(1,'car', 'red', true, 700),
	new Vehicle(1,'car', 'blue', true, 200),
];


// This function applies the rules to the object unpacked with the fmap function
$func = function($object) {
	return $object() == 'red' ? 100 : 0;
};

// The fmap functor knows how to unpack the object, and how to apply the lambda/closure
// We are also keeping to the single assignment rule of functional programming
$fmap = function (callable $function, $object)
{
    // The functor knows how to unpack the object, and how to apply the lambda/closure
	return new $object(
		$object->id,
		$object->type,
		$object->color,
		$object->sold, 
		$object->price - $function($object)
	);
};

$newList = array_map(function($object) use ($fmap, $func) {
    return $fmap($func, $object);
}, $list);

var_dump($newList);