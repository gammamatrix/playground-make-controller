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
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\RouteMakeCommand\CommandTest
 */
#[CoversClass(RouteMakeCommand::class)]
class ApiTest extends TestCase
{
    public function test_command_make_playground_api_route_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:route testing --force --type playground-api --model-file %1$s',
            $this->getResourceFile('playground-model-api')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_api_route_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:route testing --skeleton --force --type playground-api --model-file %1$s',
            $this->getResourceFile('playground-model-api')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_api_route_without_model_file(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Provide a [--model-file] with a [create] section.');

        $command = 'playground:make:route testing --skeleton --force --type playground-api';

        $this->artisan($command);
    }
}
