<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Make\Controller\Building\Skeletons;

use Illuminate\Support\Str;
use Playground\Make\Controller\Configuration\Controller\PackageInfo;

/**
 * \Playground\Make\Controller\Building\Skeletons\BuildPackageInfo
 */
trait BuildPackageInfo
{
    /**
     * @param  array<string, mixed>  $options
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

        $packageInfo->apply();
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
     * @param  array<string, mixed>  $options
     */
    public function preparePackageInfo_privilege(
        PackageInfo $packageInfo,
        array $options = []
    ): void {

        $privilege = $this->c->privilege();

        if (! empty($options['privilege']) && is_string($options['privilege'])) {

            $privilege = $options['privilege'];

            $this->c->setOptions([
                'privilege' => $privilege,
            ]);
        }

        if (! $privilege) {

            $package = $this->c->package();

            if ($package) {
                $privilege = $package;
            }

            $slug = $this->c->slug();
            if ($slug) {
                if ($privilege) {
                    $privilege .= ':';
                }
                $privilege .= $slug;
            }

            if (! $this->c->privilege()) {
                $this->c->setOptions([
                    'privilege' => $privilege,
                ]);
            }
        }

        if (in_array($this->c->type(), [
            'playground-api',
            'playground-resource',
        ])) {
            $model_kebab = $this->model?->model_kebab();

            if ($model_kebab) {

                if ($privilege) {
                    $privilege .= ':';
                }

                $privilege .= Str::of($model_kebab)->kebab()->toString();
            }
        }

        $packageInfo->setOptions([
            'privilege' => $privilege,
        ]);

        $this->c->setOptions([
            'privilege' => $privilege,
        ]);

        $this->searches['privilege'] = $packageInfo->privilege();
    }

    /**
     * @param  array<string, mixed>  $options
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

        $view = $this->c->view();

        if (! empty($options['view']) && is_string($options['view'])) {

            $view = $options['view'];

            $this->c->setOptions([
                'view' => $view,
            ]);
        }

        if (! $view) {

            $package = $this->c->package();

            if ($package) {
                $view = $package;
            }

            $slug = $this->c->slug();
            if ($slug) {
                if ($view) {
                    $view .= '::';
                }
                $view .= $slug;
            }

            if (! $this->c->view()) {
                $this->c->setOptions([
                    'view' => $view,
                ]);
            }
        }

        if (in_array($this->c->type(), [
            'playground-api',
            'playground-resource',
        ])) {
            $model_kebab = $this->model?->model_kebab();

            if ($model_kebab) {

                if ($view) {
                    $view .= '::';
                }

                $view .= $model_kebab;
            }
        }

        $packageInfo->setOptions([
            'view' => $view,
        ]);

        $this->c->setOptions([
            'view' => $view,
        ]);

        $this->searches['view'] = $packageInfo->view();
    }

    /**
     * @param  array<string, mixed>  $options
     */
    public function preparePackageInfo_module(
        PackageInfo $packageInfo,
        array $options = []
    ): void {
        if (! empty($options['module']) && is_string($options['module'])) {
            $packageInfo->setOptions([
                'module_label' => $options['module'],
            ]);
        }

        if (! $packageInfo->module_label() && $this->c->module()) {
            $packageInfo->setOptions([
                'module_label' => $this->c->module(),
            ]);
        }

        $module = $packageInfo->module_label();
        if (ctype_upper($module)) {
            $module_labels = $module.'s';
        } else {
            $module_labels = Str::of($module)->plural()->toString();
        }

        $packageOptions = [
            'module_label_plural' => $module_labels,
            'module_labels' => $module_labels,
        ];

        $module_slug = $packageInfo->module_slug();
        if (! $module_slug) {
            if ($this->model?->module_slug()) {
                $module_slug = $this->model->module_slug();
            } else {
                if (ctype_upper($module)) {
                    $module_slug = Str::of($module)->lower()->kebab()->toString();
                } else {
                    $module_slug = Str::of($module)->kebab()->toString();
                }
            }
        }

        if ($module_slug) {
            $packageOptions['module_slug'] = $module_slug;
        }

        $module_slugs = $packageInfo->module_slugs();
        if (! $module_slugs) {
            if ($this->model?->module_slugs()) {
                $module_slugs = $this->model->module_slugs();
            } else {
                if (ctype_upper($module)) {
                    $module_slugs = Str::of($module)->lower()->plural()->finish('s')->kebab()->toString();
                } else {
                    $module_slugs = Str::of($module_labels)->kebab()->toString();
                }
            }
        }

        if ($module_slugs) {
            $packageOptions['module_slugs'] = $module_slugs;
        }

        $module_route = $this->c->module_route();
        if (! $module_route) {

            if ($this->c->package()) {
                foreach (Str::of($this->c->package())->replace('-', '.')->replace('_', '.')->explode('.') as $value) {
                    if (! empty($module_route)) {
                        $module_route .= '.';
                    }
                    $module_route .= Str::of($value)->slug('-');
                }
            }

            if (! empty($this->c->slug_plural())) {
                $module_route .= '.'.$this->c->slug_plural();

            } elseif (! empty($this->c->slug())) {
                $module_route .= '.'.$this->c->slug();
            }
            $packageOptions['module_route'] = $module_route;
            $this->c->setOptions(['module_route' => $module_route]);
        }

        $packageInfo->setOptions($packageOptions);

        $this->searches['module_label'] = $module;
        $this->searches['module_label_plural'] = $module_labels;
        $this->searches['module_labels'] = $module_labels;
        $this->searches['module_slug'] = $module_slug;
        $this->searches['module_slugs'] = $module_slugs;
        $this->searches['module_route'] = $module_route;
    }

