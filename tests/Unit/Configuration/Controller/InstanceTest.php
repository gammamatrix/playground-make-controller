<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Make\Controller\Configuration\Controller;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Make\Controller\Configuration\Controller;
use Tests\Unit\Playground\Make\Controller\TestCase;

/**
 * \Tests\Unit\Playground\Make\Controller\Configuration\Controller\InstanceTest
 */
#[CoversClass(Controller::class)]
class InstanceTest extends TestCase
{
    public function test_instance(): void
    {
        $instance = new Controller;

        $this->assertInstanceOf(Controller::class, $instance);
    }

    /**
     * @var array<string, mixed>
     */
    protected array $expected_properties = [
        'class' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'fqdn' => '',
        'model' => '',
        'organization' => '',
        'package' => '',
        'type' => '',
        'isAbstract' => false,
        'withBlades' => false,
        'withPolicies' => false,
        'withRequests' => false,
        'withRoutes' => false,
        'withSwagger' => false,
        'withTests' => false,
        'playground' => false,
        'revision' => false,
        'models' => [],
        'policies' => [],
        'requests' => [],
        'resources' => [],
        'templates' => [],
        'transformers' => [],
        'extends' => '',
        'extends_use' => '',
        'slug' => '',
        'slug_plural' => '',
        'model_route' => '',
        'module_route' => '',
        'privilege' => '',
        'route' => '',
        'view' => '',
        'implements' => [],
        'uses' => [],
        'packageInfo' => null,
    ];

    public function test_instance_apply_without_options(): void
    {
        $instance = new Controller;

        $properties = $instance->apply()->properties();

        $this->assertIsArray($properties);

        $this->assertSame($this->expected_properties, $properties);

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertSame($properties, $jsonSerialize);
    }

    public function test_folder_is_empty_by_default(): void
    {
        $instance = new Controller;

        $this->assertInstanceOf(Controller::class, $instance);

        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());
    }

    public function test_resource_controller_with_file_and_skeleton(): void
    {
        $options = $this->getResourceFileAsArray('controller-playground-resource');
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new Controller($options, true);

        $instance->apply();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$instance' => $instance,
        //     // 'json_encode($instance)' => json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        //     // '$options' => $options,
        // ]);
        // echo(json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        $this->assertEmpty($instance->folder());
        $this->assertTrue($instance->skeleton());

        $this->assertSame('Playground', $instance->organization());
        $this->assertSame('playground-matrix-resource', $instance->package());
        $this->assertSame('Matrix', $instance->module());
        $this->assertSame('matrix', $instance->module_slug());
        $this->assertSame('', $instance->fqdn());
        $this->assertSame('Playground/Matrix/Resource', $instance->namespace());
        $this->assertSame('Backlog', $instance->name());
        $this->assertSame('BacklogController', $instance->class());
        $this->assertSame('playground-resource', $instance->type());
        // $this->assertSame([
        //     'resources/configurations/playground-matrix-resource/backlog/request.destroy.json',
        //     'resources/configurations/playground-matrix-resource/backlog/request.index.json',
        //     'resources/configurations/playground-matrix-resource/backlog/request.restore.json',
        //     'resources/configurations/playground-matrix-resource/backlog/request.show.json',
        //     'resources/configurations/playground-matrix-resource/backlog/request.store.json',
        //     'resources/configurations/playground-matrix-resource/backlog/request.update.json'
        // ], $instance->requests());
        // $this->assertSame([
        //     'resources/configurations/playground-matrix-resource/backlog/resource.json',
        //     'resources/configurations/playground-matrix-resource/backlog/resource.collection.json'
        // ], $instance->resources());
        // $this->assertSame([
        //     'resources/configurations/playground-matrix-resource/backlog/resource.json',
        //     'resources/configurations/playground-matrix-resource/backlog/resource.collection.json'
        // ], $instance->resources());
        $this->assertTrue($instance->playground());
    }

    public function test_api_controller_with_file_and_skeleton(): void
    {
        $options = $this->getResourceFileAsArray('controller-playground-api');

        $instance = new Controller($options, true);

        $instance->apply();
        $this->assertEmpty($instance->folder());
        $this->assertTrue($instance->skeleton());

        $this->assertSame('Acme', $instance->organization());
        $this->assertSame('acme-demo-api', $instance->package());
        $this->assertSame('Demo', $instance->module());
        $this->assertSame('demo', $instance->module_slug());
        $this->assertSame('', $instance->fqdn());
        $this->assertSame('Acme\\Demo\\Api', $instance->namespace());
        $this->assertSame('Rocket', $instance->name());
        $this->assertSame('RocketController', $instance->class());
        $this->assertSame('playground-api', $instance->type());
        $this->assertTrue($instance->playground());
    }
}
