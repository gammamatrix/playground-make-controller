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
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\PolicyMakeCommand\CommandTest
 */
#[CoversClass(PolicyMakeCommand::class)]
class CommandTest extends TestCase
{
    public function test_command_without_options_or_arguments(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:policy');
        $result->assertExitCode(1);
        $result->expectsOutputToContain( __('playground-make::generator.input.error'));
    }

    public function test_command_skeleton(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:policy testing --skeleton --force');
        $result->assertExitCode(0);
    }

    public function test_command_skeleton_with_roles_action(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:policy testing --skeleton --force --roles-action admin --roles-action wheel');
        $result->assertExitCode(0);
    }

    public function test_command_skeleton_with_roles_view(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:policy testing --skeleton --force --roles-view admin --roles-view wheel --roles-view user');
        $result->assertExitCode(0);
    }

    public function test_command_skeleton_with_roles_and_action_view(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:policy testing --skeleton --force --roles-action admin --roles-action wheel --roles-view admin --roles-view wheel --roles-view user');
        $result->assertExitCode(0);
    }

    public function test_command_userProviderModelGuard_with_invalid_guard(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-make-controller::generator.Policy.guard.required', [
            'guard' => 'some-super-guard',
        ]));

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:policy testing --skeleton --force --guard some-super-guard');
        $result->assertExitCode(0);
    }

    public function test_command_skeleton_with_type_playground_resource(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:policy testing --skeleton --force --type playground-resource');
        $result->assertExitCode(0);
    }

    public function test_command_skeleton_with_type_playground_api(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:policy testing --skeleton --force --type playground-api');
        $result->assertExitCode(0);
    }

    public function test_command_skeleton_with_type_api(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:policy testing --skeleton --force --type api');
        $result->assertExitCode(0);
    }

    public function test_command_skeleton_with_type_resource(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:policy testing --skeleton --force --type resource');
        $result->assertExitCode(0);
    }
}
