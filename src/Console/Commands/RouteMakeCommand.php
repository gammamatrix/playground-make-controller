<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Console\Commands;

use Illuminate\Support\Str;
use Playground\Make\Configuration\Contracts\PrimaryConfiguration as PrimaryConfigurationContract;
use Playground\Make\Console\Commands\GeneratorCommand;
use Playground\Make\Controller\Configuration\Route as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * \Playground\Make\Controller\Console\Commands\RouteMakeCommand
 */
#[AsCommand(name: 'playground:make:route')]
class RouteMakeCommand extends GeneratorCommand
{
    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var PrimaryConfigurationContract&Configuration
     */
    protected PrimaryConfigurationContract $c;

    const SEARCH = [
        'route' => '',
        // 'base_route' => 'welcome',
        'extends' => '',
        'class' => '',
        'controller' => '',
        'folder' => '',
        'namespace' => '',
        'organization' => '',
        'namespacedModel' => '',
        'NamespacedDummyUserModel' => '',
        'namespacedUserModel' => '',
        'user' => '',
        'model' => '',
        'modelVariable' => '',
        'model_column' => '',
        'model_label' => '',
        'model_slug_plural' => '',
        'module' => '',
        'module_slug' => '',
        'title' => '',
        'package' => '',
        'config' => '',
        'route_prefix' => '',
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new route group';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Route';

    protected string $path_destination_folder = 'routes';

    public function prepareOptions(): void
    {
        $options = $this->options();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        // ]);

        $type = $this->getConfigurationType();

        if (! empty($options['route']) && is_string($options['route'])) {
            $this->c->setOptions([
                'route' => $options['route'],
            ]);
            $this->searches['route'] = $this->c->route();
        }

        if (! empty($options['prefix']) && is_string($options['prefix'])) {
            // NOTE this might need slash handling
            $this->c->setOptions([
                'route_prefix' => $options['prefix'],
            ]);
            $this->searches['route_prefix'] = $this->c->route_prefix();
        }

        // if (! empty($options['title']) && is_string($options['title'])) {
        //     $this->c->setOptions([
        //         'title' => $options['title'],
        //     ]);
        //     $this->searches['title'] = $this->c->title();
        // }

        if (in_array($type, [
            'playground-api',
            'playground-resource',
        ])) {
            $this->initModel($this->c->skeleton());
            if (! $this->model) {
                throw new \RuntimeException('Provide a [--model-file] with a [create] section.');
            }
        }

        $model = $this->model;

        $model_column = $this->c->model_column();
        $model_fqdn = $this->c->model_fqdn();
        $model_label = $this->c->model_label();
        $model_slug = $this->c->model_slug();
        $model_slug_plural = $this->c->model_slug_plural();

        if ($model) {
            if (! $model_column) {
                $model_column = Str::of($model->model_slug())->snake()->replace('-', '_')->toString();
            }
            if (! $model_fqdn) {
                $model_fqdn = $model->fqdn();
            }
            if (! $model_label) {
                $model_label = Str::of($model->name())->title()->toString();
            }
            if (! $model_slug) {
                $model_slug = $model->model_slug();
            }
            if (! $model_slug_plural) {
                $model_slug_plural = Str::of($model_slug)->plural()->toString();
            }
        }

        $this->c->setOptions([
            'model_column' => $model_column,
            'model_fqdn' => $model_fqdn,
            'model_label' => $model_label,
            'model_slug' => $model_slug,
            'model_slug_plural' => $model_slug_plural,
        ]);

        $this->searches['model_column'] = $this->c->model_column();
        $this->searches['model_fqdn'] = $this->parseClassInput($this->c->model_fqdn());
        $this->searches['model_label'] = $this->c->model_label();
        $this->searches['model_slug'] = $this->c->model_slug();
        $this->searches['model_slug_plural'] = $this->c->model_slug_plural();

        if ($type === 'playground-resource-index') {
            $this->c->setOptions([
                'class' => $this->c->module_slug(),
                'route_prefix' => sprintf(
                    'resource/%1$s',
                    $this->c->module_slug()
                ),
            ]);
        } elseif ($type === 'playground-resource') {
            $this->c->setOptions([
                'class' => $this->c->module_slug(),
                'route_prefix' => sprintf(
                    'resource/%1$s/%2$s',
                    $this->c->module_slug(),
                    $this->c->model_slug_plural()
                ),
            ]);
        } elseif ($type === 'playground-api') {
            $this->c->setOptions([
                'class' => $this->c->model_slug_plural(),
                'route_prefix' => sprintf(
                    'api/%1$s/%2$s',
                    $this->c->module_slug(),
                    $this->c->model_slug_plural()
                ),
            ]);
        } else {
            $this->c->setOptions([
                'class' => $this->c->model_column(),
                'route_prefix' => $this->c->module_slug(),
            ]);
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        // ]);
    }

    protected function getConfigurationFilename(): string
    {
        // if (in_array($this->c->type(), ['playground-resource-index'])) {
        //     return sprintf(
        //         '%1$s.%2$s.json',
        //         Str::of($this->getType())->kebab(),
        //         Str::of($this->c->name())->kebab(),
        //     );
        // } else {
        return sprintf(
            '%1$s/%2$s.json',
            Str::of($this->c->name())->kebab(),
            Str::of($this->getType())->kebab(),
        );
        // }
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     */
    protected function qualifyClass($name): string
    {
        $type = $this->getConfigurationType();

        if (! $this->c->folder()) {
            $this->c->setOptions([
                'folder' => Str::of($name)->kebab()->toString(),
            ]);
            $this->searches['folder'] = $this->c->folder();
        }

        // if (! $this->c->model_column()) {

        //     $this->c->setOptions([
        //         'model_column' => Str::of($name)->snake()->replace('-', '_')->toString(),
        //         'model_label' => Str::of($name)->title()->toString(),
        //         'model_slug_plural' => Str::of($this->c->model_column())->plural()->toString(),
        //     ]);

        //     $this->searches['model_column'] = $this->c->model_column();
        //     $this->searches['model_label'] = $this->c->model_label();
        //     $this->searches['model_slug_plural'] = $this->c->model_slug_plural();
        // }

        $this->c->setOptions([
            'controller' => Str::of($name)->studly()->finish('Controller')->toString(),
        ]);

        $this->searches['controller'] = $this->c->controller();
        $this->searches['route_prefix'] = $this->c->route_prefix();

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$name' => $name,
        //     '$type' => $type,
        //     '$this->c->class()' => $this->c->class(),
        //     // '$this->c' => $this->c,
        //     // '$this->searches' => $this->searches,
        //     // '$this->options()' => $this->options(),
        // ]);
        return $this->c->class();
    }

    // protected ?string $options_type_default = 'site';

    /**
     * @var array<int, string>
     */
    protected array $options_type_suggested = [
        'site',
        'playground-resource-index',
        'playground-resource',
        'playground-api',
    ];

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        $route = 'route/site.php.stub';

        $type = $this->getConfigurationType();

        if ($type === 'playground-resource-index') {
            $route = 'route/playground-resource-index.php.stub';
        } elseif ($type === 'playground-api') {
            $route = 'route/playground-api.php.stub';
        } elseif ($type === 'playground-resource') {
            $route = 'route/playground-resource.php.stub';
        }

        return $this->resolveStubPath($route);
    }

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        // $options = parent::getOptions();
        $options = [
            ['force',           'f',  InputOption::VALUE_NONE,     'Create the class even if the '.strtolower($this->type).' already exists'],
            ['interactive',     'i',  InputOption::VALUE_NONE,     'Use interactive mode to create the class even for the '.strtolower($this->type)],
            ['model',           'm',  InputOption::VALUE_OPTIONAL, 'The model that the '.strtolower($this->type).' applies to'],
            ['module',          null, InputOption::VALUE_OPTIONAL, 'The module that the '.strtolower($this->type).' belongs to'],
            ['namespace',       null, InputOption::VALUE_OPTIONAL, 'The namespace of the '.strtolower($this->type)],
            ['type',            null, InputOption::VALUE_OPTIONAL, 'The configuration type of the '.strtolower($this->type), $this->options_type_default, $this->options_type_suggested],
            ['organization',    null, InputOption::VALUE_OPTIONAL, 'The organization of the '.strtolower($this->type)],
            ['package',         null, InputOption::VALUE_OPTIONAL, 'The package of the '.strtolower($this->type)],
            ['preload',         null,  InputOption::VALUE_NONE,    'Preload the existing configuration file for the '.strtolower($this->type)],
            ['skeleton',        null, InputOption::VALUE_NONE,     'Create the skeleton for the '.strtolower($this->type).' type'],
            // ['class',           null, InputOption::VALUE_OPTIONAL, 'The class name of the '.strtolower($this->type)],
            // ['extends',         null, InputOption::VALUE_OPTIONAL, 'The class that gets extended for the '.strtolower($this->type)],
            ['file',            null, InputOption::VALUE_OPTIONAL, 'The configuration file of the '.strtolower($this->type)],
            ['model-file',      null, InputOption::VALUE_OPTIONAL, 'The configuration file of the model for the '.strtolower($this->type)],
        ];

        $options[] = ['route', null, InputOption::VALUE_OPTIONAL, 'The base route for breadcrumbs.'];
        // $options[] = ['title', null, InputOption::VALUE_OPTIONAL, 'The title of the base route for breadcrumbs.'];
        $options[] = ['prefix', null, InputOption::VALUE_OPTIONAL, 'The prefix slug for the route.'];

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);
        return $options;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     */
    protected function getPath($name): string
    {
        $name = $this->c->name();

        if (in_array($this->c->type(), [
            'api',
            'playground-api',
            'playground-api',
            'resource',
            'resource-index',
            'playground-resource-index',
            'playground-resource',
        ])) {
            $name = Str::of($name)->plural()->kebab()->toString();
        } else {
            $name = Str::of($name)->kebab()->toString();
        }

        $path = sprintf(
            '%1$s/%2$s.php',
            $this->folder(),
            $name
        );

        return $this->laravel->storagePath().$path;
    }
}
