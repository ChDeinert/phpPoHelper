<?php

namespace ChDeinert\phpPoHelper\Collections;

use ChDeinert\phpPoHelper\PoMessage;
use Countable;

class Messages implements Countable
{
    private $items;
    private $index;

    public function __construct()
    {
        $this->items = [];
        $this->index = [];
    }

    public function count()
    {
        return count($this->items);
    }

    public function add(PoMessage $message)
    {
        $newMsgid = $message->getMsgid();
        if (!is_null($this->get($newMsgid))) {
            return false;
        }

        $this->items[] = $message;
        $this->buildIndex();
    }

    public function get(String $msgidToSearch)
    {
        if (!array_key_exists($msgidToSearch, $this->index)) {
            return null;
        }

        $messageKey = $this->index[$msgidToSearch];

        return $this->items[$messageKey];
    }

    private function buildIndex()
    {
        $this->index = [];

        foreach ($this->items as $key => $message) {
            $this->index[$message->getMsgid()] = $key;
        }
    }
}
