<?php

declare(strict_types=1);

namespace WayOfDev\Tests\Bridge\Laravel\Providers;

use Cycle\Database\Config\DatabaseConfig;
use Cycle\ORM\EntityManagerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use WayOfDev\Tests\TestCase;

class CycleServiceProviderTest extends TestCase
{
    /**
     * @test
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function it_gets_database_config_from_container(): void
    {
        /** @var DatabaseConfig $config */
        $config = $this->app->get(DatabaseConfig::class);

        self::assertArrayHasKey('default', $config->toArray());
        self::assertArrayHasKey('databases', $config->toArray());
        self::assertArrayHasKey('drivers', $config->toArray());
    }

    /**
     * @test
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function it_gets_entity_manager_instance_from_container(): void
    {
        $manager = $this->app->get(EntityManagerInterface::class);
        self::assertInstanceOf(EntityManagerInterface::class, $manager);
    }
}