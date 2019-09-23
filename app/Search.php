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
    protected $conjunction;
    protected $label;
    protected $value;

    /**
     * @throws InvalidSearchException
     */
    public function __construct(
        $conjunction = "and",
        //TODO: validate label of "(", make sure value is an array???
        $label = "default",
        $value = null
    ) {
        $this->conjunction = $this->validateConjunction($conjunction);
        $this->label = $label;
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
        return $this;
    }

    private function validateConjunction($conjunction) {
        if (in_array($conjunction, array("and", "or"))) {
            return $conjunction;
        } else {
            throw new InvalidSearchException(
                "Conjunction ".$conjunction." is invalid. Should be 'and' or 'or'.");
        }
    }
}