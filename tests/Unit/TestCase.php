<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Make\Controller;

use Playground\Test\OrchestraTestCase;

/**
 * \Tests\Unit\Playground\Make\Controller\TestCase
 */
class TestCase extends OrchestraTestCase
{
    use FileTrait;

    protected function getPackageProviders($app)
    {
        return [
            \Playground\ServiceProvider::class,
            \Playground\Make\ServiceProvider::class,
            \Playground\Make\Blade\ServiceProvider::class,
            \Playground\Make\Controller\ServiceProvider::class,
            \Playground\Make\Swagger\ServiceProvider::class,
            \Playground\Make\Test\ServiceProvider::class,
        ];
    }
}
