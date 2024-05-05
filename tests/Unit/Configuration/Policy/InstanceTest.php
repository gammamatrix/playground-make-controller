<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Make\Controller\Configuration\Policy;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Make\Controller\TestCase;
use Playground\Make\Controller\Configuration\Policy;

/**
 * \Tests\Unit\Playground\Make\Controller\Configuration\Policy\InstanceTest
 */
#[CoversClass(Policy::class)]
class InstanceTest extends TestCase
{
    public function test_instance(): void
    {
        $instance = new Policy;

        $this->assertInstanceOf(Policy::class, $instance);
    }

    /**
     * @var array<string, mixed>
     */
    protected array $expected_properties = [
        'class' => '',
        'config' => '',
        'fqdn' => '',
        'model' => '',
        'model_fqdn' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        'playground' => false,
        // properties
        'models' => [],
        'rolesForAction' => [],
        'rolesToView' => [],
    ];

    public function test_instance_apply_without_options(): void
    {
        $instance = new Policy;

        $properties = $instance->apply()->properties();

        $this->assertIsArray($properties);

        $this->assertSame($this->expected_properties, $properties);

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertSame($properties, $jsonSerialize);
    }

    public function test_folder_is_empty_by_default(): void
    {
        $instance = new Policy;

        $this->assertInstanceOf(Policy::class, $instance);

        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());
    }

    public function test_test_with_file_and_skeleton(): void
    {
        $file = $this->getResourceFile('test-policy');
        $content = file_exists($file) ? file_get_contents($file) : null;
        $options = $content ? json_decode($content, true) : [];

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new Policy(
            is_array($options) ? $options : [],
            true
        );

        $instance->apply();

        $this->assertEmpty($instance->folder());
        $this->assertTrue($instance->skeleton());

        $this->assertSame('Playground', $instance->organization());
        $this->assertSame('playground-cms-api', $instance->package());
        $this->assertSame('Cms', $instance->module());
        $this->assertSame('cms', $instance->module_slug());
        $this->assertSame('', $instance->fqdn());
        $this->assertSame('Playground\\Cms\\Api', $instance->namespace());
        $this->assertSame('Snippet', $instance->model());
        $this->assertSame('SnippetPolicy', $instance->name());
        $this->assertSame('SnippetPolicy', $instance->class());
        $this->assertSame('playground-resource', $instance->type());
        $this->assertSame('Playground\\Cms\\Models\\Snippet', $instance->model_fqdn());
        $this->assertSame([
            'publisher',
            'manager',
            'admin',
            'root',
        ], $instance->rolesForAction());
        $this->assertSame([
            'user',
            'staff',
            'publisher',
            'manager',
            'admin',
            'root',
        ], $instance->rolesToView());
    }
}
