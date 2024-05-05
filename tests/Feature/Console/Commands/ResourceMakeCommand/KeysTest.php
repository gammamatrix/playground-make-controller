<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Make\Controller\Console\Commands\ResourceMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Make\Controller\Console\Commands\ResourceMakeCommand;
use Tests\Feature\Playground\Make\Controller\TestCase;

/**
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\ResourceMakeCommand\KeysTest
 */
#[CoversClass(ResourceMakeCommand::class)]
class KeysTest extends TestCase
{
    public function test_command_make_keys_resource_with_force_and_without_skeleton(): void
    {
        $command = 'playground:make:resource testing --force --type keys';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_keys_resource_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:resource testing --skeleton --force --type keys';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
