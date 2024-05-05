<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Console\Commands;

use Illuminate\Support\Str;
use Playground\Make\Configuration\Contracts\PrimaryConfiguration as PrimaryConfigurationContract;
use Playground\Make\Console\Commands\GeneratorCommand;
use Playground\Make\Controller\Configuration\Resource as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * \Playground\Make\Controller\Console\Commands\ResourceMakeCommand
 */
#[AsCommand(name: 'playground:make:resource')]
class ResourceMakeCommand extends GeneratorCommand
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
        'class' => '',
        'class_keys' => '',
        'keys' => '',
        'module' => '',
        'module_slug' => '',
        'model_fqdn' => '',
        'model_slug' => '',
        'namespace' => 'App',
        'organization' => '',
        'package' => 'app',
        'extends' => 'JsonResource',
        'extends_use' => 'Illuminate\Http\Resources\Json\JsonResource',
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new resource';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Resource';

    protected string $path_destination_folder = 'src/Http/Resources';

    protected bool $collection = false;

    public function prepareOptions(): void
    {
        $options = $this->options();

        $type = $this->getConfigurationType();

        if ($this->collection()) {
            $this->type = 'Resource collection';
        }

        $this->initModel($this->c->skeleton());

        $model_fqdn = $this->c->model_fqdn();

        if (! $model_fqdn) {
            $model_fqdn = $this->model?->fqdn();
            $model_slug = $this->model?->model_slug();
            if ($model_fqdn) {
                $this->c->setOptions([
                    'model_fqdn' => $model_fqdn,
                    'model_slug' => $model_slug,
                ]);
            }
        }

        $this->searches['model_fqdn'] = $this->parseClassInput($this->c->model_fqdn());
        $this->searches['model_slug'] = $this->c->model_slug();

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$model_fqdn' => $model_fqdn,
        //     '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        //     '$this->arguments()' => $this->arguments(),
        //     '$this->options()' => $this->options(),
        // ]);
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        $type = $this->getConfigurationType();

        $template = 'resource/resource.stub';

        if ($type === 'abstract') {
            $template = 'resource/abstract.stub';
        } elseif ($type === 'abstract-keys') {
            $template = 'resource/abstract.keys.stub';
        } elseif ($type === 'keys') {
            $template = 'resource/resource.keys.stub';
        } elseif ($this->collection() | $type === 'collection') {
            $template = 'resource/collection.stub';
        }

        return $this->resolveStubPath($template);
    }

    /**
     * Determine if the command is generating a resource collection.
     */
    protected function collection(): bool
    {
        $this->collection = false;

        if ($this->option('collection')) {
            $this->collection = true;
        }

        if (str_ends_with($this->c->name(), 'Collection')) {
            $this->collection = true;
        }

        if (! empty($this->c->class())
            && str_ends_with($this->c->class(), 'Collection')
        ) {
            $this->collection = true;
        }

        $this->c->setOptions([
            'collection' => $this->collection,
        ]);

        $this->searches['extends'] = 'ResourceCollection';
        $this->searches['extends_use'] = 'Illuminate\Http\Resources\Json\ResourceCollection';

        return $this->collection;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->parseClassInput($rootNamespace).'\\Http\\Resources';
    }

    protected function getConfigurationFilename(): string
    {
        $type = $this->collection ? 'collection' : 'resource';

        return sprintf(
            '%1$s/%2$s.json',
            Str::of($this->c->name())->beforeLast('Collection')->kebab(),
            $type
        );
    }

    /**
     * @var array<int, string>
     */
    protected array $options_type_suggested = [
        'abstract',
        'keys',
        'collection',
    ];

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        $options[] = ['collection', null, InputOption::VALUE_NONE, 'Create a resource collection'];
        $options[] = ['skeleton', null, InputOption::VALUE_NONE, 'Create the skeleton for the resource type'];

        return $options;
    }
}
