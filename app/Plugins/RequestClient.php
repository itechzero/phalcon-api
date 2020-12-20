<?php
declare(strict_types=1);

namespace App\Plugins;

use App\Traits\DiTrait;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;

class RequestClient
{
    use DiTrait;

    private $client;

    public function __construct(array $options = [])
    {
        $defaultOptions = [
            'on_stats' => function (TransferStats $stats) {
                $request = $stats->getRequest();
                $uri = $request->getUri();
                $body = $request->getBody()->__toString();
                $method = $request->getMethod();

                if ($stats->hasResponse()) {
                    $response = $stats->getResponse();
                    $statusCode = $response->getStatusCode();
                    $response = $response->getBody()->__toString();
                    $requestTime = $stats->getTransferTime();
                    $this->di->getShared('log')->info(
                        sprintf("Url:%s, Method:%s, Body:%s Status:%s Response:%s, Time:%s\n",
                            $uri, $method, $body, $statusCode, $response, $requestTime));
                } else {
                    $this->di->getShared('log')->info(
                        sprintf("Url:%s, Method:%s, Body:%s Response:null\n",
                            $uri, $method, $body));
                }
            },
            'timeout' => 3
        ];

        if ($options) {
            $defaultOptions = array_merge($defaultOptions, $options);
        }

        $this->client = new Client($defaultOptions);
    }
}