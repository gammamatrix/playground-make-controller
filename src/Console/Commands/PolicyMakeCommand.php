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
use Playground\Make\Controller\Configuration\Policy as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

use function Laravel\Prompts\suggest;

/**
 * \Playground\Make\Controller\Console\Commands\PolicyMakeCommand
 */
#[AsCommand(name: 'playground:make:policy')]
class PolicyMakeCommand extends GeneratorCommand
{
    use Building\Policy\BuildRoles;
    use Concerns\BuildModel;

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

        $type = $this->getConfigurationType();

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
        return $this->parseClassInput($rootNamespace).'\\Policies';
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

        return $options;
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
