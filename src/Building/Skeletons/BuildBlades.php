<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Building\Skeletons;

use Illuminate\Support\Str;

/**
 * \Playground\Make\Controller\Building\Skeletons\BuildBlades
 */
trait BuildBlades
{
    // protected ?Package $modelPackage = null;

    // public function load_model_package(string $model_package): void
    // {
    //     $payload = $this->readJsonFileAsArray($model_package);
    //     if (! empty($payload)) {
    //         $this->modelPackage = new Package($payload);
    //         // $this->modelPackage->apply();
    //     }
    // }

    public function skeleton_blades(string $type): void
    {
        if (! in_array($type, [
            'playground-resource',
            'playground-resource-index',
        ])) {
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     'NOTE' => 'SKIPPING: skeleton_blades',
            //     '$type' => $type,
            // ]);
            return;
        }

        $model_package = $this->hasOption('model-package') && $this->option('model-package') ? $this->option('model-package') : '';
        // $models = $this->modelPackage?->models() ?? [];

        $force = $this->hasOption('force') && $this->option('force');
        $model = $this->hasOption('model') ? $this->option('model') : '';
        $module = $this->hasOption('module') ? $this->option('module') : '';
        $name = Str::of($this->c->name())->before('Controller')->studly()->toString();
        $namespace = $this->hasOption('namespace') ? $this->option('namespace') : '';
        $organization = $this->hasOption('organization') ? $this->option('organization') : '';
        $package = $this->hasOption('package') ? $this->option('package') : '';

        if (empty($model)) {
            $model = $this->c->model();
        }

        if (empty($module)) {
            $module = $this->c->module();
        }

        if (empty($namespace)) {
            $namespace = $this->rootNamespace();
        }

        if (empty($package)) {
            $package = $this->c->package();
        }

        if (empty($organization)) {
            $organization = $this->c->organization();
        }

        $layout = 'playground::layouts.site';

        $title = Str::of($name)->studly()->toString();

        if (in_array($type, [
            'playground-resource',
        ])) {
            $layout = 'playground::layouts.resource';
        } elseif (in_array($type, [
            'playground-resource-index',
        ])) {
            $title = $module;
            $layout = 'playground::layouts.resource.layout';
        } else {
            $title = Str::of($this->c->name())->snake()->replace('_', ' ')->title()->toString();
        }

        $options = [
            'name' => $name,
            '--namespace' => $namespace,
            '--force' => $force,
            '--package' => $package,
            '--organization' => $organization,
            '--model' => $model,
            '--module' => $module,
            '--type' => $type,
            '--class' => $name,
            '--title' => $title,
            // '--config' => Str::of($package)->snake()->toString(),
            '--extends' => $layout,
        ];

        $modelFile = $this->getModelFile();

        if ($this->hasOption('model-file') && $this->option('model-file')) {
            $options['--model-file'] = $this->option('model-file');
        } else {
            if ($modelFile) {
                $options['--model-file'] = $modelFile;
            }
        }

        if ($model_package) {
            $options['--model-package'] = $model_package;
        }

        if ($this->c->revision()) {
            $options['--revision'] = true;
        }

        if (! empty($this->c->route()) && is_string($this->c->route())) {
            $options['--route'] = $this->c->route();
        }

        if ($type === 'api') {
        } elseif ($type === 'resource') {
        } elseif ($type === 'playground-resource') {
        } elseif ($type === 'playground-resource-index') {
        } elseif ($type === 'playground-api') {
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);

        if (empty($this->call('playground:make:blade', $options))) {

        }
    }
}
