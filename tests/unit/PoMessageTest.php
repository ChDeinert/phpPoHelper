<?php

namespace ChDeinert\phpPoHelper\Test;

use ChDeinert\phpPoHelper\PoMessage;
use Faker\Factory as Faker;

/**
 * @covers ChDeinert\phpPoHelper\PoMessage
 */
class PoMessagetest extends \PHPUnit_Framework_TestCase
{
    private $faker;

    public function setUp()
    {
        $this->faker = Faker::create();
    }

    public function tearDown()
    {
    }

    /**
     * @test
     */
    public function itCanBeInitializedWithOnlyAMsgid()
    {
        $expectedMsgid = $this->faker->sentence();
        $testMessage = new PoMessage($expectedMsgid);

        $this->assertEquals($expectedMsgid, $testMessage->getMsgid());
    }

    /**
     * @test
     */
    public function itCanBeInitializedWithAMsgidAndAMsgstr()
    {
        $expectedMsgid = $this->faker->sentence();
        $expectedMsgstr = $this->faker->sentence();
        $testMessage = new PoMessage($expectedMsgid, $expectedMsgstr);

        $this->assertEquals($expectedMsgstr, $testMessage->getMsgstr());
    }

    /**
     * @test
     */
    public function msgstrCanBeSetAfterInitialization()
    {
        $expectedMsgid = $this->faker->sentence();
        $initialMsgstr = $this->faker->sentence();
        $testMessage = new PoMessage($expectedMsgid, $initialMsgstr);

        $expectedMsgstr = $this->faker->sentence();
        $testMessage->setMsgstr($expectedMsgstr);

        $this->assertEquals($expectedMsgstr, $testMessage->getMsgstr());
    }

    /**
     * @test
     */
    public function itHoldsAnArrayRepresentingTheFlags()
    {
        $testMsgid = $this->faker->sentence();
        $testMsgstr = $this->faker->sentence();
        $testMessage = new PoMessage($testMsgid, $testMsgstr);

        $this->assertTrue(is_array($testMessage->getFlags()));
    }

    /**
     * @test
     */
    public function singleFlagsCanBeAddedToTheFlagsArray()
    {
        $testMsgid = $this->faker->sentence();
        $testMsgstr = $this->faker->sentence();
        $testMessage = new PoMessage($testMsgid, $testMsgstr);

        $expectedFlagInArray = $this->faker->word;
        $expectedFlagArray = [0 => $expectedFlagInArray];
        $testMessage->addFlag($expectedFlagInArray);

        $this->assertEquals($expectedFlagArray, $testMessage->getFlags());
    }

    /**
     * @test
     */
    public function theFlagArrayCanHoldMultipleFlags()
    {
        $testMsgid = $this->faker->sentence();
        $testMsgstr = $this->faker->sentence();
        $testMessage = new PoMessage($testMsgid, $testMsgstr);

        $expectedFlagArray = $this->getUniqueFlagArray();
        $expectedCount = count($expectedFlagArray);
        foreach ($expectedFlagArray as $value) {
            $testMessage->addFlag($value);
        }

        $this->assertEquals($expectedCount, count($testMessage->getFlags()));
    }

    /**
     * @test
     */
    public function itHoldsAnArrayRepresentingTheReferences()
    {
        $testMsgid = $this->faker->sentence();
        $testMsgstr = $this->faker->sentence();
        $testMessage = new PoMessage($testMsgid, $testMsgstr);

        $this->assertTrue(is_array($testMessage->getReferences()));
    }

    /**
     * @test
     */
    public function singleReferencesCanBeAddedToTheReferencesArray()
    {
        $testMsgid = $this->faker->sentence();
        $testMsgstr = $this->faker->sentence();
        $testMessage = new PoMessage($testMsgid, $testMsgstr);

        $expectedReference = [
            'file' => $this->faker->word,
            'line' => $this->faker->numberBetween(1, 100),
        ];
        $expectedReferenceArray = [0 => $expectedReference];
        $testMessage->addReference($expectedReference);

        $this->assertEquals($expectedReferenceArray, $testMessage->getReferences());
    }

    /**
     * @test
     */
    public function theReferenceArrayCanHoldMultipleReferences()
    {
        $testMsgid = $this->faker->sentence();
        $testMsgstr = $this->faker->sentence();
        $testMessage = new PoMessage($testMsgid, $testMsgstr);

        $expectedReferenceArray = $this->getUniqueReferenceArray();
        $expectedCount = count($expectedReferenceArray);

        foreach ($expectedReferenceArray as $reference) {
            $testMessage->addReference($reference);
        }

        $this->assertEquals($expectedCount, count($testMessage->getReferences()));
    }

    /**
     * @test
     */
    public function aWronglyStructuredReferenceWontBeAdded()
    {
        $testMsgid = $this->faker->sentence();
        $testMsgstr = $this->faker->sentence();
        $testMessage = new PoMessage($testMsgid, $testMsgstr);

        $wrongReference = ['Not to add'];
        $testMessage->addReference($wrongReference);

        $expectedReferenceArray = $this->getUniqueReferenceArray();
        $expectedCount = count($expectedReferenceArray);

        foreach ($expectedReferenceArray as $reference) {
            $testMessage->addReference($reference);
        }

        $actualReferenceArray = $testMessage->getReferences();
        $this->assertEquals($expectedCount, count($actualReferenceArray));
        $this->assertNotContains($wrongReference, $actualReferenceArray);
    }

    private function getUniqueFlagArray() {
        $count = $this->faker->numberBetween(4, 50);
        $array = [];

        for ($i = 0; $i < $count; $i++) {
            $array[] = $this->faker->word;
        }

        return array_unique($array);
    }

    private function getUniqueReferenceArray() {
        $count = $this->faker->numberBetween(4, 50);
        $array = [];

        for ($i = 0; $i < $count; $i++) {
            $array[] = [
                'file' => $this->faker->word,
                'line' => $this->faker->numberBetween(1, 100) + $i,
            ];
        }

        return $array;
    }
}
