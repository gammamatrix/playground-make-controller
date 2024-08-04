<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Make\Controller\Configuration\Resource;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Make\Controller\Configuration\Resource;
use Tests\Unit\Playground\Make\Controller\TestCase;

/**
 * \Tests\Unit\Playground\Make\Controller\Configuration\Resource\InstanceTest
 */
#[CoversClass(Resource::class)]
class InstanceTest extends TestCase
{
    public function test_instance(): void
    {
        $instance = new Resource;

        $this->assertInstanceOf(Resource::class, $instance);
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
        'collection' => false,
        'model' => '',
        'model_fqdn' => '',
        'model_slug' => '',
        'type' => '',
        'models' => [],
    ];

    public function test_instance_apply_without_options(): void
    {
        $instance = new Resource;

        $properties = $instance->apply()->properties();

        $this->assertIsArray($properties);

        $this->assertSame($this->expected_properties, $properties);

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertSame($properties, $jsonSerialize);
    }

    public function test_folder_is_empty_by_default(): void
    {
        $instance = new Resource;

        $this->assertInstanceOf(Resource::class, $instance);

        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());
    }

    public function test_with_file_and_skeleton(): void
    {
        $file = $this->getResourceFile('test-resource');
        $content = file_exists($file) ? file_get_contents($file) : null;
        $options = $content ? json_decode($content, true) : [];

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new Resource(
            is_array($options) ? $options : [],
            true
        );

        $instance->apply();

        $this->assertEmpty($instance->folder());
        $this->assertTrue($instance->skeleton());

        $this->assertSame('Playground', $instance->organization());
        $this->assertSame('playground-matrix-resource', $instance->package());
        $this->assertSame('playground-resource', $instance->type());
        $this->assertSame('', $instance->extends());
        $this->assertSame('Playground\\Matrix\\Resource', $instance->namespace());
        $this->assertFalse($instance->collection());
        $this->assertSame('Backlog', $instance->name());
        $this->assertSame('BacklogResource', $instance->class());
    }

    public function test_with_file_and_skeleton_as_collection(): void
    {
        $file = $this->getResourceFile('test-resource');
        $content = file_exists($file) ? file_get_contents($file) : null;
        $options = $content ? json_decode($content, true) : [];

        if (is_array($options)) {
            $options['collection'] = true;
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new Resource(
            is_array($options) ? $options : [],
            true
        );

        $instance->apply();

        $this->assertEmpty($instance->folder());
        $this->assertTrue($instance->skeleton());

        $this->assertSame('Playground', $instance->organization());
        $this->assertSame('playground-matrix-resource', $instance->package());
        $this->assertSame('playground-resource', $instance->type());
        $this->assertSame('', $instance->extends());
        $this->assertSame('Playground\\Matrix\\Resource', $instance->namespace());
        $this->assertTrue($instance->collection());
        $this->assertSame('Backlog', $instance->name());
        $this->assertSame('BacklogResource', $instance->class());
    }
}
