<?php

namespace Framework\Core;

use ArrayObject;

class Collection extends ArrayObject implements \JsonSerializable{

    protected $array = [];


    public function __construct(array $collection) {
        $this->array = $collection;
    }

    public function first() {
        return isset($this->array[0]) ? $this->array[0] : null;
    }


    public function get($max = -1) {
        if ($max != -1) {
            return array_slice($this->array, 0, $max);
        }
        return $this->array;
    }

    public function last() {
        return end($this->array);
    }

    public function with(string ...$args) {
        foreach ($args as $arg) {
            foreach ($this->array as &$element) {
                $element->{$arg} = call_user_func_array(array($element, "load"), $args);
            }
        }
        return $this;
    }


    public function map($callback) : array {
        $collection = [];
        foreach($this->array as $index=>$element){
           $collection[] = $callback($element, $index); 
        }
        return $collection;
    }

    public function jsonSerialize(){
        return $this->array;
    }
}
