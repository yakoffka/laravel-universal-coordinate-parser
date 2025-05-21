<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Yakoffka\UniversalCoordinateParser\Parser;

/**
 * Примеры вызова тестов:
 *  $ docker-compose exec php vendor/bin/testbench package:test
 *  $ ./vendor/bin/phpunit
 *  $ composer test
 */
abstract class TestCase extends TestbenchTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->parser = new Parser();
    }

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [];
    }

    /**
     * Override application aliases.
     *
     * @param Application $app
     *
     * @return array<string, class-string<Facade>>
     */
    protected function getPackageAliases($app): array
    {
        return [];
    }

    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        // perform environment setup
    }
}