<?php

namespace ChDeinert\phpPoHelper\Test;

use ChDeinert\phpPoHelper\Parser\Writer;
use ChDeinert\phpPoHelper\PoFile;
use ChDeinert\phpPoHelper\PoHeader;
use ChDeinert\phpPoHelper\Collections\Messages;
use Mockery;

/**
 * @covers ChDeinert\phpPoHelper\Parser\Writer
 *
 * @uses ChDeinert\phpPoHelper\PoFile
 * @uses ChDeinert\phpPoHelper\PoHeader
 * @uses ChDeinert\phpPoHelper\Collections\Messages
 * @uses ChDeinert\phpPoHelper\PoMessage
 */
class WriterTest extends \PHPUnit_Framework_TestCase
{
    private $testFileName = __DIR__.'/Ressources/writerFile.po';

    public function setUp()
    {
    }

    public function tearDown()
    {
        if (file_exists($this->testFileName)) {
            unlink($this->testFileName);
        }

        Mockery::close();
    }

    /**
     * @test
     */
    public function writerCreatesAPoFileOnTheFileSystem()
    {
        $poHeaderMock = Mockery::mock(PoHeader::class);
        $messagesMock = Mockery::mock(Messages::class);
        $poFileMock = Mockery::mock(PoFile::class);
        $poFileMock->filename = $this->testFileName;
        $poFileMock->poHeader = $poHeaderMock;
        $poFileMock->messages = $messagesMock;

        $testWriter = new Writer;
        $testWriter->parse($poFileMock);

        $this->assertTrue(file_exists($this->testFileName));
    }
}
