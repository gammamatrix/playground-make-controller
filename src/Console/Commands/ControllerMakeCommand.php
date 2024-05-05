<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Console\Commands;

use Illuminate\Support\Str;
use Playground\Make\Building\Concerns;
use Playground\Make\Configuration\Contracts\PrimaryConfiguration as PrimaryConfigurationContract;
use Playground\Make\Console\Commands\GeneratorCommand;
use Playground\Make\Controller\Building;
use Playground\Make\Controller\Configuration\Controller as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

// use function Laravel\Prompts\confirm;
// use function Laravel\Prompts\select;
// use function Laravel\Prompts\suggest;

/**
 * \Playground\Make\Controller\Console\Commands\ControllerMakeCommand
 */
#[AsCommand(name: 'playground:make:controller')]
class ControllerMakeCommand extends GeneratorCommand
{
    use Building\MakeCommands;
    use Building\Skeletons\BuildPolicies;

    // use Building\Skeletons\BuildPostman;
    use Building\Skeletons\BuildRequests;
    use Building\Skeletons\BuildResources;
    use Building\Skeletons\BuildRoutes;
    use Building\Skeletons\BuildSwagger;
    use Building\Skeletons\BuildTemplates;
    use Concerns\BuildImplements;
    use Concerns\BuildModel;
    use Concerns\BuildUses;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var PrimaryConfigurationContract&Configuration
     */
    protected PrimaryConfigurationContract $c;

