<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Make\Controller\Console\Commands\ResourceMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Make\Controller\Console\Commands\ResourceMakeCommand;
use Tests\Feature\Playground\Make\Controller\TestCase;
use TiMacDonald\Log\LogEntry;
use TiMacDonald\Log\LogFake;

/**
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\ResourceMakeCommand\StubTest
 */
#[CoversClass(ResourceMakeCommand::class)]
class StubTest extends TestCase
{
    public function test_command_with_invalid_stubs_path_in_the_config(): void
    {
        $log = LogFake::bind();

        config(['playground-make.paths.stubs' => '/tmp/does-not-exist']);

        $this->artisan('playground:make:resource testing --force --skeleton');

        // $log->dump();

        $log->assertLogged(
            fn (LogEntry $log) => $log->level === 'error'
        );

        $log->assertLogged(
            fn (LogEntry $log) => is_string($log->message) && str_contains(
                $log->message,
                __('playground-make::generator.stub.path.invalid')
            )
        );
    }

    public function test_command_with_invalid_path_to_stub_in_the_config(): void
    {
        $this->expectException(\Illuminate\Contracts\Filesystem\FileNotFoundException::class);
        $this->expectExceptionMessage('File does not exist at path /tmp/resource/resource.stub.');

        config(['playground-make.paths.stubs' => '/tmp']);

        $this->artisan('playground:make:resource testing --force --skeleton');
        // $result->assertExitCode(1);
        // $result->expectsOutputToContain(__('playground-make::generator.stub.missing', [
        //     'stub_path' => '/tmp',
        //     'stub' => 'resource/resource.stub',
        //     'path' => '/tmp/resource/resource.stub',
        // ]));
    }
}
