<?php

namespace ChDeinert\phpPoHelper\Test;

use ChDeinert\phpPoHelper\Parser\Reader;
use ChDeinert\phpPoHelper\PoFile;

/**
 * @covers ChDeinert\phpPoHelper\Parser\Reader
 *
 * @uses ChDeinert\phpPoHelper\PoFile
 * @uses ChDeinert\phpPoHelper\PoHeader
 * @uses ChDeinert\phpPoHelper\PoMessage
 * @uses ChDeinert\phpPoHelper\Collections\Messages
 */
class ReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function readingAFileReturnsAPoFileObject()
    {
        $testFile = __DIR__.'/Ressources/emptyFile.po';
        $testReader = new Reader;

        $result = $testReader->parse($testFile);

        $this->assertInstanceOf(PoFile::class, $result);
    }

    /**
     * @test
     */
    public function tryingToReadANotReadableOrExistantFileReturnsNull()
    {
        $testFile = 'Nothing';
        $testReader = new Reader;

        $result = $testReader->parse($testFile);

        $this->assertNull($result);
    }
}
