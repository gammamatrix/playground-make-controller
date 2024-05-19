<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Building\Skeletons;

use Illuminate\Support\Str;

/**
 * \Playground\Make\Controller\Building\Skeletons\BuildController
 */
trait BuildController
{
    /**
     * @param array<string, mixed> $options
     */
    protected function prepareOptionsSlugs(array $options = []): void
    {
        if (! $this->c->slug()) {
            if (! empty($options['slug']) && is_string($options['slug'])) {
                $this->c->setOptions([
                    'slug' => Str::of($options['slug'])->slug('-')->toString(),
                    'slug_plural' => Str::of($options['slug'])->plural()->slug('-')->toString(),
                ]);
            }
        }
        $this->searches['slug'] = $this->c->slug();
        $this->searches['slug_plural'] = $this->c->slug_plural();
    }

    /**
     * @param array<string, mixed> $options
     */
    protected function prepareOptionsExtends(array $options = []): void
    {
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
    }

    /**
     * @param array<string, mixed> $options
     */
    protected function prepareOptionsTypeDefault(array $options = []): string
    {
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

        return $type;
    }

    /**
     * @param array<string, mixed> $options
     */
    protected function prepareOptionsRoute(array $options = []): void
    {
        if (! empty($options['route']) && is_string($options['route'])) {
            $this->c->setOptions([
                'route' => $options['route'],
            ]);
            $this->searches['route'] = $this->c->route();
        }

        if (! $this->c->route()) {

            $route = '';

            if ($this->c->package()) {
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
    }
}
