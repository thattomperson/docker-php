<?php

declare(strict_types=1);

namespace Docker\Endpoint;

use Docker\API\Endpoint\SystemEvents as BaseEndpoint;
use Docker\Stream\EventStream;
use Nyholm\Psr7\Stream;
use Symfony\Component\Serializer\SerializerInterface;

class SystemEvents extends BaseEndpoint
{
    protected function transformResponseBody(string $body, int $status, SerializerInterface $serializer, ?string $contentType = null)
    {
        if (200 === $status) {
            $stream = Stream::create($body);
            $stream->rewind();

            return new EventStream($stream, $serializer);
        }

        return parent::transformResponseBody($body, $status, $serializer, $contentType);
    }
}
