<?php

class Vehicle
{
	public $id;
	public $type;
	public $color;
	public $sold;
    public $price;
    public $mileage;

	public function __construct($id, $type, $color, $sold, $price, $mileage) {
		$this->id = $id;
		$this->type = $type;
		$this->color = $color;
		$this->sold = $sold;
        $this->price = $price;
        $this->mileage = $mileage;
	}

	public function __invoke($array) 
	{
        return $array[2] == $this->$array[0];
	}
}

// Dataset to operate on

$list = [
	new Vehicle(1,'truck', 'green', true, 1000, 120),
	new Vehicle(2,'bike', 'red', false, 100, 200),
	new Vehicle(3,'car', 'red', true, 500, 200),
	new Vehicle(4,'bike', 'blue', false, 800, 300),
	new Vehicle(5,'car', 'red', true, 700, 150),
	new Vehicle(6,'car', 'blue', true, 200, 200),
];


// This type of ruleset will allow for a lot of flexibility, but asks for more complex code.
$ruleSet = [
    0 => ['color', '=', 'red'],
    1 => ['type', '=', 'car'],
    // 2 => ['mileage', '=', 200],
];

// This function applies the rules to the object passed to it via the fmap function
$ruleFunction = function($ruleSet) {
    $apply = function($object, $index=0) use ($ruleSet, &$apply) {

        $done = function($index, $ruleSet) {
            return $index == count($ruleSet) ? 150 : 0;
        };

        return $done($index, $ruleSet) || !$object($ruleSet[$index])
            ? $done($index, $ruleSet)
            : $apply($object, ++$index);

    };
    return $apply;
};

$function = $ruleFunction($ruleSet);

// The functor knows how to unpack the object, and how to apply the lambda/closure
// We are also keeping to the single assignment rule of functional programming
$fmap = function ($function, $object)
{
    return new $object(
        $object->id,
	    $object->type,
	    $object->color,
	    $object->sold,
	    $object->price - $function($object),
        $object->mileage
    );
};

// Applying the rules to the dataset using array_map
$val = array_map(function($object) use ($fmap, $function) {
    return $fmap($function, $object);		
}, $list);

var_dump($val);
