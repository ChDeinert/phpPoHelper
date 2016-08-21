<?php

namespace ChDeinert\phpPoHelper\Collections;

/**
 * Class to enable Functional Programming with Collections
 */
class Functional
{
    protected $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function map($func)
    {
        $result = [];

        foreach ($this->items as $key => $val) {
            $result[] = $func($val, $key);
        }

        return new Functional($result);
    }

    public function reduce($func, $initial)
    {
        $accumulator = $initial;

        foreach ($this->items as $item) {
            $accumulator = $func($accumulator, $item);
        }

        return $accumulator;
    }
}
