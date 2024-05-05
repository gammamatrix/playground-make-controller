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
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\ResourceMakeCommand\CollectionTest
 */
#[CoversClass(ResourceMakeCommand::class)]
class CollectionTest extends TestCase
{
    public function test_command_make_resource_with_force_and_without_skeleton(): void
    {
        $command = 'playground:make:resource testing --force --type collection';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_collection_resource_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:resource testing --skeleton --force --type collection';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_named_collection_resource_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:resource TestingCollection --skeleton --force';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_named_collection_resource_with_option_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:resource Testing --skeleton --force --collection';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_collection_resource_with_option_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:resource Testing --skeleton --force --collection';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
