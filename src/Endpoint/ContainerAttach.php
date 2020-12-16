<?php

declare(strict_types=1);

namespace Docker\Endpoint;

use Docker\API\Endpoint\ContainerAttach as BaseEndpoint;
use Docker\Stream\DockerRawStream;
use Nyholm\Psr7\Stream;
use Symfony\Component\Serializer\SerializerInterface;

class ContainerAttach extends BaseEndpoint
{
    protected function transformResponseBody(string $body, int $status, SerializerInterface $serializer, ?string $contentType = null)
    {
        if (200 === $status && DockerRawStream::HEADER === $contentType) {
            $stream = Stream::create($body);
            $stream->rewind();

            return new DockerRawStream($stream);
        }

        return parent::transformResponseBody($body, $status, $serializer, $contentType);
    }
}
