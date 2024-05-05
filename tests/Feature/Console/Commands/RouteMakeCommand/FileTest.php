<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Make\Controller\Console\Commands\RouteMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Make\Controller\Console\Commands\RouteMakeCommand;
use Tests\Feature\Playground\Make\Controller\TestCase;

/**
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\RouteMakeCommand\FileTest
 */
#[CoversClass(RouteMakeCommand::class)]
class FileTest extends TestCase
{
    public function test_command_make_route_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:route --force --file %1$s',
            $this->getResourceFile('route')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_route_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:route --skeleton --force --file %1$s',
            $this->getResourceFile('route')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
