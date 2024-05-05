<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Configuration;

use Playground\Make\Configuration\PrimaryConfiguration;

/**
 * \Playground\Make\Controller\Configuration\Request
 */
class Request extends PrimaryConfiguration
{
    protected bool $abstract = false;

    protected bool $pagination = false;

    protected bool $store = false;

    protected bool $slug = false;

    /**
     * @var array<string, string>
     */
    protected array $models = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
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
        'extends' => 'FormRequest',
        'extends_use' => 'Illuminate/Foundation/Http/FormRequest',
        'models' => [],
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (array_key_exists('abstract', $options)) {
            $this->abstract = ! empty($options['abstract']);
        }

        if (array_key_exists('pagination', $options)) {
            $this->pagination = ! empty($options['pagination']);
        }

        if (array_key_exists('store', $options)) {
            $this->store = ! empty($options['store']);
        }

        if (array_key_exists('slug', $options)) {
            $this->slug = ! empty($options['slug']);
        }

        return $this;
    }

    public function abstract(): bool
    {
        return $this->abstract;
    }

    public function pagination(): bool
    {
        return $this->pagination;
    }

    public function store(): bool
    {
        return $this->store;
    }

    public function slug(): bool
    {
        return $this->slug;
    }
}
