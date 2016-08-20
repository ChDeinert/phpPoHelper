<?php

namespace ChDeinert\phpPoHelper\Parser;

use ChDeinert\phpPoHelper\PoHeader;
use ChDeinert\phpPoHelper\Collections\Messages;
use ChDeinert\phpPoHelper\PoFile;

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

        $title = '';
        $poHeader = new PoHeader($title);
        $messages = new Messages;
        $poFile = new PoFile($filename, $poHeader, $messages);

        return $poFile;
    }
}
