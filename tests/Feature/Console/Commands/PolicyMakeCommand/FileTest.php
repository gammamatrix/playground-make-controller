<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Make\Controller\Console\Commands\PolicyMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Make\Controller\Console\Commands\PolicyMakeCommand;
use Tests\Feature\Playground\Make\Controller\TestCase;

/**
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\PolicyMakeCommand\FileTest
 */
#[CoversClass(PolicyMakeCommand::class)]
class FileTest extends TestCase
{
    public function test_command_make_policy_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:policy --force --file %1$s',
            $this->getResourceFile('test-policy')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_policy_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:policy --skeleton --force --file %1$s',
            $this->getResourceFile('test-policy')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
