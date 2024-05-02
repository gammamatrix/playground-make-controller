<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Make\Controller\Configuration;

// use Illuminate\Support\Facades\Log;
use Playground\Make\Configuration\PrimaryConfiguration;

/**
 * \Playground\Make\Controller\Configuration\Controller
 */
class Controller extends PrimaryConfiguration
{
    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'class' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'model' => '',
        'organization' => '',
        'package' => '',
        'type' => '',
        'playground' => false,
        'models' => [],
        'policies' => [],
        'requests' => [],
        'resources' => [],
        'templates' => [],
        'transformers' => [],
        'extends' => '',
        'extends_use' => '',
        // 'extends' => 'Controller',
        // 'extends_use' => 'App\Http\Controllers\Controller',
        'slug' => '',
        'slug_plural' => '',
        'model_route' => '',
        'module_route' => '',
        'privilege' => '',
        'route' => '',
        'view' => '',
        'uses' => [],
    ];

    /**
     * @var array<string, string>
     */
    protected array $models = [];

    /**
     * @var array<int, string>
     */
    protected array $policies = [];

    /**
     * @var array<int, string>
     */
    protected array $requests = [];

    /**
     * @var array<int, string>
     */
    protected array $resources = [];

    /**
     * @var array<int, string>
     */
    protected array $templates = [];

    /**
     * @var array<int, string>
     */
    protected array $transformers = [];

    protected string $extends = '';

    protected string $extends_use = '';

    protected string $slug = '';

    protected string $slug_plural = '';

    protected string $model_route = '';

    protected string $module_route = '';

    protected bool $playground = false;

    protected string $privilege = '';

    protected string $route = '';

    protected string $view = '';

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        // if (array_key_exists('withPolicies', $options)) {
        //     $this->withPolicies = ! empty($options['withPolicies']);
        // }

        if (array_key_exists('playground', $options)) {
            $this->playground = ! empty($options['playground']);
        }

        if (! empty($options['module_route'])
            && is_string($options['module_route'])
        ) {
            $this->module_route = $options['module_route'];
        }

        if (! empty($options['model_route'])
            && is_string($options['model_route'])
        ) {
            $this->model_route = $options['model_route'];
        }

        if (! empty($options['route'])
            && is_string($options['route'])
        ) {
            $this->route = $options['route'];
        }

        if (! empty($options['privilege'])
            && is_string($options['privilege'])
        ) {
            $this->privilege = $options['privilege'];
        }

        if (! empty($options['view'])
            && is_string($options['view'])
        ) {
            $this->view = $options['view'];
        }

        $this->addModels($options);

        return $this;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function addModels(array $options): self
    {
        if (! empty($options['models'])
            && is_array($options['models'])
        ) {
            foreach ($options['models'] as $key => $file) {
                $this->addMappedClassTo('models', $key, $file);
            }
        }

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function models(): array
    {
        return $this->models;
    }

    /**
     * @return array<int, string>
     */
    public function policies(): array
    {
        return $this->policies;
    }

    /**
     * @return array<int, string>
     */
    public function requests(): array
    {
        return $this->requests;
    }

    /**
     * @return array<int, string>
     */
    public function resources(): array
    {
        return $this->resources;
    }

    /**
     * @return array<int, string>
     */
    public function templates(): array
    {
        return $this->templates;
    }

    /**
     * @return array<int, string>
     */
    public function transformers(): array
    {
        return $this->transformers;
    }

    public function extends(): string
    {
        return $this->extends;
    }

    public function extends_use(): string
    {
        return $this->extends_use;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function slug_plural(): string
    {
        return $this->slug_plural;
    }

    public function model_route(): string
    {
        return $this->model_route;
    }

    public function module_route(): string
    {
        return $this->module_route;
    }

    public function playground(): bool
    {
        return $this->playground;
    }

    public function route(): string
    {
        return $this->route;
    }

    public function privilege(): string
    {
        return $this->privilege;
    }

    public function view(): string
    {
        return $this->view;
    }
}
