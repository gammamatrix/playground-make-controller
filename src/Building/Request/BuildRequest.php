<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Building\Request;

use Illuminate\Support\Str;
use Playground\Make\Configuration\Model;

/**
 * \Playground\Make\Controller\Building\Request\BuildRequest
 */
trait BuildRequest
{
    // protected function createTrait(
    //     string $folder,
    //     string $class,
    //     string $template
    // ): void {
    //     $path = $this->resolveStubPath($template);

    //     $stub = $this->files->get($path);

    //     $this->search_and_replace($stub);

    //     $file = sprintf('%1$s.php', $class);

    //     $destination = sprintf(
    //         '%1$s/%2$s',
    //         $folder,
    //         $file
    //     );

    //     $full_path = $this->laravel->storagePath().$destination;
    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     '$this->folder()' => $this->folder(),
    //     //     '$destination' => $destination,
    //     //     '$full_path' => $full_path,
    //     // ]);

    //     $this->files->put($full_path, $stub);

    //     $this->components->info(sprintf('%s [%s] created successfully.', $file, $full_path));
    // }

    protected function buildClass_form(string $name): void
    {
        $model = $this->model;

        $extends = 'FormRequest';
        $extends_use = sprintf(
            '%1$s/Http/Requests/FormRequest',
            $this->c->namespace()
        );

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$name' => $name,
        //     '$extends' => $extends,
        //     '$extends_use' => $extends_use,
        //     '$this->c->name()' => $this->c->name(),
        //     '$this->c->namespace()' => $this->c->namespace(),
        //     '$model->name()' => $model?->name(),
        //     '$model->namespace()' => $model?->namespace(),
        // ]);

        $buildClass_slug_table = false;
        $buildClass_rules_revision = false;
        if (in_array($this->c->type(), [
            'create',
        ])) {
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->c' => $this->c,
            // ]);
        } elseif (in_array($this->c->type(), [
            'destroy',
        ])) {
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->c' => $this->c,
            // ]);
        } elseif (in_array($this->c->type(), [
            'edit',
        ])) {
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->c' => $this->c,
            // ]);
        } elseif (in_array($this->c->type(), [
            'lock',
        ])) {
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->c' => $this->c,
            // ]);
        } elseif (in_array($this->c->type(), [
            'restore',
        ])) {
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->c' => $this->c,
            // ]);
        } elseif (in_array($this->c->type(), [
            'show',
        ])) {
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->c' => $this->c,
            // ]);
        } elseif (in_array($this->c->type(), [
            'store',
        ])) {
            $extends = 'BaseStoreRequest';
            $extends_use = 'Playground/Http/Requests/StoreRequest as BaseStoreRequest';
            $buildClass_slug_table = true;
            $buildClass_rules_revision = true;
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->c' => $this->c,
            // ]);
        } elseif (in_array($this->c->type(), [
            'unlock',
        ])) {
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->c' => $this->c,
            // ]);
        } elseif (in_array($this->c->type(), [
            'update',
        ])) {
            $extends = 'BaseUpdateRequest';
            $extends_use = 'Playground/Http/Requests/UpdateRequest as BaseUpdateRequest';
            $buildClass_slug_table = true;
            $buildClass_rules_revision = true;
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->c' => $this->c,
            // ]);
        } elseif (in_array($this->c->type(), [
            'index',
        ])) {
            $extends = 'BaseIndexRequest';
            $extends_use = 'Playground/Http/Requests/IndexRequest as BaseIndexRequest';
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->c' => $this->c,
            // ]);
        } elseif (in_array($this->c->type(), [
            'abstract',
            'abstract-store',
        ])) {
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->c' => $this->c,
            // ]);
        } else {
            $extends = 'FormRequest';
            $extends_use = 'Illuminate/Foundation/Http/FormRequest';
        }

        $this->c->setOptions([
            'extends' => $extends,
            'extends_use' => $extends_use,
            // 'extends' => 'BaseIndexRequest',
            // 'extends_use' => 'Playground\Http\Requests\IndexRequest as BaseIndexRequest',
        ]);

        $this->buildClass_uses($this->c->extends_use());

        $this->searches['extends_use'] = $this->parseClassInput($this->c->extends_use());
        $this->searches['extends'] = $this->parseClassInput($this->c->extends());

        $fillable = $model?->fillable();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$fillable' => $fillable,
        //     // '$model' => $model,
        // ]);
        if (! empty($fillable)) {
            $this->buildClass_rules_constant($model);
        }

        if ($buildClass_slug_table) {
            $this->buildClass_slug_table();
        }

        if ($buildClass_rules_revision) {
            $this->buildClass_rules_revision();
        }

        // Types: store

        // if (in_array($this->c->type(), [
        //     'abstract-store',
        // ])) {
        //     $this->c->setOptions([
        //         'store' => ! empty($this->option('with-store')),
        //     ]);
        //     $this->createStoreTraits();
        // }

        // $traits = [];

        // // $this->createPaginationTrait('StoreSlugTrait', 'request/trait.store.slug.stub');
        // $this->createTrait(
        //     $this->folder(),
        //     'StoreSlugTrait',
        //     'request/trait.store.slug.stub'
        // );

        // $traits['StoreSlugTrait'] = '';
        // $traits['StoreSlugTrait'] = sprintf(
        //     '%1$s\%2$s',
        //     // $this->parseClassInput($this->configuration['namespace']),
        //     $this->getDefaultNamespace(
        //         $this->parseClassInput($this->configuration['namespace'])
        //     ),
        //     'StoreSlugTrait'
        // );

        // foreach ($traits as $trait => $class) {
        //     $this->configuration['uses'][$trait] = $class;
        // }

    }