    const SEARCH = [
        'namespace' => '',
        'class' => '',
        'module' => '',
        'module_slug' => '',
        'extends' => '',
        'extends_use' => '',
        'implements' => '',
        'use' => '',
        'use_class' => '',
        'constants' => '',
        'properties' => '',
        'relationships' => '',
        'methods' => '',
        'actions' => '',
        'organization' => '',
        'namespacedModel' => '',
        'namespacedRequest' => '',
        'namespacedResource' => '',
        'NamespacedDummyUserModel' => '',
        'namespacedUserModel' => '',
        'user' => '',
        'model' => '',
        'modelLabel' => '',
        'modelVariable' => '',
        'modelVariablePlural' => '',
        'modelSlugPlural' => '',
        'slug' => '',
        'slug_plural' => '',
        'route' => '',
        // 'view' => '',

        // 'model_attribute'     => 'label',
        // 'model_label'         => 'Backlog',
        // 'model_label_plural'  => 'Backlogs',
        // 'model_route'         => '{{route}}',
        // 'model_slug'          => 'backlog',
        // 'model_slug_plural'   => 'backlogs',
        // 'module_label'        => 'Matrix',
        // 'module_label_plural' => 'Matrix',
        // 'module_route'        => 'matrix.resource',
        // 'module_slug'         => 'matrix',
        // 'table'               => 'matrix_backlogs',
        // 'view'                => 'playground-matrix-resource::backlog',

        'model_attribute' => 'label',
        'model_label' => '',
        'model_label_plural' => '',
        'model_route' => '',
        'model_slug' => '',
        'model_slug_plural' => '',
        'module_label' => '',
        'module_label_plural' => '',
        'module_route' => '',
        // 'module_slug' => '',
        'table' => '',
        'view' => '',

    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    protected string $path_destination_folder = 'src/Http/Controllers';

    // protected bool $skeleton = false;

    public function prepareOptions(): void
    {
        $options = $this->options();

        $initModel = false;

        if ($this->option('playground')) {
            $this->c->setOptions([
                'playground' => true,
            ]);
        }

        if (! $this->option('type')) {

            $type = '';

            if ($this->c->playground()) {
                if ($this->option('api')) {
                    $type = 'playground-api';
                } elseif ($this->option('resource')) {
                    $type = 'playground-resource';
                }
            } else {
                if ($this->option('api')) {
                    $type = 'api';
                } elseif ($this->option('resource')) {
                    $type = 'resource';
                }
            }

            if ($type) {
                $this->c->setOptions([
                    'type' => $type,
                ]);
            }

        } else {
            $type = $this->getConfigurationType();
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        //     // '$this->arguments()' => $this->arguments(),
        //     '$this->options()' => $this->options(),
        // ]);

        if (in_array($this->c->type(), [
            'api',
            'playground-api',
            'resource',
            'playground-resource',
        ])) {
            $initModel = true;
        }

        if ($initModel) {
            $this->initModel($this->c->skeleton());
        }

        // Extends

        if (! empty($options['extends']) && is_string($options['extends'])) {

            $extends_use = $this->parseClassInput($options['extends']);
            $extends = class_basename($extends_use);

            if ($extends_use === $extends) {
                $this->c->setOptions([
                    'extends' => $extends,
                    'extends_use' => '',
                ]);
            } else {
                $this->c->setOptions([
                    'extends' => $extends,
                    'extends_use' => $extends_use,
                ]);
            }
        }

        if (! $this->c->extends()) {
            $this->c->setOptions([
                'extends' => 'Controller',
                // 'extends_use' => 'App/Http/Controllers/Controller',
                'extends_use' => '',
            ]);
        }

        $this->searches['extends_use'] = $this->parseClassInput($this->c->extends_use());
        $this->searches['extends'] = $this->parseClassInput($this->c->extends());

        // Slug
        if (empty($this->c->slug()) || ! is_string($this->c->slug())) {
            if (! empty($options['slug']) && is_string($options['slug'])) {
                $this->c->setOptions([
                    'slug' => Str::of($options['slug'])->slug('-')->toString(),
                ]);
            } elseif (! empty($this->c->name()) && is_string($this->c->name())) {
                $this->c->setOptions([
                    'slug' => Str::of($this->c->name())->slug('-')->toString(),
                    'slug_plural' => Str::of($this->c->name())->slug('-')->toString(),
                ]);
                $this->searches['slug'] = $this->c->slug();
                $this->searches['slug_plural'] = $this->c->slug_plural();
            }
        }

        // Route

        if (! empty($options['route']) && is_string($options['route'])) {
            $this->c->setOptions([
                'route' => $options['route'],
            ]);
            $this->searches['route'] = $this->c->route();
        }

        if (empty($this->c->route()) || ! is_string($this->c->route())) {

            $route = '';

            // if (!empty($this->c->namespace()) && is_string($this->c->namespace())) {
            //     foreach (Str::of($this->c->namespace())->replace('\\', '.')->replace('/', '.')->explode('.') as $value) {
            //         if (!empty($route)) {
            //             $route .= '.';
            //         }
            //         $route .= Str::of($value)->slug('-');
            //     };
            // }
            if (! empty($this->c->package()) && is_string($this->c->package())) {
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
                'route' => $route,
            ]);

            $this->searches['route'] = $this->c->route();
        }

        // View

        if (! empty($options['view']) && is_string($options['view'])) {
            $this->c->setOptions([
                'view' => $options['view'],
            ]);
            $this->searches['view'] = $this->c->view();
        }

        if (empty($this->c->view()) || ! is_string($this->c->view())) {

            $view = sprintf(
                '%1$s::%2$s',
                $this->c->package(),
                $this->c->slug()
            );

            // if (!empty($this->c->namespace()) && is_string($this->c->namespace())) {
            //     foreach (Str::of($this->c->namespace())->replace('\\', '.')->replace('/', '.')->explode('.') as $value) {
            //         if (!empty($view)) {
            //             $view .= '.';
            //         }
            //         $view .= Str::of($value)->slug('-');
            //     };
            // }

            // if (!empty($this->c->slug_plural())) {
            //     $view .= '.'.$this->c->slug_plural();

            // } elseif (!empty($this->c->slug())) {
            //     $view .= '.'.$this->c->slug();
            // }

            $this->c->setOptions([
                'view' => $view,
            ]);
            $this->searches['view'] = $this->c->view();

        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        //     '$this->arguments()' => $this->arguments(),
        //     '$this->options()' => $this->options(),
        // ]);
    }

    protected function getConfigurationFilename(): string
    {
        return sprintf(
            '%1$s/%2$s.json',
            Str::of($this->c->name())->before('Controller')->kebab(),
            Str::of($this->getType())->kebab(),
        );
    }

    /**
     * @var array<int, string>
     */
    protected array $options_type_suggested = [
        // 'abstract',
        // 'playground',
        'api',
        'fractal-api',
        'playground-api',
        'resource',
        'fractal-resource',
        'playground-resource',
    ];

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        $type = $this->getConfigurationType();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->searches' => $this->searches,
        //     '$this->c' => $this->c,
        //     '$this->arguments()' => $this->arguments(),
        //     '$this->options()' => $this->options(),
        //     '$type' => $type,
        //     // '$this->option(type)' => $this->option('type'),
        // ]);

        $template = 'controller/controller.stub';

        if ($type === 'fractal-api') {
            $template = 'controller/controller.api.fractal.stub';
        } elseif ($type === 'api') {
            $template = 'controller/controller.api.stub';
        } elseif ($type === 'playground-api') {
            $template = 'controller/controller.api.stub';
        } elseif ($type === 'playground-resource') {
            $template = 'controller/controller.resource.stub';
        } elseif ($type === 'fractal-resource') {
            $template = 'controller/controller.resource.fractal.stub';
        } elseif ($type === 'resource') {
            $template = 'controller/controller.resource.stub';
        }

        return $this->resolveStubPath($template);

        // if ($type = $this->option('type')) {
        //     $stub = "/laravel/controller.{$type}.stub";
        // } elseif ($this->option('parent')) {
        //     $stub = $this->option('singleton')
        //                 ? '/laravel/controller.nested.singleton.stub'
        //                 : '/laravel/controller.nested.stub';
        // } elseif ($this->option('model')) {
        //     $stub = '/laravel/controller.model.stub';
        // } elseif ($this->option('invokable')) {
        //     $stub = '/laravel/controller.invokable.stub';
        // } elseif ($this->option('singleton')) {
        //     $stub = '/laravel/controller.singleton.stub';
        // } elseif ($this->option('resource')) {
        //     $stub = '/laravel/controller.stub';
        // }
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->parseClassInput($rootNamespace).'\\Http\\Controllers';

    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in the base namespace.
     *
     * @param  string  $name
     */
    protected function buildClass($name): string
    {
        $this->buildClass_model($name);

        $this->searches['namespacedRequest'] = $this->parseClassInput(sprintf(
            '%1$s\Http\Requests',
            rtrim($this->c->namespace(), '\\')
        ));

        $this->searches['namespacedResource'] = $this->parseClassInput(sprintf(
            '%1$s\Http\Resources',
            rtrim($this->c->namespace(), '\\')
        ));

        if (in_array($this->c->type(), [
            'resource',
            'playground-resource',
        ])) {
            // $this->buildClass_uses_add('GammaMatrix\Playground\Http\Controllers\Traits\IndexTrait', 'IndexTrait');
            // if (!in_array('GammaMatrix\Playground\Http\Controllers\Traits\IndexTrait', $this->configuration['uses'])) {
            //     $this->configuration['uses']['IndexTrait'] = 'GammaMatrix\Playground\Http\Controllers\Traits\IndexTrait';
            // }
        }

        $fqdn = $this->model?->fqdn();
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$name' => $name,
        //     '$fqdn' => $fqdn,
        // ]);
        if ($fqdn) {
            $this->buildClass_uses($fqdn);
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$name' => $name,
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        // ]);
        return parent::buildClass($name);
    }

    public function finish(): ?bool
    {
        if ($this->option('skeleton')) {
            $this->skeleton();

            $this->saveConfiguration();

            return $this->return_status;
        }

        if (! empty($this->c->policies()
            && is_array($this->c->policies())
        )) {
            // $this->handle_policies($this->c->policies());
        }

        if (! empty($this->c->requests())
            && is_array($this->c->requests())
        ) {
            // $this->handle_requests($this->c->requests());
        }

        if (! empty($this->c->resources())
            && is_array($this->c->resources())
        ) {
            // $this->handle_resources($this->c->resources());
        }

        // if (! empty($this->c->transformers())
        //     && is_array($this->c->transformers())
        // ) {
        //     $this->handle_transformers($this->c->transformers());
        // }

        $this->saveConfiguration();

        return $this->return_status;
    }

    /**
     * Execute the console command.
     */
    public function skeleton(): void
    {
        $type = $this->getConfigurationType();

        // $this->skeleton_requests($type);
        // $this->skeleton_policy($type);
        // $this->skeleton_resources($type);
        // $this->skeleton_routes($type);
        // $this->skeleton_templates($type);
        // $this->skeleton_swagger($type);

        $this->saveConfiguration();
    }

    protected function getConfigurationFilename_for_resource(string $name, string $type): string
    {
        return sprintf(
            '%1$s/resource%2$s.json',
            Str::of($name)->kebab(),
            $type === 'collection' ? '.collection' : ''
        );
    }

    /**
     * Get the console command options.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        return [
            ['api',             null, InputOption::VALUE_NONE,     'Exclude the create and edit methods from the controller'],
            ['type',            null, InputOption::VALUE_REQUIRED, 'Manually specify the controller stub file to use'],
            ['force',           null, InputOption::VALUE_NONE,     'Create the class even if the controller already exists'],
            ['skeleton',        null, InputOption::VALUE_NONE,     'Create the skeleton for the controller type'],
            ['invokable',       'i',  InputOption::VALUE_NONE,     'Generate a single method, invokable controller class'],
            ['model',           'm',  InputOption::VALUE_OPTIONAL, 'Generate a resource controller for the given model'],
            ['module',          null, InputOption::VALUE_OPTIONAL, 'The module that the '.strtolower($this->type).' belongs to'],
            ['parent',          'p', InputOption::VALUE_OPTIONAL,  'Generate a nested resource controller class'],
            ['playground',      null, InputOption::VALUE_NONE,     'Create a Playground controller'],
            ['resource',        'r', InputOption::VALUE_NONE,      'Generate a resource controller class'],
            ['requests',        'R', InputOption::VALUE_NONE,      'Generate FormRequest classes for store and update'],
            ['singleton',       's', InputOption::VALUE_NONE,      'Generate a singleton resource controller class'],
            ['creatable',       null, InputOption::VALUE_NONE,     'Indicate that a singleton resource should be creatable'],
            ['namespace',       null, InputOption::VALUE_OPTIONAL, 'The namespace of the '.strtolower($this->type)],
            ['organization',    null, InputOption::VALUE_OPTIONAL, 'The organization of the '.strtolower($this->type)],
            ['package',         null, InputOption::VALUE_OPTIONAL, 'The package of the '.strtolower($this->type)],
            ['class',           null, InputOption::VALUE_OPTIONAL, 'The class name of the '.strtolower($this->type)],
            ['extends',         null, InputOption::VALUE_OPTIONAL, 'The class that gets extended for the '.strtolower($this->type)],
            ['file',            null, InputOption::VALUE_OPTIONAL, 'The configuration file of the '.strtolower($this->type)],
            ['model-file',      null, InputOption::VALUE_OPTIONAL, 'The configuration file of the model for the '.strtolower($this->type)],
            ['slug',            null, InputOption::VALUE_OPTIONAL, 'The slug of the '.strtolower($this->type)],
            ['route',           null, InputOption::VALUE_OPTIONAL, 'The base route of the '.strtolower($this->type)],
            ['view',            null, InputOption::VALUE_OPTIONAL, 'The base view of the '.strtolower($this->type)],
        ];
    }

    // /**
    //  * Interact further with the user if they were prompted for missing arguments.
    //  *
    //  * @return void
    //  */
    // protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output)
    // {
    //     if ($this->didReceiveOptions($input)) {
    //         return;
    //     }

    //     $type = select('Which type of controller would you like?', [
    //         'empty' => 'Empty',
    //         'resource' => 'Resource',
    //         'singleton' => 'Singleton',
    //         'api' => 'API',
    //         'invokable' => 'Invokable',
    //     ]);

    //     if ($type !== 'empty') {
    //         $input->setOption($type, true);
    //     }

    //     if (in_array($type, ['api', 'resource', 'singleton'])) {
    //         $model = suggest(
    //             "What model should this $type controller be for? (Optional)",
    //             $this->possibleModels()
    //         );

    //         if ($model) {
    //             $input->setOption('model', $model);
    //         }
    //     }
    // }
}
