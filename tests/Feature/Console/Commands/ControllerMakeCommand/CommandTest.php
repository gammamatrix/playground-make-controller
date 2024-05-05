<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Make\Controller\Console\Commands\ControllerMakeCommand;

use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Make\Controller\Console\Commands\ControllerMakeCommand;
use Tests\Feature\Playground\Make\Controller\TestCase;

/**
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\ControllerMakeCommand\CommandTest
 */
#[CoversClass(ControllerMakeCommand::class)]
class CommandTest extends TestCase
{
    public function test_command_without_options_or_arguments(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:controller');
        $result->assertExitCode(1);
        $result->expectsOutputToContain(__('playground-make::generator.input.error'));
    }

    public function test_command_skeleton(): void
    {
        // $result = $this->withoutMockingConsoleOutput()->artisan('playground:make:controller testing --skeleton --force');
        // dd(Artisan::output());
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:controller testing --skeleton --force');
        $result->assertExitCode(0);
    }
}
