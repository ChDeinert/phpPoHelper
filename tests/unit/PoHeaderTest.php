<?php

namespace ChDeinert\phpPoHelper\Test;

use ChDeinert\phpPoHelper\PoHeader;
use Faker\Factory as Faker;
use DateTime;

/**
 * @covers ChDeinert\phpPoHelper\PoHeader
 */
class PoHeaderTest extends \PHPUnit_Framework_TestCase
{
    private $faker;

    public function setUp()
    {
        $this->faker = Faker::create();
    }

    /**
     * @test
     */
    public function headerIsInitializedWithATitle()
    {
        $expectedTitle = $this->faker->sentence();
        $testHeader = new PoHeader($expectedTitle);

        $this->assertEquals($expectedTitle, $testHeader->getTitle());
    }

    /**
     * @test
     */
    public function languageCanBeSetOnHeader()
    {
        $testHeader = new PoHeader($this->faker->sentence());
        $expectedLanguage = $this->faker->word;

        $testHeader->setLanguage($expectedLanguage);
        $actualLanguage = $testHeader->getLanguage();

        $this->assertEquals($expectedLanguage, $actualLanguage);
    }

    /**
     * @test
     */
    public function poRevisionDateGetsSetOnInitialization()
    {
        $expectedRevDate = new DateTime;
        $testHeader = new PoHeader($this->faker->sentence());

        $actualRevDate = $testHeader->getRevisionDate();

        $this->assertEquals($expectedRevDate, $actualRevDate);
    }

    /**
     * @test
     */
    public function poRevisionDateCanBeSetWithADateTimeObject()
    {
        $expectedRevDate = new DateTime("-1day");
        $testHeader = new PoHeader($this->faker->sentence());

        $testHeader->setRevisionDate($expectedRevDate);
        $actualRevDate = $testHeader->getRevisionDate();

        $this->assertEquals($expectedRevDate, $actualRevDate);
    }
}
