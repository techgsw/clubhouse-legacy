<?php

namespace App;

class Message
{
    protected $code;
    protected $icon;
    protected $message;
    protected $type;
    protected $url;
    protected $values;

    public function __construct(
        string $message,
        string $type,
        int $code = null,
        string $icon = null,
        string $url = null,
        array $values = array()
    ) {
        $this->code = $code;
        $this->icon = $icon;
        $this->message = $message;
        $this->type = $type;
        $this->url = $url;
        $this->values = $values;
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

    public function getValues()
    {
        return $this->values;
    }

    public function setValues(array $values)
    {
        $this->values= $values;
        return $this;
    }

    public function toArray($property = null)
    {
        $input = (is_null($property)) ? $this : $property;

        $array = array();
        foreach ($input as $key => $value) {
            if (gettype($value) == "object" && get_class($value) == "DateTime") {
                $array[$key] = $value->format('Y-m-d H:i:s');
            } else if (gettype($value) == "boolean") {
                $array[$key] = ($value) ? 1 : 0;
            } else if (gettype($value) == "array") {
                $array[$key] = $this->toArray($value);
            } else if (gettype($value) == "object" && is_a($value, 'Illuminate\Database\Eloquent\Model')) {
                $array[$key] = $this->toArray($value->toArray());
            } else if (gettype($value) == "object") {
                $array[$key] = $this->toArray($value);
            } else if (gettype($value) != "object" && gettype($value) != "array") {
                $array[$key] = $value;
            }
        }
        return $array;
    }
}
