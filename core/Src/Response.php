<?php

namespace Src;

class Response
{
    private $code;
    private $status; // data -  возврат данных каких-то данных, error - возврат ошибок, url - возврат url
    private $data = [];

    public function __construct($status = 'data', $code = 200)
    {
        $this->status = $status;
        $this->code = $code;
    }

    public function __toString()
    {
        http_response_code($this->code);
        return json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function setData($data)
    {
        $this->data[$this->status] = $data;
        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}