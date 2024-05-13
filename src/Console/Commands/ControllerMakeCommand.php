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

    // use Building\Skeletons\BuildPostman;
    use Building\Skeletons\BuildController;

    // use Building\Skeletons\BuildExtends;
    use Building\Skeletons\BuildPackageInfo;
    use Building\Skeletons\BuildPolicies;
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
        'abstract' => '',
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

        'model_attribute' => 'title',
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

    public function prepareOptions(): void
    {
        $options = $this->options();

        $initModel = false;

        if ($this->hasOption('abstract') && $this->option('abstract')) {
            $this->c->setOptions([
                'isAbstract' => true,
            ]);
            $this->searches['abstract'] = 'abstract ';
        }

        if ($this->hasOption('blade') && $this->option('blade')) {
            $this->c->setOptions([
                'withBlades' => true,
            ]);
        }

        if ($this->hasOption('policies') && $this->option('policies')) {
            $this->c->setOptions([
                'withPolicies' => true,
            ]);
        }

        if ($this->hasOption('requests') && $this->option('requests')) {
            $this->c->setOptions([
                'withRequests' => true,
            ]);
        }

        if ($this->hasOption('routes') && $this->option('routes')) {
            $this->c->setOptions([
                'withRoutes' => true,
            ]);
        }

        if ($this->hasOption('swagger') && $this->option('swagger')) {
            $this->c->setOptions([
                'withSwagger' => true,
            ]);
        }

        if ($this->hasOption('test') && $this->option('test')) {
            $this->c->setOptions([
                'withTests' => true,
            ]);
        }

        if ($this->hasOption('playground') && $this->option('playground')) {
            $this->c->setOptions([
                'playground' => true,
            ]);
        }

        $this->prepareOptionsType($options);

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

            $modelFile = $this->getModelFile();
            if ($modelFile && $this->model?->name()) {
                $this->c->addMappedClassTo(
                    'models',
                    $this->model->name(),
                    $modelFile
                );
            }
        }

        $this->prepareOptionsExtends($options);

        $this->prepareOptionsSlugs($options);

        $this->prepareOptionsRoute($options);

        $this->preparePackageInfo($options);

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->getModelFile()' => $this->getModelFile(),
        //     '$initModel' => $initModel,
        //     '$this->c->type()' => $this->c->type(),
        //     '$this->c->skeleton()' => $this->c->skeleton(),
        //     '$this->c' => $this->c,
        //     // '$this->model' => $this->model,
        //     '$this->searches' => $this->searches,
        //     // '$this->arguments()' => $this->arguments(),
        //     '$this->options()' => $this->options(),
        // ]);
    }

    protected function getConfigurationFilename(): string
    {
        if ($this->c->type() === 'base') {
            return 'controller.base.json';

        } else {
            return sprintf(
                '%1$s/%2$s.json',
                Str::of($this->c->name())->before('Controller')->kebab(),
                Str::of($this->getType())->kebab(),
            );
        }
    }

    /**
     * @var array<int, string>
     */
    protected array $options_type_suggested = [
        'base',
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
        $type = $this->c->type();
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

        if ($type === 'base') {
            $template = 'controller/base.stub';
        } elseif ($type === 'fractal-api') {
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
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        // ]);

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
            ['blade',           null, InputOption::VALUE_NONE,     'Generate Blade templates for controller routes'],
            ['type',            null, InputOption::VALUE_REQUIRED, 'Manually specify the controller stub file to use'],
            ['force',           null, InputOption::VALUE_NONE,     'Create the class even if the controller already exists'],
            ['abstract',        null, InputOption::VALUE_NONE,     'Make the controller abstract'],
            ['skeleton',        null, InputOption::VALUE_NONE,     'Create the skeleton for the controller type'],
            ['test',            null, InputOption::VALUE_NONE,     'Create a test for the controller type'],
            ['invokable',       'i',  InputOption::VALUE_NONE,     'Generate a single method, invokable controller class'],
            ['model',           'm',  InputOption::VALUE_OPTIONAL, 'Generate a resource controller for the given model'],
            ['module',          null, InputOption::VALUE_OPTIONAL, 'The module that the '.strtolower($this->type).' belongs to'],
            ['parent',          'p', InputOption::VALUE_OPTIONAL,  'Generate a nested resource controller class'],
            ['playground',      null, InputOption::VALUE_NONE,     'Create a Playground controller'],
            ['resource',        'r', InputOption::VALUE_NONE,      'Generate a resource controller class'],
            ['policies',        null, InputOption::VALUE_NONE,     'Generate policies for CRUD'],
            ['requests',        'R', InputOption::VALUE_NONE,      'Generate FormRequest classes for store and update'],
            ['routes',          null, InputOption::VALUE_NONE,     'Generate routes for controllers'],
            ['swagger',         null, InputOption::VALUE_NONE,     'Generate Swagger documentation for routes and models'],
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
