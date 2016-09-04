<?php

namespace ChDeinert\phpPoHelper\Test;

use ChDeinert\phpPoHelper\Collections\Functional;

class FunctionalTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    public function tearDown()
    {
    }

    /**
     * @test
     */
    public function mapReturnsAFunctionalCollection()
    {
        $testCollection = new Functional([]);
        $returnValue = $testCollection->map(function($value) {
            return $value;
        });

        $this->assertInstanceOf(Functional::class, $returnValue);
    }

    /**
     * @test
     */
    public function returnedCollectionFromMapHasCorrectValues()
    {
        $testArray = [
            'foo' => 'foo',
            'bar' => 'bar',
        ];
        $testCollection = new Functional($testArray);

        $expected = new Functional(['foo', 'bar']);
        $actual = $testCollection->map(function($value) {
            return $value;
        });

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function reduceReturnsInitialIfNoItemsInCollection()
    {
        $testCollection = new Functional([]);

        $returnValue = $testCollection->reduce(function($acc, $item) {
            return $acc.$item;
        }, 'foo');

        $this->assertEquals('foo', $returnValue);
    }

    /**
     * @test
     */
    public function reduceCorrectlyUsesTheGivenFunction()
    {
        $testArray = [
            0 => [
                0 => 'foo',
            ],
            1 => [
                0 => 'bar',
            ],
        ];
        $testCollection = new Functional($testArray);

        $expected = 'foobar';
        $actual = $testCollection->reduce(function($acc, $item) {
            return $acc.$item[0];
        }, '');

        $this->assertEquals($expected, $actual);
    }
}
