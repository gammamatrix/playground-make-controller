<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Building;

/**
 * \Playground\Make\Controller\Building\Controller\MakeCommands
 */
trait MakeCommands
{
    /**
     * @param array<int, string> $policies
     */
    public function handle_policies(array $policies): void
    {
        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        $modelFile = $this->getModelFile();

        if ($this->hasOption('model-file') && $this->option('model-file')) {
            $params['--model-file'] = $this->option('model-file');
        } else {
            if ($modelFile) {
                $params['--model-file'] = $modelFile;
            }
        }

        foreach ($policies as $policy) {
            $params['--file'] = $policy;
            $this->call('playground:make:policy', $params);
        }

        // if (! class_exists($parentModelClass) &&
        //     confirm("A {$parentModelClass} model does not exist. Do you want to generate it?", default: true)) {
        //     $this->call('playground:make:model', ['name' => $parentModelClass]);
        // }
    }

    /**
     * @param array<int, string> $requests
     */
    public function handle_requests(array $requests): void
    {
        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        $modelFile = $this->getModelFile();

        if ($this->hasOption('model-file') && $this->option('model-file')) {
            $params['--model-file'] = $this->option('model-file');
        } else {
            if ($modelFile) {
                $params['--model-file'] = $modelFile;
            }
        }

        foreach ($requests as $request) {
            if (is_string($request) && $request) {
                $params['--file'] = $request;
                $this->call('playground:make:request', $params);
            }
        }
    }

    /**
     * @param array<int, string> $resources
     */
    public function handle_resources(array $resources): void
    {
        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        $modelFile = $this->getModelFile();

        if ($this->hasOption('model-file') && $this->option('model-file')) {
            $params['--model-file'] = $this->option('model-file');
        } else {
            if ($modelFile) {
                $params['--model-file'] = $modelFile;
            }
        }

        foreach ($resources as $resource) {
            $params['--file'] = $resource;
            $this->call('playground:make:resource', $params);
        }
    }

    /**
     * @param array<int, string> $transformers
     */
    public function handle_transformers(array $transformers): void
    {
        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        $modelFile = $this->getModelFile();

        if ($this->hasOption('model-file') && $this->option('model-file')) {
            $params['--model-file'] = $this->option('model-file');
        } else {
            if ($modelFile) {
                $params['--model-file'] = $modelFile;
            }
        }

        foreach ($transformers as $transformer) {
            $params['--file'] = $transformer;
            $this->call('playground:make:transformer', $params);
        }
    }
}
