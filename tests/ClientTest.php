<?php

namespace Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Organiseyou\Client\Client;
use Organiseyou\Client\Types\Entity;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testEntitiesList()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'entitiesList' => [
                        [
                            'id' => '123',
                            'name' => 'Test Entity',
                            'label' => 'Test Label',
                            'columns' => [],
                            'created_at' => '2023-01-01',
                            'updated_at' => '2023-01-01',
                        ]
                    ]
                ]
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handlerStack]);

        $client = new Client('https://api.example.com', 'token', $guzzle);
        $entities = $client->entities()->list();

        $this->assertCount(1, $entities);
        $this->assertInstanceOf(Entity::class, $entities[0]);
        $this->assertEquals('123', $entities[0]->id);
        $this->assertEquals('Test Entity', $entities[0]->name);
    }

    public function testCreateEntity()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'createEntity' => [
                        'id' => '456',
                        'name' => 'New Entity',
                        'label' => 'New Label',
                        'columns' => [],
                        'created_at' => '2023-01-02',
                        'updated_at' => '2023-01-02',
                    ]
                ]
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handlerStack]);

        $client = new Client('https://api.example.com', 'token', $guzzle);
        $entity = $client->entities()->create([
            'name' => 'New Entity',
            'label' => 'New Label',
            'columns' => []
        ]);

        $this->assertInstanceOf(Entity::class, $entity);
        $this->assertEquals('456', $entity->id);
        $this->assertEquals('New Entity', $entity->name);
    }

    public function testGraphQLError()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'errors' => [
                    ['message' => 'Some error occurred']
                ]
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $handlerStack]);

        $client = new Client('https://api.example.com', 'token', $guzzle);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('GraphQL Error');

        $client->entities()->list();
    }
}
