<?php

namespace App\Tests\Functional\Controller;

use App\Entity\Repair;
use App\Repository\RepairRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackerControllerTest extends WebTestCase
{
    private const INDEX = "/";
    private const SEARCH = "/tracker";
    private const PRIVACY = "/privacy";
    private const TERMS = "/terms";

    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_GET,
            self::INDEX
        );

        $response = $client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testSearch(): void
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_POST,
            self::SEARCH,
            [],
            [],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest'],
            "SR-1639938538"
        );

        $repairRepository = $this->createMock(RepairRepository::class);
        $repairRepository
            ->method('findOneBy')
            ->willReturn(Repair::class);

        $response = $client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testPrivacy(): void
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_GET,
            self::PRIVACY
        );

        $response = $client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testTerms(): void
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_GET,
            self::TERMS
        );

        $response = $client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}