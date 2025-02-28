<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Console\Commands;

// use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Support\Str;
use Playground\Make\Building\Concerns;
use Playground\Make\Configuration\Contracts\PrimaryConfiguration as PrimaryConfigurationContract;
use Playground\Make\Console\Commands\GeneratorCommand;
use Playground\Make\Controller\Building;
use Playground\Make\Controller\Configuration\Policy as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

// use function Laravel\Prompts\suggest;

/**
 * \Playground\Make\Controller\Console\Commands\PolicyMakeCommand
 */
#[AsCommand(name: 'playground:make:policy')]
class PolicyMakeCommand extends GeneratorCommand
{
    use Building\Policy\BuildRevisions;
    use Building\Policy\BuildRoles;
    use Concerns\BuildModel;
    use Concerns\BuildUses;
    // use CreatesMatchingTest;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var PrimaryConfigurationContract&Configuration
     */
    protected PrimaryConfigurationContract $c;

    const SEARCH = [
        'class' => '',
        'module' => '',
        'module_slug' => '',
        'namespace' => '',
        'organization' => '',
        'namespacedModel' => '',
        'NamespacedDummyUserModel' => '',
        'namespacedUserModel' => '',
        'user' => '',
        'model' => '',
        'modelVariable' => '',
        'rolesForAction' => '',
        'rolesToView' => '',
        'revisions' => '',
        'use' => '',
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new policy class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Policy';

    protected string $path_destination_folder = 'src/Policies';

    public function prepareOptions(): void
    {
        $options = $this->options();
        $revision = $this->hasOption('revision') && $this->option('revision');

        if (! empty($options['model-file'])) {
            $this->initModel($this->c->skeleton());
        }

        if ($this->hasOption('test') && $this->option('test')) {
            $this->c->setOptions([
                'withTests' => true,
            ]);
        }

        $type = $this->c->type();

        if (! empty($options['roles-action'])) {
            foreach ($options['roles-action'] as $role) {
                if (is_string($role)
                    && $role
                    && ! in_array($role, $this->c->rolesForAction())
                ) {
                    $this->c->addRoleForAction($role);
                }
            }
        }
        if (! empty($options['roles-view'])) {
            foreach ($options['roles-view'] as $role) {
                if (is_string($role)
                    && $role
                    && ! in_array($role, $this->c->rolesToView())
                ) {
                    $this->c->addRoleToView($role);
                }
            }
        }

        if ($revision) {
            $this->make_revision_handling();
        }
        // $this->applyConfigurationToSearch();

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$this->searches' => $this->searches,
        //     '$this->c' => $this->c,
        //     // '$this->model' => $this->model,
        //     '$this->c->type()' => $this->c->type(),
        //     // '$this->c->toArray()' => $this->c->toArray(),
        // ]);
    }

    protected function getConfigurationFilename(): string
    {
        return sprintf(
            '%1$s/%2$s.json',
            Str::of($this->c->name())->kebab(),
            Str::of($this->getType())->kebab(),
        );
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     */
    protected function buildClass($name): string
    {
        $this->buildClass_user_model();

        $this->buildClass_model($name);

        $this->make_roles_to_view($this->searches);
        $this->make_roles_for_action($this->searches);

        return parent::buildClass($name);
    }

    protected function buildClass_user_model(): void
    {
        $upm = $this->userProviderModel();
        if (empty($this->searches[$this->laravel->getNamespace().'User'])) {
            $this->searches[$this->laravel->getNamespace().'User'] = $upm;
        }

        $this->searches['NamespacedDummyUserModel'] = $upm;
        $this->searches['namespacedUserModel'] = $upm;
    }

    protected function userProviderModelGuard(mixed $guard): string
    {
        $guardProvider = is_string($guard) && $guard ? config('auth.guards.'.$guard.'.provider') : null;

        if (! $guard || ! $guardProvider) {

            throw new \RuntimeException(__('playground-make-controller::generator.Policy.guard.required', [
                'guard' => is_string($guard) ? $guard : gettype($guard),
            ]));
        }

        return is_string($guardProvider) ? $guardProvider : '';
    }

    public function finish(): ?bool
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->withTests()' => $this->c->withTests(),
        // ]);
        if ($this->c->withTests()) {
            $this->createTest();
        }

        $this->saveConfiguration();

        return $this->return_status;
    }

    /**
     * Get the model for the guard's user provider.
     *
     * @throws \RuntimeException
     */
    protected function userProviderModel(): string
    {
        $guard = $this->option('guard') ?: config('auth.defaults.guard');
        $guardProvider = $this->userProviderModelGuard($guard);

        $upm = $guardProvider ? config('auth.providers.'.$guardProvider.'.model') : null;

        return $upm && is_string($upm) ? $upm : 'App\\Models\\User';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $template = 'policy/policy.stub';

        $type = $this->getConfigurationType();

        if ($type === 'playground-resource') {
            $template = 'policy/policy.playground-resource.stub';
        } elseif ($type === 'playground-api') {
            $template = 'policy/policy.playground-api.stub';
        } elseif ($type === 'api') {
            $template = 'policy/policy.api.stub';
        } elseif ($type === 'resource') {
            $template = 'policy/policy.resource.stub';
        }

        return $this->resolveStubPath($template);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return Str::of(
            $this->parseClassInput($rootNamespace)
        )->finish('\\')->finish('Policies')->toString();
    }

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        $options[] = ['guard', 'g', InputOption::VALUE_OPTIONAL, 'The guard that the policy relies on'];
        $options[] = ['roles-action', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'The roles for action.'];
        $options[] = ['roles-view', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'The roles to view.'];
        $options[] = ['test', null, InputOption::VALUE_NONE, 'Create a test for the policy'];
        $options[] = ['revision', null, InputOption::VALUE_NONE, 'Enable revisions for the '.strtolower($this->type).' type'];

        return $options;
    }

