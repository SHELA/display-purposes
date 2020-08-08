<?php

namespace Shela\DisplayPurposes\API;

use GuzzleHttp\Exception\RequestException;

class Request
{
    private $client;
    private $proxy = '';
    private $basic_headers = [
        'Accept'       => 'application/json',
        'Content-type' => 'application/json',
        'api-token' => 'bd55c53d58af3dc1de12d37c9c5c6fd2',
        'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.48 Safari/537.36'
    ];

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function request($url, $method = 'GET', $headers = [])
    {
        $headers = $this->combineHeaders($headers);
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->request($method, $url, [
                'headers' => $headers,
                'proxy'   => $this->proxy,
            ]);
            $result = json_decode($response->getBody()->getContents());

            return $result;
        } catch (RequestException $e) {
            $response = $this->StatusCodeHandling($e);

            return $response;
        }
    }

    public function setProxy($proxy = '')
    {
        $this->proxy = $proxy;
    }

    private function combineHeaders($headers)
    {
        return $this->basic_headers + $headers;
    }

    public function StatusCodeHandling($e)
    {
        if ($e->getResponse()->getStatusCode() == '400') {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());

            return $response;
        } elseif ($e->getResponse()->getStatusCode() == '422') {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());

            return $response;
        } elseif ($e->getResponse()->getStatusCode() == '500') {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());

            return $response;
        } elseif ($e->getResponse()->getStatusCode() == '401') {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());

            return $response;
        } elseif ($e->getResponse()->getStatusCode() == '403') {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());

            return $response;
        } else {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());

            return $response;
        }
    }
}
