<?php

namespace ChDeinert\phpPoHelper;

use DateTime;

/**
 * Holds Informations about a Po File Header
 */
class PoHeader
{
    /**
     * @var String
     */
    private $title;

    /**
     * @var String
     */
    private $language;

    /**
     * @var DateTime
     */
    private $poRevisionDate;

    /**
     * @param String $title
     */
    public function __construct(String $title)
    {
        $this->title = $title;
        $this->poRevisionDate = new DateTime;
    }

    /**
     * @return String
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param String $language
     */
    public function setLanguage(String $language)
    {
        $this->language = $language;
    }

    /**
     * @return String
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param DateTime $poRevisionDate
     */
    public function setRevisionDate(DateTime $poRevisionDate)
    {
        $this->poRevisionDate = $poRevisionDate;
    }

    /**
     * @return DateTime
     */
    public function getRevisionDate()
    {
        return $this->poRevisionDate;
    }
}
