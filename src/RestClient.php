<?php

namespace Salesfly;

require_once "Constants.php";

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Salesfly\Exceptions\APIConnectionException;
use Salesfly\Exceptions\APITimeoutException;
use Salesfly\Exceptions\ResponseException;

class RestClient
{
    protected $apiKey;
    protected $http;
    protected $timeout;

    public function __construct($apiKey, $timeout = 30.0)
    {
        $this->apiKey = $apiKey;
        $this->timeout = $timeout;

        if (empty($this->apiKey)) {
            throw new \InvalidArgumentException("No API key provided");
        }

        $this->http = new \GuzzleHttp\Client([
            "base_uri" => API_BASE_URL,
            "timeout" => $this->timeout,
            "connect_timeout" => $this->timeout,
            "read_timeout" => $this->timeout,
        ]);
    }

    public function setHttpClient($httpClient)
    {
        $this->http = $httpClient;
    }

    public function get($path, $headers = array())
    {
        return $this->execute("GET", $path, array(), $headers);
    }

    public function post($path, $params, $headers = array())
    {
        return $this->execute("POST", $path, $params, $headers);
    }

    public function put($path, $params, $headers = array())
    {
        return $this->execute("PUT", $path, $params, $headers);
    }

    public function patch($path, $params, $headers = array())
    {
        return $this->execute("PATCH", $path, $params, $headers);
    }

    public function delete($path, $headers = array())
    {
        return $this->execute("DELETE", $path, array(), $headers);
    }

    protected function execute($method, $path, $params = array(), $headers = array())
    {
        $std_headers = [
            "Authorization" => "Bearer " . $this->apiKey,
            "User-Agent" => "salesfly-php/" . VERSION,
            "Accept" => "application/json",
            "Content-Type" => "application/json",
        ];
        $headers = array_merge($std_headers, $headers);

        $payload = array();
        if (!is_null($params)) {
            if ($headers["Content-Type"] == "application/json") {
                $payload["json"] = $params;
            } else if ($headers["Content-Type"] == "multipart/form-data") {
                $boundary = $this->generateRandomString();
                $headers["Content-Type"] = "multipart/form-data; boundary=" . $boundary;
                $payload["body"] = new \GuzzleHttp\Psr7\MultipartStream($params, $boundary);
            }
        }
        $payload["headers"] = $headers;

        try {
            $response = $this->http->request($method, $path, $payload);
            if ($headers["Accept"] == "application/pdf") {
                return $response->getBody();
            }
            $result = json_decode($response->getBody(), true);
            return $result["data"];

/*
$request = new \GuzzleHttp\Psr7\Request($method, API_BASE_URL . $path, $headers, $payload);
$response = $this->http->send($request, [
"timeout" => $this->timeout,
"connect_timeout" => $this->timeout,
"read_timeout" => $this->timeout,
]);

var_dump($response->getBody());

$h = $response->getHeaders();
var_dump($h);
if ($h["Content-Type"] == "application/pdf") {
return $response->getBody();
}

$result = json_decode($response->getBody(), true);
return $result["data"];*/
        } catch (ConnectException $e) {
            $reason = $e->getMessage();
            $pos = strpos($reason, "cURL error 28");
            if ($pos === false) {
                throw new APIConnectionException($reason);
            } else {
                throw new APITimeoutException($reason);
            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $status = $response->getStatusCode();
                $message = $e->getMessage();
                //$code = $e->getMessage();

                $pieces = explode("\n", $message);
                if (count($pieces) > 1) {
                    $body = $pieces[1];
                    $error = Error::fromJSON($body);
                    if ($error->isValid()) {
                        throw new ResponseException($status, $error->message, $error->code);
                    } else {
                        throw new ResponseException($status, $message);
                    }
                } else {
                    throw new ResponseException($status, $message);
                }
            } else {
                throw new APIConnectionException($e->getMessage());
            }
        }
    }

    protected function generateRandomString($length = 32)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
}
