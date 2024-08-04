<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Building\Skeletons;

use Illuminate\Support\Str;

/**
 * \Playground\Make\Controller\Building\Skeletons\BuildRequests
 */
trait BuildRequests
{
    public function skeleton_requests(string $type): void
    {
        if (! in_array($type, [
            'playground-api',
            'playground-resource',
            'playground-resource-index',
        ])) {
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     'NOTE' => 'SKIPPING: skeleton_requests',
            //     '$type' => $type,
            // ]);
            return;
        }

        $requests = [];

        $force = $this->hasOption('force') && $this->option('force');
        $model = $this->c->model();
        $module = $this->c->module();
        $name = Str::of($this->c->name())->before('Controller')->studly()->toString();
        $namespace = $this->rootNamespace();
        $organization = $this->c->organization();
        $package = $this->c->package();

        // $extends = '';

        if ($type === 'api') {
            $requests['destroy'] = [
                '--type' => 'destroy',
                '--class' => 'DestroyRequest',
            ];
            $requests['index'] = [
                '--type' => 'index',
                '--class' => 'IndexRequest',
            ];
            $requests['restore'] = [
                '--type' => 'restore',
                '--class' => 'RestoreRequest',
            ];
            $requests['show'] = [
                '--type' => 'show',
                '--class' => 'ShowRequest',
            ];
            $requests['store'] = [
                '--type' => 'store',
                '--class' => 'StoreRequest',
            ];
            $requests['update'] = [
                '--type' => 'update',
                '--class' => 'UpdateRequest',
            ];
        } elseif ($type === 'playground-api') {

            if ($namespace) {
                // $extends = sprintf('%1$s/Http/Requests/%2$s/FormRequest', $namespace, $name);
                // $extends = sprintf('%1$s/Http/Requests/FormRequest', $namespace);
            }

            $requests['create'] = [
                '--type' => 'create',
                '--class' => 'CreateRequest',
            ];
            $requests['destroy'] = [
                '--type' => 'destroy',
                '--class' => 'DestroyRequest',
            ];
            $requests['edit'] = [
                '--type' => 'edit',
                '--class' => 'EditRequest',
            ];
            $requests['index'] = [
                '--type' => 'index',
                '--class' => 'IndexRequest',
                // '--extends' => 'Playground/Http/Requests/IndexRequest as BaseIndexRequest',
                '--with-pagination' => true,
            ];
            $requests['lock'] = [
                '--type' => 'lock',
                '--class' => 'LockRequest',
            ];
            $requests['restore'] = [
                '--type' => 'restore',
                '--class' => 'RestoreRequest',
            ];
            $requests['show'] = [
                '--type' => 'show',
                '--class' => 'ShowRequest',
            ];
            $requests['store'] = [
                '--type' => 'store',
                '--class' => 'StoreRequest',
                // '--extends' => 'Playground/Http/Requests/StoreRequest as BaseStoreRequest',
                '--with-store' => true,
            ];
            $requests['unlock'] = [
                '--type' => 'unlock',
                '--class' => 'UnlockRequest',
            ];
            $requests['update'] = [
                '--type' => 'update',
                '--class' => 'UpdateRequest',
                // '--extends' => 'Playground/Http/Requests/UpdateRequest as BaseUpdateRequest',
                '--with-store' => true,
            ];
        } elseif ($type === 'playground-resource') {

            if ($namespace) {
                // $extends = sprintf('%1$s/Http/Requests/%2$s/FormRequest', $namespace, $name);
                // $extends = sprintf('%1$s/Http/Requests/FormRequest', $namespace);
            }

            $requests['create'] = [
                '--type' => 'create',
                '--class' => 'CreateRequest',
            ];
            $requests['destroy'] = [
                '--type' => 'destroy',
                '--class' => 'DestroyRequest',
            ];
            $requests['edit'] = [
                '--type' => 'edit',
                '--class' => 'EditRequest',
            ];
            $requests['index'] = [
                '--type' => 'index',
                '--class' => 'IndexRequest',
                // '--extends' => 'Playground/Http/Requests/IndexRequest as BaseIndexRequest',
                '--with-pagination' => true,
            ];
            $requests['lock'] = [
                '--type' => 'lock',
                '--class' => 'LockRequest',
            ];
            $requests['restore'] = [
                '--type' => 'restore',
                '--class' => 'RestoreRequest',
            ];
            $requests['show'] = [
                '--type' => 'show',
                '--class' => 'ShowRequest',
            ];
            $requests['store'] = [
                '--type' => 'store',
                '--class' => 'StoreRequest',
                // '--extends' => 'Playground/Http/Requests/StoreRequest as BaseStoreRequest',
                '--with-store' => true,
            ];
            $requests['unlock'] = [
                '--type' => 'unlock',
                '--class' => 'UnlockRequest',
            ];
            $requests['update'] = [
                '--type' => 'update',
                '--class' => 'UpdateRequest',
                // '--extends' => 'Playground/Http/Requests/UpdateRequest as BaseUpdateRequest',
                '--with-store' => true,
            ];
        } elseif ($type === 'resource') {
            $requests['create'] = [
                '--type' => 'create',
                '--class' => 'CreateRequest',
            ];
            $requests['destroy'] = [
                '--type' => 'destroy',
                '--class' => 'DestroyRequest',
            ];
            $requests['edit'] = [
                '--type' => 'edit',
                '--class' => 'EditRequest',
            ];
            $requests['index'] = [
                '--type' => 'index',
                '--class' => 'IndexRequest',
                '--with-pagination' => true,
            ];
            $requests['restore'] = [
                '--type' => 'restore',
                '--class' => 'RestoreRequest',
            ];
            $requests['show'] = [
                '--type' => 'show',
                '--class' => 'ShowRequest',
            ];
            $requests['store'] = [
                '--type' => 'store',
                '--class' => 'StoreRequest',
                '--with-store' => true,
            ];
            $requests['update'] = [
                '--type' => 'update',
                '--class' => 'UpdateRequest',
                '--with-store' => true,
            ];
        } else {
            $requests = [
                'index' => [
                    '--type' => 'default',
                    '--class' => 'IndexRequest',
                ],
            ];
        }

        $modelFile = $this->getModelFile();

        foreach ($requests as $request) {
            if ($force) {
                $request['--force'] = true;
            }
            if ($namespace) {
                $request['--namespace'] = $namespace;
            }
            if ($package) {
                $request['--package'] = $package;
            }
            if ($organization) {
                $request['--organization'] = $organization;
            }
            if ($model) {
                $request['--model'] = $model;
            }
            if ($this->hasOption('model-file') && $this->option('model-file')) {
                $request['--model-file'] = $this->option('model-file');
            } else {
                if ($modelFile) {
                    $request['--model-file'] = $modelFile;
                }
            }

            $request['--skeleton'] = true;
            $request['--module'] = $module;
            // $request = array_merge([
            //     'name' => $this->argument('name'),
            // ], $request);
            $request['name'] = $name;
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$request' => $request,
            // ]);
            if (empty($this->call('playground:make:request', $request))) {

                $path_resources_packages = $this->getResourcePackageFolder();

                // $file_request = ('vendor/gammamatrix/playground-stub/resources/playground/matrix/resource/version/request.test.json');
                $file_request = sprintf(
                    '%1$s%2$s/%3$s',
                    $this->laravel->storagePath(),
                    $path_resources_packages,
                    $this->getConfigurationFilename_for_request($name, $request['--type'])
                );

                // dd([
                //     '__METHOD__' => __METHOD__,
                //     '$name' => $name,
                //     '$request' => $request,
                //     '$file_request' => $file_request,
                //     '$path_resources_packages' => $path_resources_packages,
                //     // '$this->c' => $this->c,
                // ]);

                if (! in_array($file_request, $this->c->requests())) {
                    $this->c->requests()[] = $file_request;
                }
            }
        }
    }

    protected function getConfigurationFilename_for_request(string $name, string $type): string
    {
        return sprintf(
            '%1$s/request%2$s.json',
            Str::of($name)->kebab(),
            $type ? '.'.Str::of($type)->kebab() : ''
        );
    }
}
