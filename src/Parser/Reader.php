<?php

namespace ChDeinert\phpPoHelper\Parser;

use ChDeinert\phpPoHelper\PoHeader;
use ChDeinert\phpPoHelper\PoMessage;
use ChDeinert\phpPoHelper\Collections\Messages;
use ChDeinert\phpPoHelper\PoFile;
use DateTime;

/**
 * Reads a PoFile and created a PoFile Object
 */
class Reader
{
    public function parse($filename)
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return null;
        }

        $fileContents = file_get_contents($filename);
        $fileContentsArray = explode("\n\n", $fileContents);

        $poHeader = $this->getPoHeader($fileContentsArray[0]);
        $messages = $this->getMessageCollection($fileContentsArray);

        $poFile = new PoFile($filename, $poHeader, $messages);

        return $poFile;
    }

    private function getPoHeader($fileContents)
    {
        if (preg_match('/msgid ""/', $fileContents) == false) {
            return new PoHeader('');
        }

        $title = $this->parseTitle($fileContents);
        $language = $this->parseLanguage($fileContents);
        $poRevisionDate = $this->parseRevisionDate($fileContents);

        $poHeader = new PoHeader($title);

        if (!empty($language)) {
            $poHeader->setLanguage($language);
        }
        if (!empty($poRevisionDate)) {
            $poHeader->setRevisionDate($poRevisionDate);
        }

        return $poHeader;
    }

    private function parseTitle($fileContents)
    {
        preg_match('/# ([\s\S].*)\\n/', $fileContents, $titleMatch);

        return isset($titleMatch[1]) ? $titleMatch[1] : '';
    }

    private function parseLanguage($fileContents)
    {
        preg_match('/"Language: ([\w]*).*"/', $fileContents, $languageMatch);

        return isset($languageMatch[1]) ? $languageMatch[1] : '';
    }

    private function parseRevisionDate($fileContents)
    {
        preg_match('/"PO-Revision-Date: ([\d- :+]*)/', $fileContents, $poRevisionDateMatch);
        $poRevisionDate = isset($poRevisionDateMatch[1]) ? $poRevisionDateMatch[1] : '';

        return new DateTime($poRevisionDate);
    }

    private function getMessageCollection($contentArray)
    {
        $messages = new Messages;

        foreach ($contentArray as $content) {
            $poMessage = $this->parseSingleMessage($content);

            if ($poMessage === false) {
                continue;
            }

            $messages->add($poMessage);
        }

        return $messages;
    }

    private function parseSingleMessage($messageText)
    {
        preg_match('/msgid "([\w\d\s].*[^"])"/', $messageText, $msgidMatch);
        $msgid = isset($msgidMatch[1]) ? $msgidMatch[1] : '';

        if (empty($msgid)) {
            return false;
        }

        preg_match('/msgstr "([\w\d\s].*[^"])"/', $messageText, $msgstrMatch);
        $msgstr = isset($msgstrMatch[1]) ? $msgstrMatch[1] : '';

        $poMessage = new PoMessage($msgid, $msgstr);
        $this->addFlagsToPoMessage($poMessage, $messageText);
        $this->addReferencesToPoMessage($poMessage, $messageText);

        return $poMessage;
    }

    private function addFlagsToPoMessage(PoMessage $poMessage, $messageText)
    {
        preg_match_all('/#, (\w*)/', $messageText, $flagsMatch);

        foreach ($flagsMatch[1] as $flag) {
            $poMessage->addFlag($flag);
        }
    }

    private function addReferencesToPoMessage(PoMessage $poMessage, $messageText)
    {
        preg_match_all('/#: (\w.*)/', $messageText, $referenceMatches);

        foreach ($referenceMatches[1] as $referenceLine) {
            $referenceLineArray = explode(' ', $referenceLine);

            foreach ($referenceLineArray as $referenceEntry) {
                $referenceArray = explode(':', $referenceEntry);
                $reference = [
                    'file' => $referenceArray[0],
                    'line' => $referenceArray[1],
                ];
                $poMessage->addReference($reference);
            }
        }
    }
}
