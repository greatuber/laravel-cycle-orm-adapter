<?php

declare(strict_types=1);

namespace WayOfDev\Cycle\Bridge\Laravel\Providers\Registrators;

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\DatabaseInterface;
use Cycle\Database\DatabaseManager;
use Cycle\Database\DatabaseProviderInterface;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository as IlluminateConfig;
use WayOfDev\Cycle\Bridge\Laravel\Providers\Registrator;

final class RegisterDatabase
{
    public function __invoke(Container $app): void
    {
        $app->singleton(DatabaseConfig::class, static function (Container $app): DatabaseConfig {
            /** @var IlluminateConfig $config */
            $config = $app[IlluminateConfig::class];

            return new DatabaseConfig(
                config: $config->get(Registrator::CFG_KEY_DATABASE)
            );
        });

        $app->singleton(DatabaseProviderInterface::class, static function (Container $app): DatabaseProviderInterface {
            return new DatabaseManager(
                config: $app[DatabaseConfig::class]
            );
        });

        $app->bind(DatabaseInterface::class, static function (Container $app): DatabaseInterface {
            return $app[DatabaseProviderInterface::class]->database();
        });

        $app->alias(DatabaseProviderInterface::class, DatabaseManager::class);
    }
}
