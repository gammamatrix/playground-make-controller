<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Configuration;

use Playground\Make\Configuration\PrimaryConfiguration;

/**
 * \Playground\Make\Controller\Configuration\Controller
 */
class Controller extends PrimaryConfiguration
{
    use Concerns\Info;

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
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
        // 'extends' => 'Controller',
        // 'extends_use' => 'App\Http\Controllers\Controller',
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

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        $properties = parent::toArray();

        $properties['packageInfo'] = $this->packageInfo()?->toArray();

        return $properties;
    }

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

    protected bool $revision = false;

    protected string $privilege = '';

    protected string $route = '';

    protected string $view = '';

    protected bool $isAbstract = false;

    protected bool $withBlades = false;

    protected bool $withPolicies = false;

    protected bool $withRequests = false;

    protected bool $withRoutes = false;

    protected bool $withSwagger = false;

    protected bool $withTests = false;

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (array_key_exists('isAbstract', $options)) {
            $this->isAbstract = ! empty($options['isAbstract']);
        }

        if (array_key_exists('withBlades', $options)) {
            $this->withBlades = ! empty($options['withBlades']);
        }

        if (array_key_exists('withPolicies', $options)) {
            $this->withPolicies = ! empty($options['withPolicies']);
        }

        if (array_key_exists('withRequests', $options)) {
            $this->withRequests = ! empty($options['withRequests']);
        }

        if (array_key_exists('withRoutes', $options)) {
            $this->withRoutes = ! empty($options['withRoutes']);
        }

        if (array_key_exists('withSwagger', $options)) {
            $this->withSwagger = ! empty($options['withSwagger']);
        }

        if (array_key_exists('withTests', $options)) {
            $this->withTests = ! empty($options['withTests']);
        }

        // if (array_key_exists('playground', $options)) {
        //     $this->playground = ! empty($options['playground']);
        // }

        if (array_key_exists('revision', $options)) {
            $this->revision = ! empty($options['revision']);
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

        return $this;
    }

    // /**
    //  * @return array<string, string>
    //  */
    // public function models(): array
    // {
    //     return $this->models;
    // }

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

    // public function extends(): string
    // {
    //     return $this->extends;
    // }

    // public function extends_use(): string
    // {
    //     return $this->extends_use;
    // }

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

    // public function playground(): bool
    // {
    //     return $this->playground;
    // }

    public function revision(): bool
    {
        return $this->revision;
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

    public function isAbstract(): bool
    {
        return $this->withBlades;
    }

    public function withBlades(): bool
    {
        return $this->withBlades;
    }

    public function withPolicies(): bool
    {
        return $this->withPolicies;
    }

    public function withRequests(): bool
    {
        return $this->withRequests;
    }

    public function withRoutes(): bool
    {
        return $this->withRoutes;
    }

    public function withSwagger(): bool
    {
        return $this->withSwagger;
    }

    public function withTests(): bool
    {
        return $this->withTests;
    }
}
