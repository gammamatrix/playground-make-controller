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

    /**
     * @param array<string, mixed> $options
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
