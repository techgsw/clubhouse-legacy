<?php


namespace App;


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

    public function __construct(
        $operator = "AND",
        $index = "default",
        $value = null
    ) {
        $this->operator = $operator;
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

    public function setOperator(string $operator)
    {
        $this->operator = $operator;
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
}