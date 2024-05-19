<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Building\Skeletons;

use Illuminate\Support\Str;

/**
 * \Playground\Make\Controller\Building\Skeletons\BuildRoutes
 */
trait BuildRoutes
{
    public function skeleton_routes(string $type): void
    {
        if (! in_array($type, [
            'playground-api',
            'playground-resource',
            'playground-resource-index',
        ])) {
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     'NOTE' => 'SKIPPING: skeleton_routes',
            //     '$type' => $type,
            // ]);
            return;
        }
        $force = $this->hasOption('force') && $this->option('force');
        $model = $this->hasOption('model') ? $this->option('model') : '';
        $module = $this->hasOption('module') ? $this->option('module') : '';
        $name = Str::of($this->c->name())->before('Controller')->studly()->toString();
        $namespace = $this->hasOption('namespace') ? $this->option('namespace') : '';
        $organization = $this->hasOption('organization') ? $this->option('organization') : '';
        $package = $this->hasOption('package') ? $this->option('package') : '';

        // $layout = 'playground::layouts.site';

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

        $options = [
            'name' => $name,
            '--namespace' => $namespace,
            '--force' => $force,
            '--package' => $package,
            '--organization' => $organization,
            '--model' => $model,
            '--module' => $module,
            '--type' => $type,
            // '--class' => $name,
            // '--title' => Str::of($this->c->name())->snake()->replace('_', ' ')->title()->toString(),
            // '--config' => Str::of($package)->snake()->toString(),
        ];
        $modelFile = $this->getModelFile();

        if ($this->hasOption('model-file') && $this->option('model-file')) {
            $options['--model-file'] = $this->option('model-file');
        } else {
            if ($modelFile) {
                $options['--model-file'] = $modelFile;
            }
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
        //     '$modelFile' => $modelFile,
        //     '$options' => $options,
        //     '$this->options()' => $this->options(),
        // ]);
        if (empty($this->call('playground:make:route', $options))) {

            // $path_resources_templates = $this->getResourcePackageFolder();

            // $file_request = sprintf(
            //     '%1$s%2$s/%3$s/route.json',
            //     $this->laravel->storagePath(),
            //     $path_resources_templates,
            //     Str::of($this->c->name())->kebab()
            // );

            // if (! in_array($file_request, $this->c->templates())) {
            //     $this->c->templates()[] = $file_request;
            // }
        }
    }
}
