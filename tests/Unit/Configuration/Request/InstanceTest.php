<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Make\Controller\Configuration\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Make\Controller\TestCase;
use Playground\Make\Controller\Configuration\Request;

/**
 * \Tests\Unit\Playground\Make\Controller\Configuration\Request\InstanceTest
 */
#[CoversClass(Request::class)]
class InstanceTest extends TestCase
{
    public function test_instance(): void
    {
        $instance = new Request;

        $this->assertInstanceOf(Request::class, $instance);
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
        // properties
        'abstract' => false,
        'pagination' => false,
        'playground' => false,
        'store' => false,
        'slug' => false,
        'type' => '',
        'extends' => '',
        'extends_use' => '',
        'models' => [],
    ];

    public function test_instance_apply_without_options(): void
    {
        $instance = new Request;

        $properties = $instance->apply()->properties();

        $this->assertIsArray($properties);

        $this->assertSame($this->expected_properties, $properties);

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertSame($properties, $jsonSerialize);
    }

    public function test_folder_is_empty_by_default(): void
    {
        $instance = new Request;

        $this->assertInstanceOf(Request::class, $instance);

        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());
    }

    public function test_test_with_file_and_skeleton(): void
    {
        $file = $this->getResourceFile('test-request');
        $content = file_exists($file) ? file_get_contents($file) : null;
        $options = $content ? json_decode($content, true) : [];

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new Request(
            is_array($options) ? $options : [],
            true
        );

        $instance->apply();

        $this->assertEmpty($instance->folder());
        $this->assertTrue($instance->skeleton());

        $this->assertSame('Acme', $instance->organization());
        $this->assertSame('acme-demo', $instance->package());
        $this->assertSame('abstract', $instance->type());
        $this->assertSame('FormRequest', $instance->extends());
        $this->assertSame('Illuminate\\Foundation\\Http\\FormRequest', $instance->extends_use());
        $this->assertSame('Acme\\Demo', $instance->namespace());
        $this->assertTrue($instance->abstract());
        $this->assertSame('FormRequest', $instance->name());
        $this->assertSame('FormRequest', $instance->class());
    }
}
