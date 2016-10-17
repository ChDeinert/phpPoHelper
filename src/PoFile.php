<?php

namespace ChDeinert\phpPoHelper;

use ChDeinert\phpPoHelper\Collections\Messages;

/**
 * Represents a PoFile
 */
class PoFile
{
    /**
     * @var String
     */
    public $filename;

    /**
     * @var poHeader
     */
    public $poHeader;

    /**
     * @var Messages
     */
    public $messages;

    /**
     * @param String   $filename
     * @param PoHeader $poHeader
     * @param Messages $messages
     */
    public function __construct($filename, PoHeader $poHeader, Messages $messages)
    {
        $this->filename = $filename;
        $this->poHeader = $poHeader;
        $this->messages = $messages;
    }
}
