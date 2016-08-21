<?php

namespace ChDeinert\phpPoHelper\Parser;

use ChDeinert\phpPoHelper\PoFile;

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
        fclose($fileHandler);
    }
}
