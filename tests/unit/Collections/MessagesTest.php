<?php

namespace ChDeinert\phpPoHelper\Test;

use ChDeinert\phpPoHelper\Collections\Messages;
use ChDeinert\phpPoHelper\PoMessage;
use Faker\Factory as Faker;
use Mockery;

/**
 * @covers ChDeinert\phpPoHelper\Collections\Messages
 * @uses ChDeinert\phpPoHelper\PoMessage
 */
class MessagesTest extends \PHPUnit_Framework_TestCase
{
    private $faker;

    public function setUp()
    {
        $this->faker = Faker::create();
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function theCollectionImplementsCountable()
    {
        $testCollection = new Messages;

        $this->assertInstanceOf('\Countable', $testCollection);
        $this->assertCount(0, $testCollection);
    }

    /**
     * @test
     */
    public function aMessageCanBeAddedToTheCollection()
    {
        $testCollection = new Messages;
        $messageMock = Mockery::mock(PoMessage::class)
            ->shouldReceive('getMsgid')
            ->andReturn($this->faker->sentence())
            ->getMock();

        $testCollection->add($messageMock);

        $this->assertCount(1, $testCollection);
    }

    /**
     * @test
     */
    public function addingAMessageThatAlreadyExistsReturnsFalse()
    {
        $testCollection = new Messages;
        $testMsgid = $this->faker->sentence();
        $messageMock = Mockery::mock(PoMessage::class)
            ->shouldReceive('getMsgid')
            ->atLeast()->once()
            ->andReturn($testMsgid)
            ->getMock();
        $testCollection->add($messageMock);

        $actualResult = $testCollection->add($messageMock);

        $this->assertFalse($actualResult);
    }

    /**
     * @test
     */
    public function aSingleMessageCanBeReturnedByMsgid()
    {
        $testCollection = new Messages;
        $expectedMsgid = $this->faker->sentence();
        $messageMock = Mockery::mock(PoMessage::class)
            ->shouldReceive('getMsgid')
            ->atLeast()->once()
            ->andReturn($expectedMsgid)
            ->getMock();

        $testCollection->add($messageMock);

        $actualMessage = $testCollection->get($expectedMsgid);

        $this->assertEquals($messageMock, $actualMessage);
    }

    /**
     * @test
     */
    public function searchingAMessageThatIsNotInTheCollectionReturnsNull()
    {
        $testCollection = new Messages;
        $testMsgid = $this->faker->sentence();
        $messageMock = Mockery::mock(PoMessage::class)
            ->shouldReceive('getMsgid')
            ->atLeast()->once()
            ->andReturn($testMsgid)
            ->getMock();

        $testCollection->add($messageMock);

        $actualMessage = $testCollection->get('Not in Collection');

        $this->assertNull($actualMessage);
    }
}
