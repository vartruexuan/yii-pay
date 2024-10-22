<?php

namespace vartruexuan\pay\http;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use Yansongda\Pay\Contract\HttpClientInterface;

class HttpClient extends HttpClientArtful implements HttpClientInterface
{
    use ClientTrait;
}