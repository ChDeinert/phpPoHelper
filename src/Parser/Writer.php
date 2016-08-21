<?php

namespace ChDeinert\phpPoHelper\Parser;

use ChDeinert\phpPoHelper\PoFile;
use ChDeinert\phpPoHelper\Collections\Functional;
use DateTime;

/**
 * Takes an PoFile Object builds the PoFile Content and writes the File
 */
class Writer
{
    public function parse(PoFile $poFile)
    {
        if (file_exists($poFile->filename)) {
            unlink($poFile->filename);
        }

        $fileHandler = fopen($poFile->filename, 'w');

        //Header section
        $headerContent = "# {$poFile->poHeader->getTitle()}\n".
            "msgid \"\"\n".
            "msgstr \"\"\n".
            "\"PO-Revision-Date: {$poFile->poHeader->getRevisionDate()->format('Y-m-d H:iO')}\\n\"\n".
            "\"Language: {$poFile->poHeader->getLanguage()}\\n\"\n".
            "\"MIME-Version: 1.0\\n\"\n".
            "\"Content-Type: text/plain; charset=UTF-8\\n\"\n".
            "\"Content-Transfer-Encoding: 8bit\\n\"\n".
            "\"X-Generator: phpPoHelper\\n\"\n";
        fwrite($fileHandler, $headerContent);

        // Messages
        if (count($poFile->messages) == 0) {
            fclose($fileHandler);
            return;
        }
        $messageContent = $poFile->messages->reduce(function ($messageContent, $poMessage) {
            $tmpMessageContent = '';
            $references = new Functional($poMessage->getReferences());
            $tmpMessageContent .= $references->reduce(function($tmpReferences, $reference) {
                return $tmpReferences."#: ".$reference['file'].':'.$reference['line']."\n";
            }, '');
            $flags = new Functional($poMessage->getFlags());
            $tmpMessageContent .= $flags->reduce(function($tmpFlags, $flag) {
                return $tmpFlags."#, ".$flag."\n";
            }, '');
            $tmpMessageContent .= "msgid \"{$poMessage->getMsgid()}\"\n".
                "msgstr \"{$poMessage->getMsgstr()}\"\n";

            return $messageContent.$tmpMessageContent;
        }, '');

        fwrite($fileHandler, "\n".$messageContent);

        fclose($fileHandler);
    }
}
