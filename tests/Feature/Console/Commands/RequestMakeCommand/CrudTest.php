<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Make\Controller\Console\Commands\RequestMakeCommand;

use Illuminate\Testing\PendingCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Make\Controller\Console\Commands\RequestMakeCommand;
use Tests\Feature\Playground\Make\Controller\TestCase;

/**
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\RequestMakeCommand\CrudTest
 */
#[CoversClass(RequestMakeCommand::class)]
class CrudTest extends TestCase
{
    public function test_command_make_destroy_request_with_force_and_without_skeleton(): void
    {
        $command = 'playground:make:request testing --force --type destroy --package acme';

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_destroy_request_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:request testing --skeleton --force --type destroy --package acme';

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_index_request_with_force_and_without_skeleton(): void
    {
        $command = 'playground:make:request testing --force --type index --package acme';

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_index_request_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:request testing --skeleton --force --type index --package acme';

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_store_request_with_force_and_without_skeleton(): void
    {
        $command = 'playground:make:request testing --force --type store --package acme';

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_store_request_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:request testing --skeleton --force --type store --package acme';

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_update_request_with_force_and_without_skeleton(): void
    {
        $command = 'playground:make:request testing --force --type update --package acme';

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_update_request_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:request testing --skeleton --force --type update --package acme';

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_other_request_with_force_and_without_skeleton(): void
    {
        $command = 'playground:make:request testing --force --type other --package acme';

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_other_request_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:request testing --skeleton --force --type other --package acme';

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_default_request_with_force_and_without_skeleton(): void
    {
        $command = 'playground:make:request testing --force --package acme';

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_default_request_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:request testing --skeleton --force --package acme';

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