    protected function buildClass_rules_constant(
        Model $model
    ): void {

        $indent = 4;

        $rules = '';

        $hasFillable = false;
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->class()' => $this->c->class(),
        //     '$this->c->type()' => $this->c->type(),
        // ]);

        if (in_array($this->c->type(), [
            'create',
            'edit',
            'update',
            'store',
        ])) {

            $rules = $this->buildClass_rules_constant_for_only_fillable(
                $model,
                $indent * 2
            );
            $hasFillable = ! empty(trim($rules));
        }

        $rules .= $this->buildClass_rules_constant_for_return_url($indent);
        if (! $hasFillable && ! empty($rules)) {
            $rules = PHP_EOL.$rules;
        }

        if (empty(trim($rules))) {
            return;
        }

        $rules .= str_repeat(' ', $indent);

        // if (! empty($this->searches['constants'])) {
        //     $this->searches['constants'] .= PHP_EOL;
        // }

        $this->searches['constants'] .= <<<PHP_CODE
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [$rules];
PHP_CODE;

        // $this->searches['constants'] .= PHP_EOL;
    }

    protected function buildClass_rules_constant_for_return_url(
        int $indent = 4
    ): string {

        if (! in_array($this->c->type(), [
            'create',
            'edit',
            'destroy',
            'lock',
            'restore',
            'store',
            'unlock',
            'update',
        ])) {
            return '';
        }

        $rules = str_repeat(' ', $indent * 2);

        $rules .= '\'_return_url\' => [\'nullable\', \'url\'],';

        $rules .= PHP_EOL;

        return $rules;
    }

    protected function buildClass_rules_constant_for_only_fillable(
        Model $model,
        int $indent = 8
    ): string {

        $rules = PHP_EOL;

        $casts = $model->casts();

        $required = [];

        if ($model->model_attribute() && $model->model_attribute_required()) {

            if (in_array($this->c->type(), [
                'store',
                'update',
            ])) {
                $required[] = $model->model_attribute();
            }
        }

        foreach ($model->fillable() as $i => $column) {

            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$i' => $i,
            //     '$column' => $column,
            // ]);
            if (empty($column) || ! is_string($column)) {
                \Log::debug(__METHOD__, [
                    'ISSUE' => 'Missing column for rules',
                    '$i' => $i,
                    '$this->model' => $this->model,
                ]);

                continue;
            }

            $rule = '';

            $column_meta = $this->buildClass_model_meta($column, $model);

            $cast = array_key_exists($column, $casts)
                && is_string($casts[$column])
                ? $casts[$column]
                : null;

            if (is_null($cast)) {
                $ids = $model->create()?->ids();
                if (! empty($ids[$column])) {
                    if (! empty($ids[$column]->type())) {
                        $cast = $ids[$column]->type();
                    }
                }
            }

            if (! Str::of($rule)->contains('nullable')
                && ! empty($column_meta['nullable'])
            ) {
                $rule .= "'nullable'";
            }

            if ($cast === 'datetime') {
                // $cast = 'date';
                // Allows parsing: tomorrow midnight
                $cast = 'string';
            } elseif (in_array($cast, [
                'float',
            ])) {
                $cast = 'numeric';
            }

            if ($cast) {
                if (! empty($rule)) {
                    $rule .= ', ';
                }
                $rule .= sprintf('\'%1$s\'', $cast);
            }

            if (in_array($column, $required)) {
                if (! empty($rule)) {
                    $rule .= ', ';
                }
                $rule .= "'required'";
            }

            $rules .= str_repeat(' ', $indent);

            $rules .= sprintf(
                '\'%1$s\' => [%2$s],',
                $column,
                $rule
            );

            $rules .= PHP_EOL;
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$rules' => $rules,
        //     '$this->c->class()' => $this->c->class(),
        // ]);

        return $rules;
    }

    public function buildClass_slug_table(): void
    {
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->searches[extends]' => $this->searches['extends'],
        //     '$this->c->class()' => $this->c->class(),
        // ]);

        if (in_array($this->c->class(), [
            'StoreRequest',
            'UpdateRequest',
        ])) {
            if (! empty($this->searches['constants']) || ! empty($this->searches['properties'])) {
                $this->searches['properties'] .= PHP_EOL;
            }
            $this->searches['properties'] .= sprintf(
                '%2$s    protected string $slug_table = \'%1$s\';',
                $this->model?->table() ?? '',
                PHP_EOL
            );
        }
    }

    protected function buildClass_rules_revision(): void
    {
        $package = $this->c->package();

        $this->searches['methods'] = PHP_EOL.PHP_EOL;

        $this->searches['methods'] .= <<<PHP_CODE
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        \$rules = parent::rules();

        /**
         * @var array<string, bool> \$revisions
         */
        \$revisions = config('$package.revisions');

        if (! empty(\$revisions['optional'])) {
            \$rules['revision'] = 'bool';
        }

        return \$rules;
    }
PHP_CODE;

        // $this->searches['methods'] .= PHP_EOL;
    }
}
