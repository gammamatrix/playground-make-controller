<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Building\Skeletons;

use Illuminate\Support\Str;
use Playground\Make\Configuration\Model;
use Playground\Make\Controller\Configuration\Controller\PackageInfo;

/**
 * \Playground\Make\Controller\Building\Skeletons\BuildPackageInfo
 */
trait BuildPackageInfo
{
    // /**
    //  * @var array<string, string>
    //  */
    // public array $packageInfo = [
    //     'model_attribute' => 'label',
    //     'model_label' => 'Backlog',
    //     'model_label_plural' => 'Backlogs',
    //     'model_route' => 'playground.matrix.resource.backlogs',
    //     'model_slug' => 'backlog',
    //     'model_slug_plural' => 'backlogs',
    //     'module_label' => 'Matrix',
    //     'module_label_plural' => 'Matrices',
    //     'module_route' => 'playground.matrix.resource',
    //     'module_slug' => 'matrix',
    //     'privilege' => 'playground-matrix-resource:backlog',
    //     'table' => 'matrix_backlogs',
    //     'view' => 'playground-matrix-resource::backlog',
    // ];

    /**
     * @param array<string, mixed> $options
     */
    public function preparePackageInfo(array $options = []): void
    {
        $packageInfo = $this->c->addPackageInfo();

        if (in_array($this->c->type(), [
            'playground-api',
            'playground-resource',
        ]) && ! $this->model) {
            $this->components->error(sprintf(
                'Expecting the model to be set for the [%s] and model file: [%s]',
                $this->c->name(),
                $this->getModelFile()
            ));

            return;
        }

        $this->preparePackageInfo_module($packageInfo, $options);

        $this->preparePackageInfo_model($packageInfo);

        $this->preparePackageInfo_table($packageInfo);
        $this->preparePackageInfo_privilege($packageInfo, $options);
        $this->preparePackageInfo_view($packageInfo, $options);
    }

    public function preparePackageInfo_table(
        PackageInfo $packageInfo
    ): void {
        $table = $this->model?->table();
        if ($table) {
            $packageInfo->setOptions([
                'table' => $table,
            ]);
        }
        $this->searches['table'] = $packageInfo->table();
    }

    /**
     * @param array<string, mixed> $options
     */
    public function preparePackageInfo_privilege(
        PackageInfo $packageInfo,
        array $options = []
    ): void {

        if (! empty($options['privilege']) && is_string($options['privilege'])) {
            $packageInfo->setOptions([
                'privilege' => $options['privilege'],
            ]);
        }

        $package = $this->c->package();
        $slug = $this->c->slug();

        if (! $slug && $this->c->skeleton() && $this->model?->model_slug()) {
            $slug = Str::of($this->model->model_slug())->slug()->toString();
        }

        if (! $packageInfo->privilege()
            && $package
            && $slug
        ) {
            $packageInfo->setOptions([
                'privilege' => sprintf(
                    '%1$s:%2$s',
                    $package,
                    $slug
                ),
            ]);
        }

        $this->searches['privilege'] = $packageInfo->privilege();
    }

    /**
     * @param array<string, mixed> $options
     */
    public function preparePackageInfo_view(
        PackageInfo $packageInfo,
        array $options = []
    ): void {
        if (in_array($this->c->type(), [
            'api',
            'playground-api',
        ])) {
            return;
        }

        if (! empty($options['view']) && is_string($options['view'])) {
            $packageInfo->setOptions([
                'view' => $options['view'],
            ]);
        }

        $package = $this->c->package();
        $slug = $this->c->slug();

        if (! $slug && $this->c->skeleton() && $this->model?->model_slug()) {
            $slug = Str::of($this->model->model_slug())->slug()->toString();
        }

        if (! $packageInfo->view()
            && $package
            && $slug
        ) {
            $packageInfo->setOptions([
                'view' => sprintf(
                    '%1$s::%2$s',
                    $package,
                    $slug
                ),
            ]);
        }

        $this->searches['view'] = $packageInfo->view();
    }

