<?php

namespace Organiseyou\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Organiseyou\Client\Resources\DashboardResource;
use Organiseyou\Client\Resources\EndpointResource;
use Organiseyou\Client\Resources\EntityResource;
use Organiseyou\Client\Resources\FormResource;
use Organiseyou\Client\Resources\GridResource;
use Organiseyou\Client\Resources\ImporterResource;

class Client
{
    private GuzzleClient $httpClient;
    private string $baseUrl;
    private string $apiToken;

    public function __construct(string $baseUrl, string $apiToken, ?GuzzleClient $httpClient = null)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->apiToken = $apiToken;
        
        $this->httpClient = $httpClient ?? new GuzzleClient([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function entities(): EntityResource
    {
        return new EntityResource($this);
    }

    public function dashboards(): DashboardResource
    {
        return new DashboardResource($this);
    }

    public function forms(): FormResource
    {
        return new FormResource($this);
    }

    public function grids(): GridResource
    {
        return new GridResource($this);
    }

    public function endpoints(): EndpointResource
    {
        return new EndpointResource($this);
    }

    public function importers(): ImporterResource
    {
        return new ImporterResource($this);
    }

    /**
     * Execute a GraphQL query.
     *
     * @param string $query
     * @param array $variables
     * @return array
     * @throws \Exception
     */
    public function query(string $query, array $variables = []): array
    {
        try {
            $response = $this->httpClient->post('/graphql', [
                'json' => [
                    'query' => $query,
                    'variables' => $variables,
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            if (isset($body['errors'])) {
                throw new \Exception('GraphQL Error: ' . json_encode($body['errors']));
            }

            return $body['data'] ?? [];
        } catch (GuzzleException $e) {
            throw new \Exception('HTTP Request Error: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
