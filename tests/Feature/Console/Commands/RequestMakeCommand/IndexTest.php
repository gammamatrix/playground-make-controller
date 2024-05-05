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
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\RequestMakeCommand\IndexTest
 */
#[CoversClass(RequestMakeCommand::class)]
class IndexTest extends TestCase
{
    public function test_command_make_FormRequest(): void
    {
        $command = 'playground:make:request FormRequest --namespace Acme/Testing/Resource --package acme-testing-resource --class FormRequest --model Illuminate/Database/Eloquent/Model --skeleton --force --type abstract';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_AbstractIndexRequest(): void
    {
        $command = 'playground:make:request AbstractIndexRequest --namespace Acme/Testing/Resource --package acme-testing-resource --model Illuminate/Database/Eloquent/Model --class AbstractIndexRequest --extends FormRequest --skeleton --force --type abstract-index --abstract --with-pagination';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_AbstractStoreRequest(): void
    {
        $command = 'playground:make:request AbstractStoreRequest --namespace Acme/Testing/Resource --package acme-testing-resource --model Illuminate/Database/Eloquent/Model --class AbstractStoreRequest --extends FormRequest --skeleton --force --type abstract-store --abstract --with-store';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
