<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Make\Controller\Console\Commands\RequestMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Make\Controller\Console\Commands\RequestMakeCommand;
use Tests\Feature\Playground\Make\Controller\TestCase;

/**
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\RequestMakeCommand\AbstractTest
 */
#[CoversClass(RequestMakeCommand::class)]
class AbstractTest extends TestCase
{
    public function test_command_make_abstract_request_with_force_and_without_skeleton(): void
    {
        $command = 'playground:make:request testing --force --type abstract';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_abstract_request_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:request testing --skeleton --force --type abstract';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_abstract_index_request_with_force_and_without_skeleton(): void
    {
        $command = 'playground:make:request testing --force --type abstract-index';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_abstract_index_request_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:request testing --skeleton --force --type abstract-index';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_abstract_store_request_with_force_and_without_skeleton(): void
    {
        $command = 'playground:make:request testing --force --type abstract-store';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_abstract_store_request_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:request testing --skeleton --force --type abstract-store';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
