<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Building\Skeletons;

use Illuminate\Support\Str;

/**
 * \Playground\Make\Controller\Building\Skeletons\BuildResources
 */
trait BuildResources
{
    public function skeleton_resources(string $type): void
    {
        $resources = [];
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        // ]);

        $force = $this->hasOption('force') && $this->option('force');
        $name = Str::of($this->c->name())->before('Controller')->studly()->toString();

        // $layout = 'playground::layouts.site';

        $model = $this->c->model();
        $module = $this->c->module();
        $namespace = $this->c->namespace();
        $package = $this->c->package();
        $organization = $this->c->organization();
        $extends = $this->c->organization();

        if ($type === 'resource') {
            $resources['resource'] = [
                '--class' => Str::of($name)->studly()->finish('Resource'),
                'name' => $name,
            ];
            $resources['collection'] = [
                '--class' => Str::of($name)->studly()->finish('Collection'),
                '--collection' => true,
                'name' => $name.'Collection',
                // 'name' => $name,
            ];
        } elseif ($type === 'playground-resource') {
            $resources['resource'] = [
                '--class' => Str::of($name)->studly()->finish('Resource'),
                'name' => $name,
            ];
            $resources['collection'] = [
                '--class' => Str::of($name)->studly()->finish('Collection'),
                '--collection' => true,
                'name' => $name.'Collection',
                // 'name' => $name,
            ];
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        //     '$resources' => $resources,
        // ]);

        $modelFile = $this->getModelFile();

        foreach ($resources as $resource_type => $resource) {
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$resource_type' => $resource_type,
            //     '$resource' => $resource,
            // ]);
            if ($force) {
                $resource['--force'] = true;
            }
            if ($namespace) {
                $resource['--namespace'] = $namespace;
            }
            if ($package) {
                $resource['--package'] = $package;
            }
            if ($organization) {
                $resource['--organization'] = $organization;
            }
            if ($model) {
                $resource['--model'] = $model;
            }
            if ($extends) {
                $resource['--extends'] = $extends;
            }

            if ($this->hasOption('model-file') && $this->option('model-file')) {
                $resource['--model-file'] = $this->option('model-file');
            } else {
                if ($modelFile) {
                    $resource['--model-file'] = $modelFile;
                }
            }

            $resource['--module'] = $module;
            $resource['--skeleton'] = true;
            // $resource = array_merge([
            //     'name' => $this->argument('name'),
            // ], $resource);
            // $resource['name'] = $name;
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$resource' => $resource,
            // ]);
            if (empty($this->call('playground:make:resource', $resource))) {

                $path_resources_packages = $this->getResourcePackageFolder();

                // $file_resource = ('vendor/gammamatrix/playground-stub/resources/playground/matrix/resource/version/resource.test.json');
                $file_resource = sprintf(
                    '%1$s%2$s/%3$s',
                    $this->laravel->storagePath(),
                    $path_resources_packages,
                    $this->getConfigurationFilename_for_resource($name, $resource_type)
                );

                // dd([
                //     '__METHOD__' => __METHOD__,
                //     '$file_resource' => $file_resource,
                //     '$path_resources_packages' => $path_resources_packages,
                //     '$this->configuration' => $this->configuration,
                //     '$this->laravel->storagePath()' => $this->laravel->storagePath(),
                // ]);

                if (! in_array($file_resource, $this->c->resources())) {
                    $this->c->resources()[] = $file_resource;
                }
            }
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->configuration' => $this->configuration,
        //     '$type' => $type,
        // ]);
    }
}
