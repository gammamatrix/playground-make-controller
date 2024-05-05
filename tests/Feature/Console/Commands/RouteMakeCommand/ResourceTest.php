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
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\RouteMakeCommand\ResourceTest
 */
#[CoversClass(RouteMakeCommand::class)]
class ResourceTest extends TestCase
{
    public function test_command_make_playground_resource_route_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:route testing --force --type playground-resource --model-file %1$s',
            $this->getResourceFile('playground-model-resource')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_resource_route_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:route testing --skeleton --force --type playground-resource --model-file %1$s',
            $this->getResourceFile('playground-model-resource')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_resource_route_without_model_file(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Provide a [--model-file] with a [create] section.');

        $command = 'playground:make:route testing --skeleton --force --type playground-resource';

        $this->artisan($command);
    }

    public function test_command_make_playground_resource_index_route_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:route testing --force --type playground-resource-index --model-file %1$s',
            $this->getResourceFile('playground-model-resource')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_resource_index_route_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:route testing --skeleton --force --type playground-resource-index --model-file %1$s',
            $this->getResourceFile('playground-model-resource')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_resource_index_route_without_model_file(): void
    {
        $command = 'playground:make:route testing --skeleton --force --type playground-resource-index';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
