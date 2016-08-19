<?php

namespace ChDeinert\phpPoHelper;

/**
 * Class representing a single PoMessage
 */
class PoMessage
{
    /**
     * @var String
     */
    private $msgid;

    /**
     * @var String
     */
    private $msgstr;

    /**
     * @var array
     */
    private $flags;

    /**
     * @var array
     */
    private $references;

    /**
     * @param String $msgid
     * @param string $msgstr
     */
    public function __construct(String $msgid, String $msgstr = '')
    {
        $this->msgid = $msgid;
        $this->setMsgstr($msgstr);
        $this->flags = [];
        $this->references = [];
    }

    /**
     * @return String
     */
    public function getMsgid()
    {
        return $this->msgid;
    }

    /**
     * @param String $msgstr
     */
    public function setMsgstr(String $msgstr)
    {
        $this->msgstr = $msgstr;
    }

    /**
     * @return String
     */
    public function getMsgstr()
    {
        return $this->msgstr;
    }

    /**
     * @param String $flag
     */
    public function addFlag(String $flag)
    {
        $this->flags[] = $flag;
    }

    /**
     * @return array
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Adds the given Reference to the ReferenceArray.
     * References have to be an Array with a file and a line
     *
     * @param array $reference
     */
    public function addReference(array $reference)
    {
        if (!array_key_exists('file', $reference) || !array_key_exists('line', $reference)) {
            return;
        }

        $this->references[] = $reference;
    }

    /**
     * @return array
     */
    public function getReferences()
    {
        return $this->references;
    }
}
