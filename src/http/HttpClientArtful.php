<?php

namespace vartruexuan\pay\http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class HttpClientArtful extends Client implements ClientInterface
{
    use ClientTrait;
}