    /**
     * @param array<string, mixed> $options
     */
    public function preparePackageInfo_module(
        PackageInfo $packageInfo,
        array $options = []
    ): void {
        $this->preparePackageInfo_module_label($packageInfo, $options);
        $this->preparePackageInfo_module_label_plural($packageInfo);
        $this->preparePackageInfo_module_route($packageInfo);
        $this->preparePackageInfo_module_slug($packageInfo);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function preparePackageInfo_module_label(
        PackageInfo $packageInfo,
        array $options = []
    ): void {
        if (! empty($options['module']) && is_string($options['module'])) {
            $packageInfo->setOptions([
                'module_label' => $options['module'],
            ]);
        }

        if (! $packageInfo->module_label() && $this->model?->module()) {
            $packageInfo->setOptions([
                'module_label' => $this->model->module(),
            ]);
        }

        $this->searches['module_label'] = $packageInfo->module_label();
    }

    public function preparePackageInfo_module_label_plural(
        PackageInfo $packageInfo
    ): void {
        if (! $packageInfo->module_label_plural() && $packageInfo->module_label()) {
            $packageInfo->setOptions([
                'module_label_plural' => Str::of($packageInfo->module_label())->plural()->toString(),
            ]);
        }

        $this->searches['module_label_plural'] = $packageInfo->module_label_plural();
    }

    public function preparePackageInfo_module_route(
        PackageInfo $packageInfo
    ): void {
        if (! $this->c->module_route()) {

            $route = '';

            if ($this->c->package()) {
                foreach (Str::of($this->c->package())->replace('-', '.')->replace('_', '.')->explode('.') as $value) {
                    if (! empty($route)) {
                        $route .= '.';
                    }
                    $route .= Str::of($value)->slug('-');
                }
            }

            if (! empty($this->c->slug_plural())) {
                $route .= '.'.$this->c->slug_plural();

            } elseif (! empty($this->c->slug())) {
                $route .= '.'.$this->c->slug();
            }

            $this->c->setOptions([
                'module_route' => $route,
            ]);

            $this->searches['module_route'] = $this->c->module_route();
        }
    }

    public function preparePackageInfo_module_slug(
        PackageInfo $packageInfo
    ): void {
        if (! $packageInfo->module_slug()) {
            if ($this->model?->module_slug()) {
                $packageInfo->setOptions([
                    'module_slug' => $this->model->module_slug(),
                ]);

            } elseif ($this->model?->model_singular()) {
                $packageInfo->setOptions([
                    'module_slug' => Str::of($this->model->model_singular())->slug()->toString(),
                ]);
            }
        }

        $this->searches['module_slug'] = $packageInfo->module_slug();
    }

    public function preparePackageInfo_model(
        PackageInfo $packageInfo
    ): void {
        $this->preparePackageInfo_model_label($packageInfo);
        $this->preparePackageInfo_model_label_plural($packageInfo);
        $this->preparePackageInfo_model_slug($packageInfo);
        $this->preparePackageInfo_model_slug_plural($packageInfo);
        $this->preparePackageInfo_model_route($packageInfo);
    }

    public function preparePackageInfo_model_label(
        PackageInfo $packageInfo
    ): void {
        if (! $packageInfo->model_label() && $this->model?->model_singular()) {
            $packageInfo->setOptions([
                'model_label' => $this->model->model_singular(),
            ]);
        }

        $this->searches['model_label'] = $packageInfo->model_label();
    }

    public function preparePackageInfo_model_label_plural(
        PackageInfo $packageInfo
    ): void {
        if (! $packageInfo->model_label_plural() && $this->model?->model_plural()) {
            $packageInfo->setOptions([
                'model_label_plural' => $this->model->model_plural(),
            ]);
        }

        $this->searches['model_label_plural'] = $packageInfo->model_label_plural();
    }

    public function preparePackageInfo_model_route(
        PackageInfo $packageInfo
    ): void {
        if (! $this->c->model_route() && $packageInfo->model_slug_plural()) {

            $route = '';

            if ($this->c->package()) {
                foreach (Str::of($this->c->package())->replace('-', '.')->replace('_', '.')->explode('.') as $value) {
                    if (! empty($route)) {
                        $route .= '.';
                    }
                    $route .= Str::of($value)->slug('-');
                }
            }

            if (! empty($this->c->slug_plural())) {
                $route .= '.'.$this->c->slug_plural();

            } elseif (! empty($this->c->slug())) {
                $route .= '.'.$this->c->slug();
            }

            $route .= '.'.$packageInfo->model_slug_plural();

            $this->c->setOptions([
                'model_route' => $route,
            ]);

            $this->searches['model_route'] = $this->c->model_route();
        }
    }

    public function preparePackageInfo_model_slug(
        PackageInfo $packageInfo
    ): void {
        if (! $packageInfo->model_slug()) {
            if ($this->model?->model_slug()) {
                $packageInfo->setOptions([
                    'model_slug' => $this->model->model_slug(),
                ]);

            } elseif ($this->model?->model_singular()) {
                $packageInfo->setOptions([
                    'model_slug' => Str::of($this->model->model_singular())->slug()->toString(),
                ]);
            }
        }

        $this->searches['model_slug'] = $packageInfo->model_slug();
    }

    public function preparePackageInfo_model_slug_plural(
        PackageInfo $packageInfo
    ): void {
        if (! $packageInfo->model_slug_plural() && $this->model?->model_plural()) {
            $packageInfo->setOptions([
                'model_slug_plural' => Str::of($this->model->model_plural())->slug()->toString(),
            ]);
        }

        $this->searches['model_slug_plural'] = $packageInfo->model_slug_plural();
    }
}
