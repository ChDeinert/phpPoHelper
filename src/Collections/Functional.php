<?php

namespace ChDeinert\phpPoHelper\Collections;

/**
 * Class to enable Functional Programming with Collections
 */
class Functional
{
    protected $items;

    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Map Method that returns a new Functional Collection
     *
     * @param  function $func
     * @return ChDeinert\phpPoHelper\Collections\Functional
     */
    public function map($func)
    {
        $result = [];

        foreach ($this->items as $key => $val) {
            $result[] = $func($val, $key);
        }

        return new Functional($result);
    }

    /**
     * Reduce Method
     *
     * @param  function $func
     * @param  mixed $initial
     * @return mixed
     */
    public function reduce($func, $initial)
    {
        $accumulator = $initial;

        foreach ($this->items as $item) {
            $accumulator = $func($accumulator, $item);
        }

        return $accumulator;
    }
}
