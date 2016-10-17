<?php

namespace ChDeinert\phpPoHelper\Test;

use ChDeinert\phpPoHelper\Parser\Reader;
use ChDeinert\phpPoHelper\PoFile;
use ChDeinert\phpPoHelper\PoHeader;
use DateTime;

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

    /**
     * @test
     */
    public function readingAFileReturnsAPoFileObjectWithPoHeader()
    {
      $testFile = __DIR__.'/Ressources/file_with_header.po';
      $testReader = new Reader;

      $expectedHeaderTitle = 'Header Title';
      $expectedLanguage = 'de';
      $expectedRevisionDate = new DateTime('2016-09-20 13:36:00+0000');
      $expectedPoHeader = new PoHeader($expectedHeaderTitle);
      $expectedPoHeader->setLanguage($expectedLanguage);
      $expectedPoHeader->setRevisionDate($expectedRevisionDate);
      $result = $testReader->parse($testFile);

      $this->assertEquals($expectedPoHeader, $result->poHeader);
    }
}
