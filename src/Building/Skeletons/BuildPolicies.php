<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Building\Skeletons;

use Illuminate\Support\Str;

/**
 * \Playground\Make\Controller\Building\Skeletons\BuildPolicies
 */
trait BuildPolicies
{
    public function skeleton_policy(string $type): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');
        $name = Str::of($this->c->name())->before('Controller')->studly()->toString();

        $params = [
            'name' => $name,
            '--class' => Str::of($name)->studly()->finish('Policy')->toString(),
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--model' => $this->c->model(),
            '--module' => $this->c->module(),
            '--type' => $this->c->type(),
        ];

        $modelFile = $this->getModelFile();

        if ($this->hasOption('model-file') && $this->option('model-file')) {
            $params['--model-file'] = $this->option('model-file');
        } else {
            if ($modelFile) {
                $params['--model-file'] = $modelFile;
            }
        }

        if ($type === 'api') {
        } elseif ($type === 'resource') {
        } elseif ($type === 'playground-resource') {
            $params['--roles-action'] = [
                'publisher',
                'manager',
                'admin',
                'root',
            ];
            $params['--roles-view'] = [
                'user',
                'staff',
                'publisher',
                'manager',
                'admin',
                'root',
            ];
        } elseif ($type === 'playground-api') {
            $params['--roles-action'] = [
                'publisher',
                'manager',
                'admin',
                'root',
            ];
            $params['--roles-view'] = [
                'user',
                'staff',
                'publisher',
                'manager',
                'admin',
                'root',
            ];
        }

        if (empty($this->call('playground:make:policy', $params))) {

            $path_resources_packages = $this->getResourcePackageFolder();

            $file = sprintf(
                '%1$s%2$s/%3$s/policy.json',
                $this->laravel->storagePath(),
                $path_resources_packages,
                Str::of($name)->kebab()
            );

            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$file' => $file,
            //     '$path_resources_packages' => $path_resources_packages,
            //     '$this->configuration' => $this->configuration,
            //     '$this->laravel->storagePath()' => $this->laravel->storagePath(),
            // ]);

            if (! in_array($file, $this->c->policies())) {
                $this->c->policies()[] = $file;
            }
        }
    }
}
