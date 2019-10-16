<?php

namespace Lazy\AppStore\Api;

use Lazy\AppStore\Traits\HttpRequest;

class Base
{
    use HttpRequest;

    protected $token;
    protected $header;
    protected $host = 'https://api.appstoreconnect.apple.com/v1';

    public function __construct($token)
    {
        $this->setToken($token);
        $this->setHeader();
    }

    protected function setToken($token)
    {
        $this->token = 'Bearer ' . $token;
        return $this;
    }
    protected function setHeader(array $header = [])
    {
        $header['Authorization'] = $this->token;
        $this->header = $header;
        return $this;
    }

    protected function getUrl($path)
    {
        return $this->host . $path;
    }
}
