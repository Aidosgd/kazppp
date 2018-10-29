<?php

namespace App\Services;

use GuzzleHttp\Client;

class XMLHttpRequest
{
    protected $rootUrl;

    protected $url;

    protected $method;

    protected $async;

    protected $user;

    protected $password;

    public $status;

    public $readyState;

    public $responseText;

    public $onreadystatechange;

    public function __construct($rootUrl = null)
    {
        $this->rootUrl = $rootUrl;
    }

    public function open($method, $url, $async = true, $user = '', $password = '')
    {
        $this->method = $method;
        $this->url = $url;
        $this->async = $async;
        $this->user = $user;
        $this->password = $password;
    }

    public function send($data = '')
    {
        if (!$this->isUrl($this->url) && $this->isUrl($this->rootUrl)) {
            $this->url = $this->rootUrl.$this->url;
        }

        if (is_object($data)) {
            $data = get_object_vars($data);
        } elseif (is_string($data)) {
            $data = http_build_query($data);
        }

        $context = stream_context_create([
            'http' => [
                'method'  => $this->method,
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $data,
            ],
        ]);

        $client = new Client();

        $this->responseText = $client->{$this->method}(url($this->url), $data)->getBody()->getContents();
        $this->status = 200;
        $this->readyState = 4;

        if (is_callable($this->onreadystatechange)) {
            call_user_func($this->onreadystatechange);
        }
    }

    protected function isUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}