    public function createTest(): void
    {
        $type = $this->c->type();

        if (in_array($type, [
            'abstract',
        ])) {
        } elseif (in_array($type, [
            'playground-api',
            'playground-resource',
        ])) {
            $this->command_tests_playground_policy();
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        //     '$this->options()' => $this->options(),
        // ]);

    }

    public function command_tests_playground_policy(): void
    {
        $withCovers = $this->hasOption('covers') && $this->option('covers');
        $force = $this->hasOption('force') && $this->option('force');
        $model = $this->hasOption('model') ? $this->option('model') : '';

        $options = [
            'name' => 'PolicyTest',
            // '--namespace' => $this->c->namespace(),
            '--namespace' => $this->rootNamespace(),
            '--force' => $force,
            '--playground' => true,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--model' => $model,
            '--module' => $this->c->module(),
            '--type' => 'policy',
        ];

        $modelFile = $this->getModelFile();

        if ($this->hasOption('model-file') && $this->option('model-file')) {
            $options['--model-file'] = $this->option('model-file');
        } else {
            if ($modelFile) {
                $options['--model-file'] = $modelFile;
            }
        }

        if ($withCovers) {
            $options['--covers'] = true;
        }

        if ($this->c->skeleton()) {
            $options['--skeleton'] = true;
        }

        $options['--suite'] = 'unit';

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);

        $this->call('playground:make:test', $options);

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$this->options()' => $this->options(),
        // ]);
    }

    // /**
    //  * Interact further with the user if they were prompted for missing arguments.
    //  *
    //  * @return void
    //  */
    // protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output)
    // {
    //     $name = $this->getNameInput();
    //     if (($name && $this->isReservedName($name)) || $this->didReceiveOptions($input)) {
    //         return;
    //     }

    //     $model = suggest(
    //         'What model should this policy apply to? (Optional)',
    //         $this->possibleModels(),
    //     );

    //     if ($model) {
    //         $input->setOption('model', $model);
    //     }
    // }

    // /**
    //  * Get a list of possible model names.
    //  *
    //  * @return array<int, string>
    //  */
    // protected function possibleModels(): array
    // {
    //     $modelPath = is_dir(app_path('Models')) ? app_path('Models') : app_path();

    //     return [];
    //     // return collect((new Finder)->files()->depth(0)->in($modelPath))
    //     //     ->map(fn ($file) => $file->getBasename('.php'))
    //     //     ->sort()
    //     //     ->values()
    //     //     ->all();
    // }
}
