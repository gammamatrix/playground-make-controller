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

    protected string $model_camel = '';

    protected string $model_camels = '';

    protected string $model_kebab = '';

    protected string $model_kebabs = '';

    protected string $model_label = '';

    protected string $model_labels = '';

    protected string $model_label_plural = '';

    protected string $model_lower = '';

    protected string $model_lowers = '';

    protected string $model_route = '';

    protected string $model_slug = '';

    protected string $model_slugs = '';

    protected string $model_slug_plural = '';

    protected string $model_snake = '';

    protected string $model_snakes = '';

    protected string $model_studly = '';

    protected string $model_studlies = '';

    protected string $model_variable = '';

    protected string $model_variables = '';

    protected string $model_variable_plural = '';

    protected string $module_label = '';

    protected string $module_labels = '';

    protected string $module_label_plural = '';

    protected string $module_route = '';

    protected string $module_slug = '';

    protected string $module_slugs = '';

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
        'model_camel' => '',
        'model_camels' => '',
        'model_kebab' => '',
        'model_kebabs' => '',
        'model_lower' => '',
        'model_lowers' => '',
        'model_label' => '',
        'model_labels' => '',
        'model_label_plural' => '',
        'model_route' => '',
        'model_slug' => '',
        'model_slugs' => '',
        'model_slug_plural' => '',
        'model_snake' => '',
        'model_snakes' => '',
        'model_studly' => '',
        'model_studlies' => '',
        'model_variable' => '',
        'model_variable_plural' => '',
        'module_label' => '',
        'module_labels' => '',
        'module_label_plural' => '',
        'module_route' => '',
        'module_slug' => '',
        'module_slugs' => '',
        'privilege' => '',
        'table' => '',
        // 'view' => '',

        // 'model_attribute' => 'label',
        // 'model_label' => 'Backlog', // Task List
        // 'model_label_plural' => 'Backlogs', // Task Lists
        // 'model_route' => 'playground.matrix.resource.backlogs',
        // 'model_slug' => 'backlog', // task-list
        // 'model_slug_plural' => 'backlogs', // task-lists
        // 'model_variable' => 'backlog', // taskList
        // 'model_variable_plural' => 'backlogs', // taskLists
        // 'module_label' => 'Matrix',
        // 'module_label_plural' => 'Matrices',
        // 'module_route' => 'playground.matrix.resource',
        // 'module_slug' => 'matrix',
        // 'privilege' => 'playground-matrix-resource:backlog',
        // 'table' => 'matrix_backlogs',
        // 'view' => 'playground-matrix-resource::backlog',
    ];

    /**
     * @param  array<string, mixed>  $options
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

        if (! empty($options['model_camel'])
            && is_string($options['model_camel'])
        ) {
            $this->model_camel = $options['model_camel'];
        }

        if (! empty($options['model_camels'])
            && is_string($options['model_camels'])
        ) {
            $this->model_camels = $options['model_camels'];
        }

        if (! empty($options['model_kebab'])
            && is_string($options['model_kebab'])
        ) {
            $this->model_kebab = $options['model_kebab'];
        }

        if (! empty($options['model_kebabs'])
            && is_string($options['model_kebabs'])
        ) {
            $this->model_kebabs = $options['model_kebabs'];
        }

        if (! empty($options['model_label_plural'])
            && is_string($options['model_label_plural'])
        ) {
            $this->model_label_plural = $options['model_label_plural'];
        }

        if (! empty($options['model_label'])
            && is_string($options['model_label'])
        ) {
            $this->model_label = $options['model_label'];
        }

        if (! empty($options['model_labels'])
            && is_string($options['model_labels'])
        ) {
            $this->model_labels = $options['model_labels'];
        }

        if (! empty($options['model_lower'])
            && is_string($options['model_lower'])
        ) {
            $this->model_lower = $options['model_lower'];
        }

        if (! empty($options['model_lowers'])
            && is_string($options['model_lowers'])
        ) {
            $this->model_lowers = $options['model_lowers'];
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

        if (! empty($options['model_slugs'])
            && is_string($options['model_slugs'])
        ) {
            $this->model_slugs = $options['model_slugs'];
        }

        if (! empty($options['model_slug_plural'])
            && is_string($options['model_slug_plural'])
        ) {
            $this->model_slug_plural = $options['model_slug_plural'];
        }

        if (! empty($options['model_snake'])
            && is_string($options['model_snake'])
        ) {
            $this->model_snake = $options['model_snake'];
        }

        if (! empty($options['model_snakes'])
            && is_string($options['model_snakes'])
        ) {
            $this->model_snakes = $options['model_snakes'];
        }

        if (! empty($options['model_studly'])
            && is_string($options['model_studly'])
        ) {
            $this->model_studly = $options['model_studly'];
        }

        if (! empty($options['model_studlies'])
            && is_string($options['model_studlies'])
        ) {
            $this->model_studlies = $options['model_studlies'];
        }

        if (! empty($options['model_variable'])
            && is_string($options['model_variable'])
        ) {
            $this->model_variable = $options['model_variable'];
        }

        if (! empty($options['model_variables'])
            && is_string($options['model_variables'])
        ) {
            $this->model_variables = $options['model_variables'];
        }

        if (! empty($options['model_variable_plural'])
            && is_string($options['model_variable_plural'])
        ) {
            $this->model_variable_plural = $options['model_variable_plural'];
        }

        if (! empty($options['module_label'])
            && is_string($options['module_label'])
        ) {
            $this->module_label = $options['module_label'];
        }

        if (! empty($options['module_labels'])
            && is_string($options['module_labels'])
        ) {
            $this->module_labels = $options['module_labels'];
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

        if (! empty($options['module_slugs'])
            && is_string($options['module_slugs'])
        ) {
            $this->module_slugs = $options['module_slugs'];
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

    public function model_camel(): string
    {
        return $this->model_camel;
    }

    public function model_camels(): string
    {
        return $this->model_camels;
    }

    public function model_kebab(): string
    {
        return $this->model_kebab;
    }

    public function model_kebabs(): string
    {
        return $this->model_kebabs;
    }

    public function model_lower(): string
    {
        return $this->model_lower;
    }

    public function model_lowers(): string
    {
        return $this->model_lowers;
    }

    public function model_label(): string
    {
        return $this->model_label;
    }

    public function model_label_plural(): string
    {
        return $this->model_label_plural;
    }

    public function model_labels(): string
    {
        return $this->model_labels;
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

    public function model_slugs(): string
    {
        return $this->model_slugs;
    }

    public function model_snake(): string
    {
        return $this->model_snake;
    }

    public function model_snakes(): string
    {
        return $this->model_snakes;
    }

    public function model_studly(): string
    {
        return $this->model_studly;
    }

    public function model_studlies(): string
    {
        return $this->model_studlies;
    }

    public function model_variable(): string
    {
        return $this->model_variable;
    }

    public function model_variable_plural(): string
    {
        return $this->model_variable_plural;
    }

    public function model_variables(): string
    {
        return $this->model_variables;
    }

    public function module_label(): string
    {
        return $this->module_label;
    }

    public function module_label_plural(): string
    {
        return $this->module_label_plural;
    }

    public function module_labels(): string
    {
        return $this->module_labels;
    }

    public function module_route(): string
    {
        return $this->module_route;
    }

    public function module_slug(): string
    {
        return $this->module_slug;
    }

    public function module_slugs(): string
    {
        return $this->module_slugs;
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
