<?php

declare(strict_types=1);

namespace Docker\Endpoint;

use Docker\API\Endpoint\ImagePush as BaseEndpoint;
use Docker\Stream\PushStream;
use Nyholm\Psr7\Stream;
use Symfony\Component\Serializer\SerializerInterface;

class ImagePush extends BaseEndpoint
{
    public function getUri(): string
    {
        return \str_replace(['{name}'], [\urlencode($this->name)], '/images/{name}/push');
    }

    protected function transformResponseBody(string $body, int $status, SerializerInterface $serializer, ?string $contentType = null)
    {
        if (200 === $status) {
            $stream = Stream::create($body);
            $stream->rewind();

            return new PushStream($stream, $serializer);
        }

        return parent::transformResponseBody($body, $status, $serializer, $contentType);
    }
}
