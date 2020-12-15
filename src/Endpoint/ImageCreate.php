<?php

declare(strict_types=1);

namespace Docker\Endpoint;

use Docker\API\Endpoint\ImageCreate as BaseEndpoint;
use Docker\Stream\CreateImageStream;
use Nyholm\Psr7\Stream;
use Symfony\Component\Serializer\SerializerInterface;

class ImageCreate extends BaseEndpoint
{
    protected function transformResponseBody(string $body, int $status, SerializerInterface $serializer, ?string $contentType = null)
    {
        if (200 === $status) {
            $stream = Stream::create($body);
            $stream->rewind();

            return new CreateImageStream($stream, $serializer);
        }

        return parent::transformResponseBody($body, $status, $serializer, $contentType);
    }
}
