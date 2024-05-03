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
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\ControllerMakeCommand\FileTest
 */
#[CoversClass(ControllerMakeCommand::class)]
class FileTest extends TestCase
{
    public function test_command_make_controller_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:controller --force --file %1$s',
            $this->getResourceFile('controller-playground-resource')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_controller_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:controller --skeleton --force --file "%1$s"',
            $this->getResourceFile('controller-playground-resource')
        );
        // dump($command);
        // $result = $this->withoutMockingConsoleOutput()->artisan('playground:make:controller testing --skeleton --force');
        // dump(Artisan::output());

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
