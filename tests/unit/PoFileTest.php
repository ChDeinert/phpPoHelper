<?php

namespace ChDeinert\phpPoHelper\Test;

use ChDeinert\phpPoHelper\PoFile;
use ChDeinert\phpPoHelper\PoHeader;
use ChDeinert\phpPoHelper\Collections\Messages;
use Faker\Factory as Faker;
use Mockery;

/**
 * @covers ChDeinert\phpPoHelper\PoFile
 */
class PoFileTest extends \PHPUnit_Framework_TestCase
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
    public function poFileGetsInitializedWithAFileNameAHeaderAndAMessageCollection()
    {
        $testFileName = str_replace(' ', '/', $this->faker->sentence());
        $poHeaderMock = Mockery::mock(PoHeader::class);
        $poMessageCollectionMock = Mockery::mock(Messages::class);

        $testFile = new PoFile($testFileName, $poHeaderMock, $poMessageCollectionMock);

        $this->assertEquals($testFileName, $testFile->filename);
        $this->assertEquals($poHeaderMock, $testFile->poHeader);
        $this->assertEquals($poMessageCollectionMock, $testFile->messages);
    }
}
