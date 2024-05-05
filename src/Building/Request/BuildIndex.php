<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Building\Request;

use Illuminate\Support\Str;
use Playground\Make\Configuration\Model;
use Playground\Make\Configuration\Model\Filters;

/**
 * \Playground\Make\Controller\Building\Request\BuildIndex
 */
trait BuildIndex
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $skeleton_flags = [
        'active' => [
            'type' => 'boolean',
            'default' => true,
            'index' => true,
            'icon' => 'fa-solid fa-person-running',
        ],
        'canceled' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-ban text-warning',
        ],
        'closed' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-xmark',
        ],
        'completed' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-check',
        ],
        'cron' => [
            'type' => 'boolean',
            'default' => false,
            'index' => true,
            'icon' => 'fa-regular fa-clock',
        ],
        'duplicate' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-clone',
        ],
        'fixed' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-wrench',
        ],
        'flagged' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-flag',
        ],
        'internal' => [
            'type' => 'boolean',
            'readOnly' => false,
            'default' => false,
            'icon' => 'fa-solid fa-server',
        ],
        'locked' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-lock text-warning',
        ],
        'pending' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-circle-pause text-warning',
        ],
        'planned' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-circle-pause text-success',
        ],
        'problem' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-triangle-exclamation text-danger',
        ],
        'published' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-book',
        ],
        'released' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-dove',
        ],
        'retired' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-chair text-success',
        ],
        'resolved' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-check-double text-success',
        ],
        'suspended' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-hand text-danger',
        ],
        'unknown' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-question text-warning',
        ],
    ];

    protected function buildClass_index(string $name): void
    {
        $ids = false;
        $flags = false;
        $model = false;
        $dates = false;

        $slug = false;

        $traits = [];

        if (in_array($this->c->type(), [
            'index',
        ])) {
            if ($this->option('skeleton')) {

                // $this->c->setOptions([
                //     'extends_use' => sprintf(
                //         '%1$s\Http\Requests\AbstractIndexRequest',
                //         $this->c->namespace()
                //     ),
                // ]);
                // $this->c->setOptions([
                //     'extends' => 'AbstractIndexRequest',
                // ]);

                // $this->c->setOptions([
                //     'extends' => 'BaseIndexRequest',
                //     'extends_use' => 'Playground\Http\Requests\IndexRequest as BaseIndexRequest',
                // ]);

                // $this->buildClass_uses($this->c->extends_use());

                // $this->searches['extends_use'] = $this->parseClassInput($this->c->extends_use());
                // $this->searches['extends'] = $this->parseClassInput($this->c->extends());

                $filters = $this->model?->filters();

                if ($filters) {
                    $this->buildClass_index_dates($filters);
                    $this->buildClass_index_flags($filters);
                    $this->buildClass_index_ids($filters);
                    $this->buildClass_index_columns($filters);
                }

                $this->buildClass_index_sortable();
            }
        }

        // Types: index

        if (in_array($this->c->type(), [
            'abstract-index',
        ])) {
            $dates = true;
            $flags = true;
            $model = true;
            $ids = true;

            // if ($this->option('with-pagination')) {
            //     $this->c->setOptions([
            //         'pagination' => true,
            //     ]);
            //     $this->createPaginationTraits();
            // }

        }

    }

    // protected function createPaginationTraits(): void
    // {
    //     $format_sql = config('playground-stub.format.sql');
    //     if (is_string($format_sql) && $format_sql) {
    //         $this->searches['format_sql'] = $format_sql;
    //     }

    //     $traits = [
    //         'PaginationDatesTrait' => 'request/trait.pagination.dates.stub',
    //         'PaginationFlagsTrait' => 'request/trait.pagination.flags.stub',
    //         'PaginationIdsTrait' => 'request/trait.pagination.ids.stub',
    //         'PaginationModelTrait' => 'request/trait.pagination.model.stub',
    //         'PaginationSortableTrait' => 'request/trait.pagination.sortable.stub',
    //     ];

    //     foreach ($traits as $class => $template) {
    //         // $this->createPaginationTrait($class, $template);
    //         $this->createTrait(
    //             $this->folder(),
    //             $class,
    //             $template
    //         );
    //         $this->buildClass_uses_add('', $class);
    //         // $this->configuration['uses'][$class] = '';
    //         // $this->configuration['uses'][$class] = $this->getDefaultNamespace(
    //         //     $this->parseClassInput($this->configuration['namespace'])
    //         // );
    //     }
    // }

    protected function createPaginationTrait(string $class, string $template): void
    {
        $path = $this->resolveStubPath($template);

        $stub = $this->files->get($path);

        $this->search_and_replace($stub);

        $file = sprintf('%1$s.php', $class);

        $destination = sprintf(
            '%1$s/%2$s',
            $this->folder(),
            $file
        );

        $full_path = $this->laravel->storagePath().$destination;
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->folder()' => $this->folder(),
        //     '$destination' => $destination,
        //     '$full_path' => $full_path,
        // ]);

        $this->files->put($full_path, $stub);

        $this->components->info(sprintf('%s [%s] created successfully.', $file, $full_path));
    }

    protected function buildClass_index_dates(Filters $filters): void
    {
        $dates = $filters->dates();
        if (! $dates) {
            return;
        }

        $code = PHP_EOL;

        if (! empty($this->searches['properties'])) {
            $this->searches['properties'] .= PHP_EOL;
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$filters' => $filters,
        //     '$filters' => $filters,
        // ]);
        foreach ($dates as $i => $filter) {

            $column = $filter->column();
            if (! $column) {
                \Log::debug(__METHOD__, [
                    'ISSUE' => 'Missing column for date',
                    '$i' => $i,
                    '$filter' => $filter,
                ]);

                continue;
            }

            $code .= str_repeat(' ', 8);

            $label = $filter->label();
            if (! $label) {
                $label = Str::of($column)->replace('_', ' ')->title();
            }

            // $icon = $filter->icon();
            // if (! $icon
            //     && ! empty($this->skeleton_flags[$column])
            //     && ! empty($this->skeleton_flags[$column]['icon'])
            //     && is_string($this->skeleton_flags[$column]['icon'])
            // ) {
            //     $icon = $this->skeleton_flags[$column]['icon'];
            // }

            $code .= sprintf(
                // '\'%1$s\' => [\'column\' => \'%1$s\', \'label\' => \'%2$s\', \'nullable\' => %3$s, \'icon\' => \'%4$s\'],',
                '\'%1$s\' => [\'column\' => \'%1$s\', \'label\' => \'%2$s\', \'nullable\' => %3$s],',
                $column,
                $label,
                $filter->nullable() ? 'true' : 'false'
                // $icon
            );

            $code .= PHP_EOL;
        }

        $code .= str_repeat(' ', 4);

        $this->searches['properties'] .= <<<PHP_CODE
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array \$paginationDates = [$code];
PHP_CODE;

        // $this->searches['properties'] .= sprintf(
        //     '    /**
        //     * @var array<string, array<string, mixed>>
        //     */
        //     protected array $paginationDates = [%1$s];',
        //     $code
        // );

        $this->searches['properties'] .= PHP_EOL;

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->toArray()' => $this->c->toArray(),
        //     '$this->searches' => $this->searches,
        //     // '$this->model' => $this->model,
        // ]);
    }

    protected function buildClass_index_flags(Filters $filters): void
    {
        $flags = $filters->flags();
        if (! $flags) {
            return;
        }

        $code = PHP_EOL;

        foreach ($flags as $i => $filter) {

            $column = $filter->column();
            if (! $column) {
                \Log::debug(__METHOD__, [
                    'ISSUE' => 'Missing column for flag',
                    '$i' => $i,
                    '$filter' => $filter,
                ]);

                continue;
            }

            $code .= str_repeat(' ', 8);

            $label = $filter->label();
            if (! $label) {
                $label = Str::of($column)->replace('_', ' ')->title();
            }

            $icon = $filter->icon();
            if (! $icon
                && ! empty($this->skeleton_flags[$column])
                && ! empty($this->skeleton_flags[$column]['icon'])
                && is_string($this->skeleton_flags[$column]['icon'])
            ) {
                $icon = $this->skeleton_flags[$column]['icon'];
            }

            $code .= sprintf(
                '\'%1$s\' => [\'column\' => \'%1$s\', \'label\' => \'%2$s\', \'icon\' => \'%3$s\'],',
                $column,
                $label,
                $icon,
            );

            $code .= PHP_EOL;
        }

        $code .= str_repeat(' ', 4);

        if (! empty($this->searches['properties'])) {
            $this->searches['properties'] .= PHP_EOL;
        }

        // $this->searches['properties'] .= sprintf(
        //     '    protected array $paginationFlags = [%1$s];',
        //     $code
        // );
        $this->searches['properties'] .= <<<PHP_CODE
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array \$paginationFlags = [$code];
PHP_CODE;

        $this->searches['properties'] .= PHP_EOL;

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->toArray()' => $this->c->toArray(),
        //     '$this->searches' => $this->searches,
        //     '$this->skeleton_flags' => $this->skeleton_flags,
        // ]);
    }

    protected function buildClass_index_ids(Filters $filters): void
    {
        $ids = $filters->ids();
        if (! $ids) {
            return;
        }

        $code = PHP_EOL;

        if (! empty($this->searches['properties'])) {
            $this->searches['properties'] .= PHP_EOL;
        }

        foreach ($ids as $i => $filter) {

            $column = $filter->column();
            if (! $column) {
                \Log::debug(__METHOD__, [
                    'ISSUE' => 'Missing column for id',
                    '$i' => $i,
                    '$filter' => $filter,
                ]);

                continue;
            }

            $code .= str_repeat(' ', 8);

            $label = $filter->label();
            if (! $label) {
                $label = Str::of($column)->replace('_', ' ')->title();
            }

            $code .= sprintf(
                '\'%1$s\' => [\'column\' => \'%1$s\', \'label\' => \'%2$s\', \'type\' => \'%3$s\', \'nullable\' => %4$s],',
                $column,
                $label,
                $filter->type() ? $filter->type() : 'string',
                $filter->nullable() ? 'true' : 'false'
            );

            $code .= PHP_EOL;
        }

        $code .= str_repeat(' ', 4);

        $this->searches['properties'] .= <<<PHP_CODE
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array \$paginationIds = [$code];
PHP_CODE;
        // $this->searches['properties'] .= sprintf(
        //     '    protected array $paginationIds = [%1$s];',
        //     $code
        // );

        $this->searches['properties'] .= PHP_EOL;

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        //     // '$this->model' => $this->model,
        // ]);
    }

    protected function buildClass_index_columns(Filters $filters): void
    {
        $columns = $filters->columns();
        if (! $columns) {
            return;
        }

        $code = PHP_EOL;

        if (! empty($this->searches['properties'])) {
            $this->searches['properties'] .= PHP_EOL;
        }

        foreach ($columns as $i => $filter) {

            $column = $filter->column();
            if (! $column) {
                \Log::debug(__METHOD__, [
                    'ISSUE' => 'Missing column',
                    '$i' => $i,
                    '$filter' => $filter,
                ]);

                continue;
            }

            $code .= str_repeat(' ', 8);

            $label = $filter->label();
            if (! $label) {
                $label = Str::of($column)->replace('_', ' ')->title();
            }

            $code .= sprintf(
                '\'%1$s\' => [\'column\' => \'%1$s\', \'label\' => \'%2$s\', \'type\' => \'%3$s\', \'nullable\' => %4$s],',
                $column,
                $label,
                $filter->type() ? $filter->type() : 'string',
                $filter->nullable() ? 'true' : 'false'
            );

            $code .= PHP_EOL;
        }

        $code .= str_repeat(' ', 4);

        $this->searches['properties'] .= <<<PHP_CODE
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array \$paginationColumns = [$code];
PHP_CODE;
        // $this->searches['properties'] .= sprintf(
        //     '    protected array $paginationColumns = [%1$s];',
        //     $code
        // );

        $this->searches['properties'] .= PHP_EOL;

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        //     // '$this->model' => $this->model,
        // ]);
    }

    protected function buildClass_index_sortable(): void
    {
        $sortable = $this->model?->sortable();
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$this->c' => $this->c,
        //     '$sortable' => $sortable,
        //     // '$this->model' => $this->model,
        // ]);
        if (! $sortable) {
            return;
        }

        $code = PHP_EOL;

        if (! empty($this->searches['properties'])) {
            $this->searches['properties'] .= PHP_EOL;
        }

        foreach ($sortable as $i => $filter) {

            $column = $filter->column();
            if (! $column) {
                \Log::debug(__METHOD__, [
                    'ISSUE' => 'Missing column for sortable',
                    '$i' => $i,
                    '$filter' => $filter,
                ]);

                continue;
            }

            $code .= str_repeat(' ', 8);

            $label = $filter->label();
            if (! $label) {
                $label = Str::of($column)->replace('_', ' ')->title();
            }

            $type = $filter->type() ? $filter->type() : 'string';

            if (in_array($type, [
                'tinyText',
                'mediumText',
                'largeText',
                'uuid',
            ])) {
                $type = 'string';
            } elseif (in_array($type, [
                'decimal',
                'float',
                'double',
            ])) {
                $type = 'float';
            } elseif (in_array($type, [
                'tinyInteger',
                'smallInteger',
                'mediumInteger',
                'bigInteger',
            ])) {
                $type = 'integer';
            }

            $code .= sprintf(
                '\'%1$s\' => [\'column\' => \'%1$s\', \'label\' => \'%2$s\', \'type\' => \'%3$s\'],',
                $column,
                $label,
                $type,
            );

            $code .= PHP_EOL;
        }

        $code .= str_repeat(' ', 4);

        $this->searches['properties'] .= <<<PHP_CODE
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array \$sortable = [$code];
PHP_CODE;
        // $this->searches['properties'] .= sprintf(
        //     '    protected array $sortable = [%1$s];',
        //     $code
        // );

        // $this->searches['properties'] .= PHP_EOL;

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        //     // '$this->model' => $this->model,
        // ]);
    }
}
