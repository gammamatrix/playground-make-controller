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
 * \Tests\Feature\Playground\Make\Controller\Console\Commands\RequestMakeCommand\ModelTest
 */
#[CoversClass(RequestMakeCommand::class)]
class ModelTest extends TestCase
{
    public function test_command_make_CreateRequest_with_force_and_without_skeleton(): void
    {
        $command = 'playground:make:request CreateRequest --type create --class CreateRequest --force --namespace Acme/Testing/Resource --package acme-testing-resource --model Acme/Testing/Models/Rocket --extends Acme/Testing/Resource/Http/Requests/FormRequest --model-file resources/testing/configurations/model.rocket.json --skeleton';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_IndexRequest_with_force_and_with_skeleton(): void
    {
        $command = 'playground:make:request IndexRequest --type index --class IndexRequest --force --namespace Acme/Testing/Resource --package acme-testing-resource --model Acme/Testing/Models/Rocket --extends Acme/Testing/Resource/Http/Requests/FormRequest --model-file resources/testing/configurations/model.rocket.json --skeleton';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_IndexRequest_with_force_and_with_skeleton_without_model_file(): void
    {
        $command = 'playground:make:request IndexRequest --type index --class IndexRequest --force --namespace Acme/Testing/Resource --package acme-testing-resource --model Acme/Testing/Models/Rocket --extends Acme/Testing/Resource/Http/Requests/FormRequest --skeleton';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_IndexRequest_under_Subfolder_with_force_and_with_skeleton_without_model_file(): void
    {
        $command = 'playground:make:request Subfolder --type index --class IndexRequest --force --namespace Acme/Testing/Resource --package acme-testing-resource --model Acme/Testing/Models/Rocket --extends Acme/Testing/Resource/Http/Requests/FormRequest --skeleton';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
