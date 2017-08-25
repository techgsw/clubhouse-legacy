<?php

namespace App;

class Message
{
    protected $code;
    protected $message;
    protected $type;

    public function __construct(
        string $message,
        string $type,
        int $code = null
    ) {
        $this->code = $code;
        $this->message = $message;
        $this->type = $type;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode(int $code)
    {
        $this->code = $code;
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }
}
