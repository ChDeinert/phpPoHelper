<?php

namespace ChDeinert\phpPoHelper\IntegrationTest;

use ChDeinert\phpPoHelper\Parser\Writer;
use ChDeinert\phpPoHelper\PoHeader;
use ChDeinert\phpPoHelper\PoFile;
use ChDeinert\phpPoHelper\Collections\Messages;
use ChDeinert\phpPoHelper\PoMessage;
use DateTime;

/**
 * @coversNothing
 */
class WriterTest extends \PHPUnit_Framework_TestCase
{
    private $testFileName = __DIR__.'/Ressources/writer_test_file.po';

    public function setUp()
    {
    }

    public function tearDown()
    {
        if (file_exists($this->testFileName)) {
            unlink($this->testFileName);
        }
    }

    /**
     * @test
     */
    public function parsingAnEmptyPoFileObjectCreatesAMinimalPoFile()
    {
        $expectedFileName = __DIR__.'/Ressources/writer_minimal_file.po';
        $minimalPoHeader = new PoHeader('');
        $minimalPoHeader->setRevisionDate(new DateTime('2016-09-20 13:36+0000'));
        $minimalMessages = new Messages;
        $minimalPoFile = new PoFile($this->testFileName, $minimalPoHeader, $minimalMessages);

        $testWriter = new Writer;
        $testWriter->parse($minimalPoFile);

        $this->assertTrue(file_exists($this->testFileName));
        $expectedFileContent = file_get_contents($expectedFileName);
        $actualFileContent = file_get_contents($this->testFileName);
        $this->assertEquals($expectedFileContent, $actualFileContent);
    }

    /**
     * @test
     */
    public function parsingPoFileObjectWithHeaderCreatesAPoFile()
    {
        $expectedFileName = __DIR__.'/Ressources/writer_header_no_message.po';
        $poHeader = new PoHeader('Header Title');
        $poHeader->setRevisionDate(new DateTime('2016-09-20 13:36+0000'));
        $poHeader->setLanguage('de');
        $minimalMessages = new Messages;
        $poFile = new PoFile($this->testFileName, $poHeader, $minimalMessages);

        $testWriter = new Writer;
        $testWriter->parse($poFile);

        $this->assertTrue(file_exists($this->testFileName));
        $expectedFileContent = file_get_contents($expectedFileName);
        $actualFileContent = file_get_contents($this->testFileName);
        $this->assertEquals($expectedFileContent, $actualFileContent);
    }

    /**
     * @test
     */
    public function parsingPoFileObjectWithMessageCreatesAPoFile()
    {
        $expectedFileName = __DIR__.'/Ressources/writer_header_one_message.po';
        $poHeader = new PoHeader('Header Title');
        $poHeader->setRevisionDate(new DateTime('2016-09-20 13:36+0000'));
        $poHeader->setLanguage('de');
        $poMessage = new PoMessage('Message ID', 'Message String');
        $poMessage->addFlag('fuzzy');
        $poMessage->addReference([
            'file' => 'file/example.ext',
            'line' => 123,
        ]);
        $messages = new Messages;
        $messages->add($poMessage);
        $poFile = new PoFile($this->testFileName, $poHeader, $messages);

        $testWriter = new Writer;
        $testWriter->parse($poFile);

        $this->assertTrue(file_exists($this->testFileName));
        $expectedFileContent = file_get_contents($expectedFileName);
        $actualFileContent = file_get_contents($this->testFileName);
        $this->assertEquals($expectedFileContent, $actualFileContent);
    }
}