    public function preparePackageInfo_model(
        PackageInfo $packageInfo
    ): void {

        $options = [
            'model_camel' => $this->c->model_camel(),
            'model_camels' => $this->c->model_camels(),
            'model_label' => $this->c->model_label(),
            'model_labels' => $this->c->model_labels(),
            'model_lower' => $this->c->model_lower(),
            'model_lowers' => $this->c->model_lowers(),
            'model_kebab' => $this->c->model_kebab(),
            'model_kebabs' => $this->c->model_kebabs(),
            'model_slug' => $this->c->model_slug(),
            'model_slugs' => $this->c->model_slugs(),
            'model_snake' => $this->c->model_snake(),
            'model_snakes' => $this->c->model_snakes(),
            'model_studly' => $this->c->model_studly(),
            'model_studlies' => $this->c->model_studlies(),
            'model_variable' => $this->c->model_variable(),
            'model_variables' => $this->c->model_variables(),
            // deprecated attributes:
            'model_label_plural' => $this->c->model_labels(),
            'model_variable_plural' => $this->c->model_variables(),
            'model_slug_plural' => $this->c->model_slugs(),
        ];

        if ($this->c->type() === 'playground-resource-linked') {
            $route = 'linked';
        } elseif ($this->c->type() === 'playground-resource-tagged') {
            $route = 'tagged';
        } else {
            $route = $this->c->model_slugs();
        }

        if ($packageInfo->module_route()) {
            $options['model_route'] = sprintf(
                '%1$s.%2$s',
                $packageInfo->module_route(),
                $route,
            );
            $this->searches['model_route'] = $options['model_route'];
            $this->c->setOptions(['model_route' => $options['model_route']])->apply();
        }

        $packageInfo->setOptions($options);
        $this->preparePackageInfo_model_attribute($packageInfo);

        $packageInfo->apply();

        //        if (! in_array($this->c->type(), ['base'])) {
        //            dump([
        //                '__METHOD__' => __METHOD__,
        //                '$this->c->type()' => $this->c->type(),
        //                '$this->c->toArray()' => $this->c->toArray(),
        //                '$options' => $options,
        //                '$route' => $route,
        //                '$packageInfo' => $packageInfo,
        //                '$this->searches' => $this->searches,
        //            ]);
        //        }
    }

    public function preparePackageInfo_model_attribute(
        PackageInfo $packageInfo
    ): void {
        if (! $packageInfo->model_attribute() && $this->model?->model_attribute()) {
            $packageInfo->setOptions([
                'model_attribute' => $this->model->model_attribute(),
            ]);
        }

        $this->searches['model_attribute'] = $packageInfo->model_attribute();
    }
}
