<?php

namespace Lazy\AppStore\Traits;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

trait HttpRequest
{
    protected function getHttpClient(array $options = [])
    {
        return new Client($options);
    }

    protected function getBaseOptions()
    {
        $options = [
            'timeout' => method_exists($this, 'getTimeOut') ? $this->getTimeOut() : 5.0,
        ];
        return $options;
    }

    protected function request($method, $uri, $options = [])
    {
        return $this->unwrapResponse($this->getHttpClient($this->getBaseOptions())->{$method}($uri, $options));
    }
    protected function unwrapResponse(ResponseInterface $response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        $contents = $response->getBody()->getContents();
        if (false !== stripos($contentType, 'json') || stripos($contentType, 'javascript')) {
            return json_decode($contents, true);
        } elseif (false !== stripos($contentType, 'xml')) {
            return json_decode(json_encode(simplexml_load_string($contents)), true);
        }
        return $contents;
    }

    protected function get($uri, $query = [], $headers = [])
    {
        return $this->request('get', $uri, [
            'headers' => $headers,
            'query' => $query,
        ]);
    }

    protected function post($uri, $params = [], $headers = [])
    {
        return $this->request('post', $uri, [
            'headers' => $headers,
            'form_params' => $params,
        ]);
    }

    protected function postJson($uri, $params = [], $headers = [])
    {
        return $this->request('post', $uri, [
            'headers' => $headers,
            'json' => $params,
        ]);
    }
}
