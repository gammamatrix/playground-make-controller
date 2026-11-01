<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Make\Controller\Configuration\Controller;

use Playground\Make\Configuration;

/**
 * \Playground\Make\Controller\Configuration\Controller\Action
 */
class Action extends Configuration\Configuration
{
    protected string $method = '';

    /**
     * @var array<string, Lifecycle[]>
     */
    protected array $lifecycles = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'method' => '',
    ];

    /**
     * @param  array<string, mixed>  $options
     */
    public function setOptions(array $options = []): self
    {
        if (! empty($options)) {
            $this->lifecycles = [];
            foreach ($options as $lifecycle => $meta) {
                if (is_string($lifecycle)
                    && ! empty($lifecycle)
                    && is_array($meta)
                    && ! empty($meta)
                ) {
                    $this->lifecycles[$lifecycle] = [];
                    foreach ($meta as $options) {
                        if (! empty($options)
                            && is_array($options)
                        ) {
                            $this->lifecycles[$lifecycle][] = new Lifecycle($options);
                        }
                    }
                }
            }
        }

        return $this;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return array<string, Lifecycle[]>
     */
    public function lifecycles(): array
    {
        return $this->lifecycles;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function type(): string
    {
        return $this->type;
    }
}
