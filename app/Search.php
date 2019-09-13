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
    protected $operator;
    protected $index;
    protected $value;

    /**
     * @throws InvalidSearchException
     */
    public function __construct(
        $operator = "and",
        $index = "default",
        $value = null
    ) {
        $this->operator = $this->validateOperator($operator);
        $this->index = $index;
        $this->value = $value;
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @throws InvalidSearchException
     */
    public function setOperator(string $operator)
    {
        $this->operator = $this->validateOperator($operator);
        return $this;
    }

    public function setIndex(string $index)
    {
        $this->index = $index;
        return $this;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
        return $this;
    }

    private function validateOperator($operator) {
        if (in_array($operator, array("and", "or"))) {
            return $operator;
        } else {
            throw new InvalidSearchException(
                "Operator ".$operator." is invalid. Should be 'and' or 'or'.");
        }
    }
}