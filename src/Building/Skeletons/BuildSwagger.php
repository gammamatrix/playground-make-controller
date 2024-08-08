<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Building\Skeletons;

use Illuminate\Support\Str;

/**
 * \Playground\Make\Controller\Building\Skeletons\BuildSwagger
 */
trait BuildSwagger
{
    public function skeleton_swagger(string $type): void
    {
        if (! in_array($type, [
            'playground-api',
            'playground-resource',
            'playground-resource-index',
        ])) {
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     'NOTE' => 'SKIPPING: skeleton_swagger',
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

        $revision = $this->c->revision();

        $layout = 'playground::layouts.site';

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
            '--skeleton' => true,
            // '--preload' => true,
            // '--type' => $type,
            '--type' => '',
        ];

        $modelFile = $this->getModelFile();
        $modelFileRevision = '';
        if ($this->hasOption('model-file') && $this->option('model-file')) {
            $options['--model-file'] = $this->option('model-file');
        } else {
            if ($modelFile) {
                $options['--model-file'] = $modelFile;
            }
        }

        if ($revision && $modelFile && is_string($modelFile)) {
            $modelFileRevision = Str::of($modelFile)->before('.json')->finish('-revision.json')->toString();
        }

        if ($modelFileRevision) {
            $options['--model-revision-file'] = $modelFileRevision;
        }

        if ($type === 'api') {
        } elseif ($type === 'resource') {
        } elseif ($type === 'playground-resource') {
        } elseif ($type === 'playground-api') {
        }

        $options['--type'] = 'model';
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);

        if (empty($this->call('playground:make:swagger', $options))) {

            // $file_model = sprintf(
            //     '%1$s%2$s/%3$s/docs.model.json',
            //     $this->laravel->storagePath(),
            //     $path_resources_packages,
            //     Str::of($name)->kebab(),
            // );
            // if (! in_array($file_model, $this->c->docs())) {
            //     $this->c->docs()[] = $file_model;
            // }
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$path_resources_packages' => $path_resources_packages,
            //     '$file_model' => $file_model,
            //     '$this->configuration' => $this->configuration,
            // ]);
        }

        // art playground:make:controller Board --namespace GammaMatrix/Playground/Matrix/Resource --class BoardController --module Matrix --skeleton --force --type playground-resource --model-file vendor/gammamatrix/playground-stub/resources/playground/matrix/model.board.json
        // art playground:make:controller Board --namespace GammaMatrix/Playground/Matrix/Resource --class BoardController --module Matrix --skeleton --force --type playground-resource --model-file vendor/gammamatrix/playground-stub/resources/playground/matrix/model.board.json
        // art playground:make:controller Epic --namespace GammaMatrix/Playground/Matrix/Resource --class EpicController --module Matrix --skeleton --force --type playground-resource --model-file vendor/gammamatrix/playground-stub/resources/playground/matrix/model.epic.json
        // art playground:make:docs Board --type controller --controller-type playground-resource --namespace GammaMatrix/Playground/Matrix/Resource --model-file vendor/gammamatrix/playground-stub/resources/playground/matrix/model.board.json --preload --module Matrix
        $options['--type'] = 'controller';

        if (! empty($this->c->type())) {
            $options['--controller-type'] = $this->c->type();
        }

        // $path_resources_packages = $this->getResourcePackageFolder();

        if (empty($this->call('playground:make:swagger', $options))) {

            // $file_api = sprintf(
            //     '%1$s%2$s/docs.controller.json',
            //     $this->laravel->storagePath(),
            //     $path_resources_packages
            // );
            // if (! in_array($file_api, $this->c->docs())) {
            //     $this->c->docs()[] = $file_api;
            // }
        }
    }
}
