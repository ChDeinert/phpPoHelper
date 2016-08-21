<?php

namespace ChDeinert\phpPoHelper\Collections;

use ChDeinert\phpPoHelper\PoMessage;
use Countable;

/**
 * Message Collection
 */
class Messages extends Functional implements Countable
{
    /**
     * @var array
     */
    private $index;

    public function __construct()
    {
        $this->items = [];
        $this->index = [];
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Add a Message to the Collection.
     * Returns false if a Message with the same Msgid is already in the Collection
     *
     * @param PoMessage $message
     * @return bool
     */
    public function add(PoMessage $message)
    {
        $newMsgid = $message->getMsgid();
        if (!is_null($this->get($newMsgid))) {
            return false;
        }

        $this->items[] = $message;
        $this->buildIndex();

        return true;
    }

    /**
     * Returns a Message from the Collection by the Msgid.
     * Returns null if the Msgid could not be found.
     *
     * @param  String $msgidToSearch
     * @return null|PoMessage
     */
    public function get(String $msgidToSearch)
    {
        if (!array_key_exists($msgidToSearch, $this->index)) {
            return null;
        }

        $messageKey = $this->index[$msgidToSearch];

        return $this->items[$messageKey];
    }

    /**
     * Builds an index array for easier search inside the Collection
     */
    private function buildIndex()
    {
        $this->index = [];

        foreach ($this->items as $key => $message) {
            $this->index[$message->getMsgid()] = $key;
        }
    }
}
