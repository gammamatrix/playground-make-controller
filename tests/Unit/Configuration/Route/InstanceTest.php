<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Make\Controller\Configuration\Route;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Make\Controller\TestCase;
use Playground\Make\Controller\Configuration\Route;

/**
 * \Tests\Unit\Playground\Make\Controller\Configuration\Route\InstanceTest
 */
#[CoversClass(Route::class)]
class InstanceTest extends TestCase
{
    public function test_instance(): void
    {
        $instance = new Route;

        $this->assertInstanceOf(Route::class, $instance);
    }

    /**
     * @var array<string, mixed>
     */
    protected array $expected_properties = [
        'class' => '',
        'config' => '',
        'fqdn' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        // properties
        'controller' => '',
        'extends' => '',
        'folder' => '',
        'models' => [],
        'model' => '',
        'model_column' => '',
        'model_fqdn' => '',
        'model_label' => '',
        'model_slug' => '',
        'model_slug_plural' => '',
        'type' => '',
        'route' => '',
        'route_prefix' => '',
        'title' => '',
    ];

    public function test_instance_apply_without_options(): void
    {
        $instance = new Route;

        $properties = $instance->apply()->properties();

        $this->assertIsArray($properties);

        $this->assertSame($this->expected_properties, $properties);

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertSame($properties, $jsonSerialize);
    }

    public function test_folder_is_empty_by_default(): void
    {
        $instance = new Route;

        $this->assertInstanceOf(Route::class, $instance);

        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());
    }

    public function test_with_file_and_skeleton(): void
    {
        $file = $this->getResourceFile('test-route');
        $content = file_exists($file) ? file_get_contents($file) : null;
        $options = $content ? json_decode($content, true) : [];

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new Route(
            is_array($options) ? $options : [],
            true
        );

        $instance->apply();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        //     '$instance' => $instance->toArray(),
        // ]);

        $this->assertNotEmpty($instance->folder());
        $this->assertTrue($instance->skeleton());


        $this->assertSame('contacts', $instance->class());
        $this->assertSame('ContactController', $instance->controller());
        $this->assertSame('', $instance->extends());
        $this->assertSame('Contact', $instance->name());
        $this->assertSame('contact', $instance->folder());
        $this->assertSame('GammaMatrix/Playground/Crm/Resource', $instance->namespace());
        $this->assertSame('GammaMatrix/Playground/Crm/Models/Contact', $instance->model());
        $this->assertSame('contact', $instance->model_column());
        $this->assertSame('Contact', $instance->model_label());
        $this->assertSame('contacts', $instance->model_slug_plural());
        $this->assertSame('', $instance->module());
        $this->assertSame('', $instance->module_slug());
        $this->assertSame('GammaMatrix', $instance->organization());
        $this->assertSame('playground-crm-resource', $instance->package());
        $this->assertSame('playground-crm-resource', $instance->config());
        $this->assertSame('playground-resource', $instance->type());
        $this->assertSame('playground.crm.resource.contacts', $instance->route());
        $this->assertSame('resource/crm/contacts', $instance->route_prefix());
        $this->assertSame('Contact', $instance->title());
        $this->assertSame([
            'Contact' => 'resources/testing/configurations/test.model.crm.contact.json',
        ], $instance->models());
    }
}
