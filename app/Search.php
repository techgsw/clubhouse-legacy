<?php

namespace App;

use App\Exceptions\InvalidSearchException;

/**
 * This object holds search blocks used when parsing searches with our custom syntax.
 * These are typically passed through the codebase in an array and are parsed out by App\Providers\SearchServiceProvider
 * @package App
 */
class Search
{
    const VALID_CONJUNCTIONS = array('and', 'or');
    // this tells the query builder that the value is an array of Search objects
    const GROUP_LABEL = 'search_group';
    const DEFAULT_LABEL = 'search_group';

    protected $conjunction;
    protected $label;
    protected $value;

    /**
     * @throws InvalidSearchException
     */
    public function __construct(
        $conjunction = "and",
        $label = self::DEFAULT_LABEL,
        $value = null
    ) {
        $this->conjunction = $this->validateConjunction($conjunction);
        if (is_array($value)) {
            $this->label = self::GROUP_LABEL;
        } else {
            $this->label = $label;
        }
        $this->value = $value;
    }

    public function getConjunction()
    {
        return $this->conjunction;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @throws InvalidSearchException
     */
    public function setConjunction(string $conjunction)
    {
        $this->conjunction = $this->validateConjunction($conjunction);
        return $this;
    }

    public function setLabel(string $label)
    {
        $this->label = $label;
        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;
        if (is_array($value)) {
            $this->label = self::GROUP_LABEL;
        }
        return $this;
    }

    private function validateConjunction($conjunction) {
        if (in_array($conjunction, self::VALID_CONJUNCTIONS)) {
            return $conjunction;
        } else {
            throw new InvalidSearchException(
                "Conjunction ".$conjunction." is invalid. "
                ."Should be one of ".implode(", ", self::VALID_CONJUNCTIONS));
        }
    }

}