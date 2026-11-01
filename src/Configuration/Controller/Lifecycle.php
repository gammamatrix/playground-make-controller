<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Make\Controller\Configuration\Controller;

use Playground\Make\Configuration;
use Playground\Make\Controller\Configuration\Controller;

/**
 * \Playground\Make\Controller\Configuration\Controller\Lifecycle
 */
class Lifecycle extends Configuration\Configuration
{
    /**
     * @var string[]
     */
    protected array $comments = [];

    protected string $extends = '';

    protected string $class = '';

    protected string $method = '';

    /**
     * @var string[]
     */
    protected array $implements = [];

    // new|self|static|this,
    protected string $instance = '';

    protected string $type = '';

    /**
     * @var string[]
     */
    protected array $use_class = [];

    /**
     * @var string[]
     */
    protected array $uses = [];

    /**
     * @var array<string, array{type: string, variable: string}>
     */
    protected array $params = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'class' => '',
        'comments' => [],
        'extends' => '',
        'method' => '',
        'implements' => [],
        'instance' => '',
        'type' => '',
        'use_class' => [],
        'params' => [],
        'uses' => [],
    ];

    /**
     * @param  array<string, mixed>  $options
     */
    public function setOptions(array $options = []): self
    {
        if (! empty($options['comments'])
            && is_array($options['comments'])
        ) {
            $this->comments = [];
            foreach ($options['comments'] as $comment) {
                if (is_string($comment)) {
                    $this->comments[] = $comment;
                }
            }
            $this->properties['comments'] = $this->comments;
        }

        if (! empty($options['extends'])
            && is_string($options['extends'])
        ) {
            $this->extends = $options['extends'];
            $this->properties['extends'] = $this->extends;
        }

        if (! empty($options['instance'])
            && is_string($options['instance'])
            && in_array($options['instance'], [
                'new',
                'self',
                'static',
                'this',
            ])
        ) {
            $this->instance = $options['instance'];
            $this->properties['instance'] = $this->instance;
        }

        if (! empty($options['class'])
            && is_string($options['class'])
        ) {
            $this->class = $options['class'];
        }

        if (! empty($options['method'])
            && is_string($options['method'])
        ) {
            $this->method = $options['method'];
        }

        if (! empty($options['implements'])
            && is_array($options['implements'])
        ) {
            $this->implements = [];
            foreach ($options['implements'] as $implement) {
                if (is_string($implement)) {
                    $this->implements[] = $implement;
                }
            }
            $this->properties['implements'] = $this->implements;
        }

        if (! empty($options['type'])
            && is_string($options['type'])
        ) {
            $this->type = $options['type'];
            $this->properties['type'] = $this->type;
        }

        if (! empty($options['use_class'])
            && is_array($options['use_class'])
        ) {
            $this->use_class = [];
            foreach ($options['use_class'] as $use_class) {
                if (is_string($use_class)) {
                    $this->use_class[] = $use_class;
                }
            }
            $this->properties['use_class'] = $this->use_class;
        }

        if (! empty($options['uses'])
            && is_array($options['uses'])
        ) {
            $this->uses = [];
            foreach ($options['uses'] as $uses) {
                if (is_string($uses)) {
                    $this->uses[] = $uses;
                }
            }
            $this->properties['uses'] = $this->uses;
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$this' => $this,
        // ]);

        return $this;
    }

    public function class(): string
    {
        return $this->class;
    }

    /**
     * @return string[]
     */
    public function comments(): array
    {
        return $this->comments;
    }

    public function extends(): string
    {
        return $this->extends;
    }

    public function instance(): string
    {
        return $this->instance;
    }

    /**
     * @return string[]
     */
    public function implements(): array
    {
        return $this->implements;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return string[]
     */
    public function use_class(): array
    {
        return $this->use_class;
    }

    /**
     * @return string[]
     */
    public function uses(): array
    {
        return $this->uses;
    }

    /**
     * @return array<string, array{type: string, variable: string}>
     */
    public function params(): array
    {
        return $this->params;
    }

    public function render(Controller $controller): string
    {
        $indent = 8;
        $comments = $this->comments();
        $params = $this->params();
        $method = $this->method();
        $type = $this->type();
        $code = PHP_EOL;

        if (count($comments) === 1) {
            $code .= sprintf('%1$s// %2$s%3$s', str_repeat(' ', $indent), current($comments), PHP_EOL);
        } elseif (! empty($comments)) {
            $code .= sprintf('%1$s/*%2$s', str_repeat(' ', $indent), PHP_EOL);
            foreach ($comments as $comment) {
                $code .= sprintf('%1$s * %2$s%3$s', str_repeat(' ', $indent), $comment, PHP_EOL);
            }
            $code .= sprintf('%1$s */%2$s', str_repeat(' ', $indent), PHP_EOL);
        }

        if (empty($params)) {
            if ($type === 'handler') {
                $params[] = [
                    'type' => $controller->model(),
                    'variable' => $controller->model_variable(),
                ];
            }
        }

        $renderParams = '';
        foreach ($params as $param) {
            $renderParams .= sprintf('$%1$s, ', $param['variable']);
        }
        $renderParams = rtrim($renderParams, ', ');

        if ($this->instance() === 'new') {
            $code .= sprintf(
                '%1$snew %2$s%3$s%4$s%5$s%6$s%7$s%8$s;',
                str_repeat(' ', $indent),
                $this->class() ?: 'ReplaceMe',
                empty($renderParams) ? '' : '(',
                $renderParams,
                empty($renderParams) ? '' : ')',
                empty($method) ? '->' : '',
                $method,
                empty($method) ? '' : '()',
            );
        } elseif ($this->instance() === 'self') {
            $code .= sprintf(
                '%1$sself::%2$s%3$s%4$s%5$s;',
                str_repeat(' ', $indent),
                $method,
                empty($renderParams) ? '' : '(',
                $renderParams,
                empty($renderParams) ? '' : ')',
            );
        } elseif ($this->instance() === 'static') {
            $code .= sprintf(
                '%1$sstatic::%2$s%3$s%4$s%5$s;',
                str_repeat(' ', $indent),
                $method,
                empty($renderParams) ? '' : '(',
                $renderParams,
                empty($renderParams) ? '' : ')',
            );
        } elseif ($this->instance() === 'this') {
            $code .= sprintf(
                '%1$s$this->%2$s%3$s%4$s%5$s;',
                str_repeat(' ', $indent),
                $method,
                empty($renderParams) ? '' : '(',
                $renderParams,
                empty($renderParams) ? '' : ')',
            );
        } else {
            $code .= sprintf(
                '%1$s%2$s%3$s%4$s%5$s;',
                str_repeat(' ', $indent),
                $method,
                empty($renderParams) ? '' : '(',
                $renderParams,
                empty($renderParams) ? '' : ')',
            );
        }

        return $code.PHP_EOL;
    }
}
