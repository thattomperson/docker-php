<?php

declare(strict_types=1);

namespace Docker;

use Docker\API\Client;
use Docker\API\Model\AuthConfig;
use Docker\Endpoint\ImagePush;

/**
 * Docker\Docker.
 */
class Docker extends Client
{
    /**
     * {@inheritdoc}
     */
    public function imagePush(string $name, array $queryParameters = [], array $headerParameters = [], string $fetch = self::FETCH_OBJECT, array $accept = [])
    {
        if (isset($headerParameters['X-Registry-Auth']) && $headerParameters['X-Registry-Auth'] instanceof AuthConfig) {
            $headerParameters['X-Registry-Auth'] = \base64_encode($this->serializer->serialize($headerParameters['X-Registry-Auth'], 'json'));
        }

        return $this->executeEndpoint(new ImagePush($name, $queryParameters, $headerParameters, $accept), $fetch);
    }

    public static function create($httpClient = null, array $additionalPlugins = [], array $additionalNormalizers = [])
    {
        if (null === $httpClient) {
            $httpClient = DockerClientFactory::createFromEnv();
        }

        return parent::create($httpClient, $additionalPlugins, $additionalNormalizers);
    }
}
