<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Make\Controller\Console\Commands\RequestMakeCommand;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\PendingCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Make\Controller\Console\Commands\RequestMakeCommand;
use Tests\Feature\Playground\Make\Controller\TestCase;

/**
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\RequestMakeCommand\FileTest
 */
#[CoversClass(RequestMakeCommand::class)]
class FileTest extends TestCase
{
    public function test_command_make_request_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:request --force --file %1$s',
            $this->getResourceFile('test-request')
        );
        //         dump($command);
        //         $result = $this->withoutMockingConsoleOutput()->artisan($command);
        //         dd(Artisan::output());

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
        $result->expectsOutputToContain('Request [storage/app/stub/acme-demo/src/Http/Requests/FormRequest.php] created successfully.');
        $result->expectsOutputToContain('The configuration [request.form-request.json] was saved in [storage/app/stub/acme-demo/resources/package/request.form-request.json].');
    }

    public function test_command_make_request_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:request --skeleton --force --file %1$s',
            $this->getResourceFile('test-request')
        );
        // dump($command);
        // $result = $this->withoutMockingConsoleOutput()->artisan($command);
        // dd(Artisan::output());

        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
        $result->expectsOutputToContain('Request [storage/app/stub/acme-demo/src/Http/Requests/FormRequest.php] created successfully.');
        $result->expectsOutputToContain('The configuration [request.form-request.json] was saved in [storage/app/stub/acme-demo/resources/package/request.form-request.json].');
    }
}
