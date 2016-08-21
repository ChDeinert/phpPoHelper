<?php

namespace ChDeinert\phpPoHelper\IntegrationTest;

use ChDeinert\phpPoHelper\Parser\Reader;
use ChDeinert\phpPoHelper\PoHeader;
use ChDeinert\phpPoHelper\PoMessage;
use ChDeinert\phpPoHelper\Collections\Messages;
use Chdeinert\phpPoHelper\PoFile;
use DateTime;

/**
 * @coversNothing
 */
class ReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function readingAFileWithAHeaderReturnsAPoFileObjectWithPoHeader()
    {
        $expectedHeaderTitle = 'Header Title';
        $expectedLanguage = 'de';
        $expectedRevisionDate = new DateTime('2016-09-20 13:36:00+0000');
        $expectedPoHeader = new PoHeader($expectedHeaderTitle);
        $expectedPoHeader->setLanguage($expectedLanguage);
        $expectedPoHeader->setRevisionDate($expectedRevisionDate);

        $testReader = new Reader;
        $testFile = __DIR__.'/Ressources/file_with_header.po';
        $result = $testReader->parse($testFile);
        $actualPoHeader = $result->poHeader;

        $this->assertEquals($expectedPoHeader, $actualPoHeader);
    }

    /**
     * @test
     */
    public function readingAFileWithAWrongHeaderReturnsAPoFileObjectWithAnDefaultHeader()
    {
        $expectedHeaderTitle = '';
        $expectedLanguage = '';
        $expectedRevisionDate = new DateTime;
        $expectedPoHeader = new PoHeader($expectedHeaderTitle);
        $expectedPoHeader->setLanguage($expectedLanguage);
        $expectedPoHeader->setRevisionDate($expectedRevisionDate);

        $testReader = new Reader;
        $testFile = __DIR__.'/Ressources/file_with_wrong_header.po';
        $result = $testReader->parse($testFile);
        $actualPoHeader = $result->poHeader;

        $this->assertEquals($expectedPoHeader, $actualPoHeader);
    }

    /**
     * @test
     */
    public function readingAFileWithoutAHeaderReturnsAPoFileObjectWithAnDefaultHeader()
    {
        $expectedHeaderTitle = '';
        $expectedLanguage = '';
        $expectedRevisionDate = new DateTime;
        $expectedPoHeader = new PoHeader($expectedHeaderTitle);
        $expectedPoHeader->setLanguage($expectedLanguage);
        $expectedPoHeader->setRevisionDate($expectedRevisionDate);

        $testReader = new Reader;
        $testFile = __DIR__.'/Ressources/file_with_message.po';
        $result = $testReader->parse($testFile);
        $actualPoHeader = $result->poHeader;

        $this->assertEquals($expectedPoHeader, $actualPoHeader);
    }

    /**
     * @test
     */
    public function readingAFileWithAMessageReturnsAPoFileObjectWithTheMessageInCollection()
    {
        $expectedMsgid = 'Message ID';
        $expectedMsgstr = 'Message String';
        $expectedFlag = 'fuzzy';
        $expectedReference = [
            'file' => 'file/example.ext',
            'line' => 123
        ];
        $expectedMessageInCollection = new PoMessage($expectedMsgid, $expectedMsgstr);
        $expectedMessageInCollection->addFlag($expectedFlag);
        $expectedMessageInCollection->addReference($expectedReference);
        $expectedMessageCollection = new Messages;
        $expectedMessageCollection->add($expectedMessageInCollection);

        $testReader = new Reader;
        $testFile = __DIR__.'/Ressources/file_with_message.po';
        $result = $testReader->parse($testFile);
        $actualMessageCollection = $result->messages;

        $this->assertEquals($expectedMessageCollection, $actualMessageCollection);
    }

    /**
     * @test
     */
    public function readingAFileSupportsMultipleReferencesInOneLine()
    {
        $expectedMsgid = 'Message ID';
        $expectedMsgstr = 'Message String';
        $expectedFlag = 'fuzzy';
        $expectedReference1 = [
            'file' => 'file/example.ext',
            'line' => 123
        ];
        $expectedReference2 = [
            'file' => 'file/example2.ext',
            'line' => 321
        ];
        $expectedMessageInCollection = new PoMessage($expectedMsgid, $expectedMsgstr);
        $expectedMessageInCollection->addFlag($expectedFlag);
        $expectedMessageInCollection->addReference($expectedReference1);
        $expectedMessageInCollection->addReference($expectedReference2);
        $expectedMessageCollection = new Messages;
        $expectedMessageCollection->add($expectedMessageInCollection);

        $testReader = new Reader;
        $testFile = __DIR__.'/Ressources/file_with_multiple_reference_on_line.po';
        $result = $testReader->parse($testFile);
        $actualMessageCollection = $result->messages;

        $this->assertEquals($expectedMessageCollection, $actualMessageCollection);
    }

    /**
     * @test
     */
    public function readingAFileWithHeaderAndMessageReturnsAFullPoFileObject()
    {
        $expectedHeaderTitle = 'Header Title';
        $expectedLanguage = 'de';
        $expectedRevisionDate = new DateTime('2016-09-20 13:36:00+0000');
        $expectedPoHeader = new PoHeader($expectedHeaderTitle);
        $expectedPoHeader->setLanguage($expectedLanguage);
        $expectedPoHeader->setRevisionDate($expectedRevisionDate);

        $expectedMsgid = 'Message ID';
        $expectedMsgstr = 'Message String';
        $expectedFlag = 'fuzzy';
        $expectedReference1 = [
            'file' => 'file/example.ext',
            'line' => 123
        ];
        $expectedReference2 = [
            'file' => 'file/example2.ext',
            'line' => 321
        ];
        $expectedMessageInCollection = new PoMessage($expectedMsgid, $expectedMsgstr);
        $expectedMessageInCollection->addFlag($expectedFlag);
        $expectedMessageInCollection->addReference($expectedReference1);
        $expectedMessageInCollection->addReference($expectedReference2);
        $expectedMessageCollection = new Messages;
        $expectedMessageCollection->add($expectedMessageInCollection);

        $testFile = __DIR__.'/Ressources/file_with_header_and_message.po';
        $expectedPoFile = new PoFile($testFile, $expectedPoHeader, $expectedMessageCollection);

        $testReader = new Reader;
        $actualPoFile = $testReader->parse($testFile);

        $this->assertEquals($expectedPoFile, $actualPoFile);
    }
}
