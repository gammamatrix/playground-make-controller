<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Configuration\Controller;

use Playground\Make\Configuration;

/**
 * \Playground\Make\Controller\Configuration\Controller\PackageInfo
 */
class PackageInfo extends Configuration\Configuration implements Configuration\Contracts\WithSkeleton
{
    use Configuration\Concerns\WithSkeleton;

    protected bool $model_attribute_required = true;

    protected string $model_attribute = '';

    protected string $primary = '';

    protected string $model_label = '';

    protected string $model_label_plural = '';

    protected string $model_route = '';

    protected string $model_slug = '';

    protected string $model_slug_plural = '';

    protected string $module_label = '';

    protected string $module_label_plural = '';

    protected string $module_route = '';

    protected string $module_slug = '';

    protected string $privilege = '';

    protected string $table = '';

    protected string $view = '';

    protected string $type = '';

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'model_attribute_required' => true,
        'model_attribute' => '',
        'model_label' => '',
        'model_label_plural' => '',
        'model_route' => '',
        'model_slug' => '',
        'model_slug_plural' => '',
        'module_label' => '',
        'module_label_plural' => '',
        'module_route' => '',
        'module_slug' => '',
        'privilege' => '',
        'table' => '',
        // 'view' => '',

        // 'model_attribute' => 'label',
        // 'model_label' => 'Backlog',
        // 'model_label_plural' => 'Backlogs',
        // 'model_route' => 'playground.matrix.resource.backlogs',
        // 'model_slug' => 'backlog',
        // 'model_slug_plural' => 'backlogs',
        // 'module_label' => 'Matrix',
        // 'module_label_plural' => 'Matrices',
        // 'module_route' => 'playground.matrix.resource',
        // 'module_slug' => 'matrix',
        // 'privilege' => 'playground-matrix-resource:backlog',
        // 'table' => 'matrix_backlogs',
        // 'view' => 'playground-matrix-resource::backlog',
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        if (array_key_exists('model_attribute_required', $options)) {
            $this->model_attribute_required = ! empty($options['model_attribute_required']);
        }

        if (! empty($options['model_attribute'])
            && is_string($options['model_attribute'])
        ) {
            $this->model_attribute = $options['model_attribute'];
        }

        if (! empty($options['model_label'])
            && is_string($options['model_label'])
        ) {
            $this->model_label = $options['model_label'];
        }

        if (! empty($options['model_label_plural'])
            && is_string($options['model_label_plural'])
        ) {
            $this->model_label_plural = $options['model_label_plural'];
        }

        if (! empty($options['model_route'])
            && is_string($options['model_route'])
        ) {
            $this->model_route = $options['model_route'];
        }

        if (! empty($options['model_slug'])
            && is_string($options['model_slug'])
        ) {
            $this->model_slug = $options['model_slug'];
        }

        if (! empty($options['model_slug_plural'])
            && is_string($options['model_slug_plural'])
        ) {
            $this->model_slug_plural = $options['model_slug_plural'];
        }

        if (! empty($options['module_label'])
            && is_string($options['module_label'])
        ) {
            $this->module_label = $options['module_label'];
        }

        if (! empty($options['module_label_plural'])
            && is_string($options['module_label_plural'])
        ) {
            $this->module_label_plural = $options['module_label_plural'];
        }

        if (! empty($options['module_route'])
            && is_string($options['module_route'])
        ) {
            $this->module_route = $options['module_route'];
        }

        if (! empty($options['module_slug'])
            && is_string($options['module_slug'])
        ) {
            $this->module_slug = $options['module_slug'];
        }

        if (! empty($options['privilege'])
            && is_string($options['privilege'])
        ) {
            $this->privilege = $options['privilege'];
        }

        if (! empty($options['table'])
            && is_string($options['table'])
        ) {
            $this->table = $options['table'];
        }

        if (! empty($options['view'])
            && is_string($options['view'])
        ) {
            $this->view = $options['view'];
            $this->properties['view'] = $this->view;
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$this' => $this,
        // ]);

        return $this;
    }

    public function model_attribute_required(): bool
    {
        return $this->model_attribute_required;
    }

    public function model_attribute(): string
    {
        return $this->model_attribute;
    }

    public function model_label(): string
    {
        return $this->model_label;
    }

    public function model_label_plural(): string
    {
        return $this->model_label_plural;
    }

    public function model_route(): string
    {
        return $this->model_route;
    }

    public function model_slug(): string
    {
        return $this->model_slug;
    }

    public function model_slug_plural(): string
    {
        return $this->model_slug_plural;
    }

    public function module_label(): string
    {
        return $this->module_label;
    }

    public function module_label_plural(): string
    {
        return $this->module_label_plural;
    }

    public function module_route(): string
    {
        return $this->module_route;
    }

    public function module_slug(): string
    {
        return $this->module_slug;
    }

    public function privilege(): string
    {
        return $this->privilege;
    }

    public function table(): string
    {
        return $this->table;
    }

    public function view(): string
    {
        return $this->view;
    }
}
