<?php

namespace Tests\traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

trait MockHttpCalls
{
    public function fakeHttpResponse()
    {
        $mock = $this->mock(Client::class);
        $mock->shouldReceive('request')
            ->andReturn(new Response(
                $status = 200,
                $headers = [],
                $body = 'mocked body'
            ));
    }
}
