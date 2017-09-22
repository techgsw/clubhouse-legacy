<?php

namespace App;

class Message
{
    protected $code;
    protected $icon;
    protected $message;
    protected $type;
    protected $url;

    public function __construct(
        string $message,
        string $type,
        int $code = null,
        string $icon = null,
        string $url = null
    ) {
        $this->code = $code;
        $this->icon = $icon;
        $this->message = $message;
        $this->type = $type;
        $this->url = $url;
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

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon(string $icon)
    {
        $this->icon = $icon;
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

    public function getURL()
    {
        return $this->url;
    }

    public function setURL(string $url)
    {
        $this->url = $url;
        return $this;
    }
}
