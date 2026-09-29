<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Make\Controller\Configuration;

use Playground\Make\Configuration\PrimaryConfiguration;

/**
 * \Playground\Make\Controller\Configuration\Resource
 */
class Resource extends PrimaryConfiguration
{
    protected bool $collection = false;

    protected string $model_slug = '';

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'class' => '',
        'config' => '',
        'fqdn' => '',
        'module' => '',
        'module_label' => '',
        'module_labels' => '',
        'module_slug' => '',
        'module_slugs' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',

        'model_route' => '',
        'model_route_param' => '',
        'module_route' => '',

        'model_camel' => '',
        'model_camels' => '',
        'model_label' => '',
        'model_labels' => '',
        'model_lower' => '',
        'model_lowers' => '',
        'model_kebab' => '',
        'model_kebabs' => '',
        'model_slug' => '',
        'model_slugs' => '',
        'model_snake' => '',
        'model_snakes' => '',
        'model_studly' => '',
        'model_studlies' => '',
        'model_variable' => '',
        'model_variables' => '',

        // properties
        'collection' => false,
        'model' => '',
        'model_fqdn' => '',
        'type' => '',
        'models' => [],
    ];

    /**
     * @param  array<string, mixed>  $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (array_key_exists('collection', $options)) {
            $this->collection = ! empty($options['collection']);
        }

        if (! empty($options['model_slug'])
            && is_string($options['model_slug'])
        ) {
            $this->model_slug = $options['model_slug'];
        }

        return $this;
    }

    public function model_slug(): string
    {
        return $this->model_slug;
    }

    public function collection(): bool
    {
        return $this->collection;
    }
}
